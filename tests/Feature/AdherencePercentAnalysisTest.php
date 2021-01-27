<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdherencePercentAnalysisTest extends TestCase
{
    public function test_it_can_get_percent_adherence_for_week()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
