<?php

namespace Tests\Feature;

use App\Models\OutcomeQuestionnaireResult;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class StoreRoyeScoreTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_stores_data()
    {
        $this->createUserAndLogin();
        $expected = [
            'questionnaire_data' => [
                0 => 1,
                1 => 2,
                3 => 1,
                4 => 4,
                5 => 1,
                6 => 1,
                7 => 1,
                8 => 1,
                9 => 1,
            ]
        ];
        $response = $this->post('/roye-outcome-questionnaire', $expected);
        $response->assertCreated();

        $actual = OutcomeQuestionnaireResult::findOrFail(Auth::id())->get('questionnaire_data')->toArray();

        $this->assertSame(
            $expected['questionnaire_data'],
            json_decode($actual[0]['questionnaire_data'], true)
        );
    }

    // test for multiple on the same day
    public function test_does_not_allow_multiple_results_same_day()
    {
        $this->createUserAndLogin();
        $expected = [
            'questionnaire_data' => [
                0 => 1,
                1 => 2,
                3 => 1,
                4 => 4,
                5 => 1,
                6 => 1,
                7 => 1,
                8 => 1,
                9 => 1,
            ]
        ];
        $this->post('/roye-outcome-questionnaire', $expected);

        $response = $this->post('/roye-outcome-questionnaire', [
            'questionnaire_data' => [
                0 => 3,
                1 => 3,
                3 => 3,
                4 => 3,
                5 => 3,
                6 => 3,
                7 => 3,
                8 => 3,
                9 => 3,
            ]
        ]);
        $response->assertStatus(409);

        $actual = OutcomeQuestionnaireResult::findOrFail(Auth::id())->get('questionnaire_data')->toArray();

        $this->assertSame(
            $expected['questionnaire_data'],
            json_decode($actual[0]['questionnaire_data'], true)
        );
    }

    //test for weird data
}
