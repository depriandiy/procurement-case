<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApplicationConfigurationTest extends TestCase
{
    public function test_application_uses_portal_identity_and_indonesian_regional_defaults(): void
    {
        $this->assertSame('Portal Penawaran Supplier', config('app.name'));
        $this->assertSame('Asia/Jakarta', config('app.timezone'));
        $this->assertSame('id', config('app.locale'));
        $this->assertSame('id', config('app.fallback_locale'));
        $this->assertSame('id_ID', config('app.faker_locale'));
    }
}
