<?php

namespace Tests\Unit;

use App\Support\SupplierIdentityNormalizer;
use PHPUnit\Framework\TestCase;

class SupplierIdentityNormalizerTest extends TestCase
{
    public function test_it_normalizes_supplier_identity_values_consistently(): void
    {
        $normalizer = new SupplierIdentityNormalizer;

        $this->assertSame('pt maju jaya', $normalizer->companyName('  PT. Maju   Jaya  '));
        $this->assertSame('123456789012345', $normalizer->taxId('12.345.678.9-012.345'));
        $this->assertSame('sales@example.com', $normalizer->email(' Sales@Example.COM '));
        $this->assertSame('6281234567890', $normalizer->phone('+62 812-3456-7890'));
    }

    public function test_optional_identity_values_remain_null_when_blank(): void
    {
        $normalizer = new SupplierIdentityNormalizer;

        $this->assertNull($normalizer->taxId(null));
        $this->assertNull($normalizer->taxId('  '));
        $this->assertNull($normalizer->email(''));
        $this->assertNull($normalizer->phone('---'));
    }
}
