<?php

namespace Tests\Feature;

use App\Models\PhysioContactDetails;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhysioDetailsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_gets_physio_details()
    {
        $this->withoutExceptionHandling();
        $user = $this->createUserAndLogin();
        PhysioContactDetails::create([
            'user_id' => $user->id,
            'name' => 'Physio',
            'email' => 'physio@gmail.com',
            'phone_number' => '0123489',
        ]);

        $expected = [
            'name' => 'Physio',
            'email' => 'physio@gmail.com',
            'phone_number' => '0123489',
        ];

        $response = $this->get('/contact-details');
        $response->assertStatus(200);

        $this->assertSame($expected, json_decode($response->getContent(), true));
    }
}
