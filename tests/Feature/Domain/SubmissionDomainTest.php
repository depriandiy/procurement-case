<?php

namespace Tests\Feature\Domain;

use App\Models\Submission;
use App\Models\SubmissionItem;
use App\Models\Supplier;
use App\Models\SupplierContact;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\TestCase;

class SubmissionDomainTest extends TestCase
{
    use RefreshDatabase;

    public function test_submission_schema_keeps_offer_and_item_snapshots(): void
    {
        $this->assertTrue(Schema::hasColumns('submissions', [
            'public_token',
            'reference_no',
            'supplier_id',
            'contact_id',
            'parent_id',
            'revision_no',
            'status',
            'submitted_at',
            'valid_until',
            'currency',
            'verification_code',
            'client_token',
            'supplier_name',
            'supplier_tax_id',
            'supplier_address',
            'contact_name',
            'contact_email',
            'contact_phone',
        ]));

        $this->assertTrue(Schema::hasColumns('submission_items', [
            'submission_id',
            'line_no',
            'catalog_item_id',
            'base_unit_id',
            'raw_item_name',
            'raw_unit',
            'offered_price',
            'price_includes_tax',
            'tax_rate',
            'conversion_factor',
            'price_excl_tax',
            'normalized_unit_price',
            'moq',
            'lead_time_days',
            'notes',
        ]));
    }

    public function test_submission_relates_supplier_contact_and_ordered_items(): void
    {
        $supplier = Supplier::factory()->create();
        $contact = SupplierContact::factory()->for($supplier)->create();
        $submission = Submission::query()->create([
            'reference_no' => 'KDI-20261024-0001',
            'supplier_id' => $supplier->id,
            'contact_id' => $contact->id,
            'valid_until' => '2026-11-24',
            'verification_code' => str_repeat('a', 64),
            'supplier_name' => $supplier->name,
            'supplier_tax_id' => $supplier->tax_id,
            'supplier_address' => $supplier->address,
            'contact_name' => $contact->name,
            'contact_email' => $contact->email,
            'contact_phone' => $contact->phone,
        ]);
        $item = SubmissionItem::query()->create([
            'submission_id' => $submission->id,
            'line_no' => 1,
            'raw_item_name' => 'Beras Premium 20 kg',
            'raw_unit' => 'dus',
            'offered_price' => '220000.0000',
            'price_includes_tax' => true,
            'tax_rate' => '11.00',
            'moq' => '10.0000',
            'lead_time_days' => 3,
        ]);

        $this->assertTrue(Str::isUlid($submission->public_token));
        $this->assertTrue(Str::isUlid($submission->client_token));
        $this->assertTrue($submission->supplier->is($supplier));
        $this->assertTrue($submission->contact->is($contact));
        $this->assertTrue($supplier->submissions->contains($submission));
        $this->assertTrue($contact->submissions->contains($submission));
        $this->assertTrue($submission->items->contains($item));
        $this->assertTrue($item->submission->is($submission));
        $this->assertSame('220000.0000', $item->offered_price);
        $this->assertTrue($item->price_includes_tax);
        $this->assertSame('2026-11-24', $submission->valid_until->toDateString());
    }

    public function test_submission_factory_creates_historical_snapshot_and_items(): void
    {
        $submission = Submission::factory()
            ->has(
                SubmissionItem::factory()->count(2)->sequence(
                    ['line_no' => 1],
                    ['line_no' => 2],
                ),
                'items',
            )
            ->create();

        $this->assertNotEmpty($submission->supplier_name);
        $this->assertNotEmpty($submission->contact_name);
        $this->assertNotEmpty($submission->reference_no);
        $this->assertCount(2, $submission->items);
        $this->assertSame([1, 2], $submission->items->pluck('line_no')->all());
    }

    public function test_master_data_changes_do_not_rewrite_submission_snapshots(): void
    {
        $supplier = Supplier::factory()->create(['name' => 'PT Nama Lama']);
        $contact = SupplierContact::factory()->for($supplier)->create(['name' => 'Sales Lama']);
        $submission = Submission::factory()->create([
            'supplier_id' => $supplier->id,
            'contact_id' => $contact->id,
            'supplier_name' => $supplier->name,
            'contact_name' => $contact->name,
        ]);

        $supplier->update(['name' => 'PT Nama Baru']);
        $contact->update(['name' => 'Sales Baru']);

        $this->assertSame('PT Nama Lama', $submission->refresh()->supplier_name);
        $this->assertSame('Sales Lama', $submission->contact_name);
        $this->assertSame('PT Nama Baru', $submission->supplier->name);
        $this->assertSame('Sales Baru', $submission->contact->name);
    }

    public function test_supplier_can_have_separate_repeated_submissions(): void
    {
        $supplier = Supplier::factory()->create();
        $contact = SupplierContact::factory()->for($supplier)->create();

        Submission::factory()->count(2)->create([
            'supplier_id' => $supplier->id,
            'contact_id' => $contact->id,
        ]);

        $this->assertCount(2, $supplier->submissions);
        $this->assertCount(2, $contact->submissions);
    }

    public function test_deleting_submission_removes_its_items(): void
    {
        $submission = Submission::factory()->create();
        SubmissionItem::factory()->for($submission)->create();

        $submission->delete();

        $this->assertDatabaseCount('submissions', 0);
        $this->assertDatabaseCount('submission_items', 0);
    }

    public function test_line_number_is_unique_within_one_submission(): void
    {
        $submission = Submission::factory()->create();
        SubmissionItem::factory()->for($submission)->create(['line_no' => 1]);

        $this->expectException(QueryException::class);

        SubmissionItem::factory()->for($submission)->create(['line_no' => 1]);
    }
}
