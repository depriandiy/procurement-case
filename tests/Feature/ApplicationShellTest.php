<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApplicationShellTest extends TestCase
{
    public function test_home_page_uses_the_indonesian_portal_shell(): void
    {
        $response = $this->withoutVite()->get('/');

        $response
            ->assertOk()
            ->assertSee('lang="id"', escape: false)
            ->assertSee('Portal Penawaran Supplier')
            ->assertSee('Penawaran supplier yang lebih mudah ditinjau')
            ->assertDontSee('cdn.tailwindcss.com', escape: false)
            ->assertDontSee('fonts.bunny.net', escape: false);
    }
}
