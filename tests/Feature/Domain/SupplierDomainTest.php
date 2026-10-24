<?php

namespace Tests\Feature\Domain;

use App\Models\Supplier;
use App\Models\SupplierContact;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\TestCase;

class SupplierDomainTest extends TestCase
{
    use RefreshDatabase;

    public function test_supplier_schema_stores_companies_and_sales_contacts(): void
    {
        $this->assertTrue(Schema::hasColumns('suppliers', [
            'public_id',
            'name',
            'normalized_name',
            'tax_id',
            'normalized_tax_id',
            'address',
            'city',
            'review_status',
            'is_active',
        ]));

        $this->assertTrue(Schema::hasColumns('supplier_contacts', [
            'supplier_id',
            'name',
            'email',
            'normalized_email',
            'phone',
            'normalized_phone',
            'is_primary',
            'is_active',
        ]));
    }

    public function test_supplier_can_have_multiple_sales_contacts(): void
    {
        $supplier = Supplier::query()->create([
            'name' => 'PT Maju Jaya',
            'normalized_name' => 'pt maju jaya',
        ]);
        $firstContact = SupplierContact::query()->create([
            'supplier_id' => $supplier->id,
            'name' => 'Andi',
            'email' => 'andi@example.com',
            'normalized_email' => 'andi@example.com',
            'is_primary' => true,
        ]);
        $secondContact = SupplierContact::query()->create([
            'supplier_id' => $supplier->id,
            'name' => 'Sari',
            'email' => 'sari@example.com',
            'normalized_email' => 'sari@example.com',
        ]);

        $this->assertTrue(Str::isUlid($supplier->public_id));
        $this->assertCount(2, $supplier->contacts);
        $this->assertTrue($supplier->contacts->contains($firstContact));
        $this->assertTrue($supplier->contacts->contains($secondContact));
        $this->assertTrue($firstContact->supplier->is($supplier));
        $this->assertTrue($firstContact->is_primary);
        $this->assertTrue($secondContact->is_active);
    }

    public function test_supplier_factories_apply_identity_normalization(): void
    {
        $supplier = Supplier::factory()->create([
            'name' => ' PT. Maju   Jaya ',
            'tax_id' => '12.345.678.9-012.345',
        ]);
        $contact = SupplierContact::factory()->for($supplier)->create([
            'email' => ' Sales@Example.COM ',
            'phone' => '+62 812-3456-7890',
        ]);

        $this->assertSame('pt maju jaya', $supplier->normalized_name);
        $this->assertSame('123456789012345', $supplier->normalized_tax_id);
        $this->assertSame('sales@example.com', $contact->normalized_email);
        $this->assertSame('6281234567890', $contact->normalized_phone);
    }

    public function test_multiple_suppliers_without_tax_id_are_allowed(): void
    {
        Supplier::factory()->count(2)->create(['tax_id' => null]);

        $this->assertSame(2, Supplier::query()->whereNull('normalized_tax_id')->count());
    }

    public function test_same_normalized_tax_id_cannot_be_used_twice(): void
    {
        Supplier::factory()->create(['tax_id' => '12.345.678.9-012.345']);

        $this->expectException(QueryException::class);

        Supplier::factory()->create(['tax_id' => '123456789012345']);
    }

    public function test_same_contact_email_is_allowed_for_different_suppliers(): void
    {
        SupplierContact::factory()->create(['email' => 'shared@example.com']);
        SupplierContact::factory()->create(['email' => 'SHARED@example.com']);

        $this->assertSame(2, SupplierContact::query()
            ->where('normalized_email', 'shared@example.com')
            ->count());
    }

    public function test_same_normalized_contact_email_cannot_repeat_for_one_supplier(): void
    {
        $supplier = Supplier::factory()->create();
        SupplierContact::factory()->for($supplier)->create(['email' => 'sales@example.com']);

        $this->expectException(QueryException::class);

        SupplierContact::factory()->for($supplier)->create(['email' => 'SALES@example.com']);
    }
}
