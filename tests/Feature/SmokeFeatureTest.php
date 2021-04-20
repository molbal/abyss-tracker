<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SmokeFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_home()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_profile_veetor() {
        $response = $this->get(route('profile.index', ['id' => 93940047]));
        $response->assertStatus(200);
        $response->assertSee("Veetor Nara");
    }
}
