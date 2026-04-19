<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunityHubTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_community_hub_is_publicly_accessible(): void
    {
        $response = $this->get('/community');

        $response->assertOk();
        $response->assertSee('Community Hub');
        $response->assertSee('Explore discussions');
    }
}
