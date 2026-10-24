<?php

namespace Tests\Feature\Domain;

use App\Models\CatalogItem;
use App\Models\FollowUp;
use App\Models\ItemAlias;
use App\Models\Submission;
use App\Models\SubmissionItem;
use App\Models\SubmissionItemMappingHistory;
use App\Models\SubmissionStatusHistory;
use App\Models\SubmissionSupplierLinkHistory;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProcurementSupportDomainTest extends TestCase
{
    use RefreshDatabase;

    public function test_procurement_support_schema_records_mapping_status_and_follow_up(): void
    {
        $this->assertTrue(Schema::hasColumns('item_aliases', [
            'supplier_id',
            'catalog_item_id',
            'alias',
            'normalized_alias',
            'raw_unit',
            'normalized_unit',
            'conversion_factor',
            'is_active',
        ]));
        $this->assertTrue(Schema::hasColumns('submission_status_histories', [
            'submission_id',
            'from_status',
            'to_status',
            'changed_by',
            'note',
        ]));
        $this->assertTrue(Schema::hasColumns('follow_ups', [
            'submission_id',
            'user_id',
            'type',
            'body',
            'due_at',
            'completed_at',
        ]));
        $this->assertTrue(Schema::hasColumns('submission_supplier_link_histories', [
            'submission_id',
            'from_supplier_id',
            'to_supplier_id',
            'changed_by',
            'reason',
        ]));
        $this->assertTrue(Schema::hasColumns('submission_item_mapping_histories', [
            'submission_item_id',
            'from_catalog_item_id',
            'to_catalog_item_id',
            'from_unit_id',
            'to_unit_id',
            'conversion_factor',
            'changed_by',
            'note',
        ]));
    }

    public function test_procurement_support_records_belong_to_their_domain_objects(): void
    {
        $user = User::factory()->create();
        $supplier = Supplier::factory()->create();
        $catalogItem = CatalogItem::factory()->create();
        $alias = ItemAlias::factory()->for($supplier)->for($catalogItem)->create();
        $submission = Submission::factory()->create(['supplier_id' => $supplier->id]);
        $submissionItem = SubmissionItem::factory()->for($submission)->create();
        $status = SubmissionStatusHistory::factory()
            ->for($submission)
            ->for($user, 'changedBy')
            ->create();
        $followUp = FollowUp::factory()->for($submission)->for($user)->create();
        $supplierLink = SubmissionSupplierLinkHistory::factory()
            ->for($submission)
            ->for($supplier, 'toSupplier')
            ->for($user, 'changedBy')
            ->create();
        $mapping = SubmissionItemMappingHistory::factory()
            ->for($submissionItem)
            ->for($catalogItem, 'toCatalogItem')
            ->for($catalogItem->baseUnit, 'toUnit')
            ->for($user, 'changedBy')
            ->create();

        $this->assertTrue($alias->supplier->is($supplier));
        $this->assertTrue($alias->catalogItem->is($catalogItem));
        $this->assertTrue($submission->statusHistories->contains($status));
        $this->assertTrue($submission->followUps->contains($followUp));
        $this->assertTrue($submission->supplierLinkHistories->contains($supplierLink));
        $this->assertTrue($submissionItem->mappingHistories->contains($mapping));
        $this->assertTrue($status->changedBy->is($user));
        $this->assertTrue($followUp->user->is($user));
    }

    public function test_deleting_a_submission_removes_its_procurement_activity(): void
    {
        $submission = Submission::factory()->create();
        $submissionItem = SubmissionItem::factory()->for($submission)->create();
        $status = SubmissionStatusHistory::factory()->for($submission)->create();
        $followUp = FollowUp::factory()->for($submission)->create();
        $supplierLink = SubmissionSupplierLinkHistory::factory()->for($submission)->create();
        $mapping = SubmissionItemMappingHistory::factory()->for($submissionItem)->create();

        $submission->delete();

        $this->assertModelMissing($status);
        $this->assertModelMissing($followUp);
        $this->assertModelMissing($supplierLink);
        $this->assertModelMissing($mapping);
    }
}
