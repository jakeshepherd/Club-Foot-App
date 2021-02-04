<?php

namespace Tests\Feature;

use App\Models\PhysioContactDetails;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PhysioDetailsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_gets_physio_details()
    {
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

    public function test_sets_physio_details()
    {
        $this->createUserAndLogin();
        $expected = [
            'name' => 'Physio',
            'email' => 'physio@gmail.com',
            'phone_number' => '0123489',
        ];

        $response = $this->post('/contact-details', $expected);
        $response->assertCreated();

        $actual = PhysioContactDetails::findOrFail(Auth::id())->get(['name', 'email', 'phone_number'])
            ->toArray();

        $this->assertSame([$expected], $actual);
    }

    public function test_it_updates_physio_details()
    {
        $user = $this->createUserAndLogin();
        PhysioContactDetails::create([
            'user_id' => $user->id,
            'name' => 'Physio',
            'email' => 'physio@gmail.com',
            'phone_number' => '0123489',
        ]);

        $expected = [
            'name' => 'Physio Test',
            'email' => 'physiotest@gmail.com',
            'phone_number' => '11111',
        ];

        $response = $this->post('/contact-details', $expected);
        $response->assertOk();

        $actual = PhysioContactDetails::findOrFail(Auth::id())->get(['name', 'email', 'phone_number'])
            ->toArray();

        $this->assertSame([$expected], $actual);
    }
}
