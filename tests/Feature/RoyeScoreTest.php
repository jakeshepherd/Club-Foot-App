<?php

namespace Tests\Feature;

use App\Models\OutcomeQuestionnaireResult;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RoyeScoreTest extends TestCase
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
    public function test_it_fails_without_all_answers()
    {
        $this->createUserAndLogin();
        $response = $this->post('/roye-outcome-questionnaire', [
            'questionnaire_data' => [
                0 => 1,
                1 => 2,
                3 => 1,
                4 => 4,
                5 => 1,
                6 => 1,
                7 => 1,
                8 => 1,
            ]
        ]);
        $response->assertStatus(400);
        $this->assertSame('"Please answer every question."', $response->getContent());
    }

    public function test_it_can_get_all_outcomes_for_user()
    {
        $this->withoutExceptionHandling();
        $this->createUserAndLogin();

        $expected = [
            [
                0 => 1,
                1 => 1,
                2 => 1,
                3 => 1,
                4 => 1,
                5 => 1,
                6 => 1,
                7 => 1,
                8 => 1,
                9 => 1,
            ], [
                0 => 2,
                1 => 2,
                2 => 2,
                3 => 2,
                4 => 2,
                5 => 2,
                6 => 2,
                7 => 2,
                8 => 2,
                9 => 2,
            ]
        ];

        OutcomeQuestionnaireResult::create([
            'user_id' => Auth::id(),
            'questionnaire_id' => 0,
            'questionnaire_data' => json_encode($expected[0]),
        ]);

        $startTime = Carbon::parse('+1 day');
        Carbon::setTestNow($startTime);

        OutcomeQuestionnaireResult::create([
            'user_id' => Auth::id(),
            'questionnaire_id' => 0,
            'questionnaire_data' => json_encode($expected[1]),
        ]);

        $response = $this->get('/outcome-results');
        $response->assertOk();

        $results = json_decode($response->getContent(), true);

        $count = 0;
        foreach($results as $key => $value) {
            $squareBracketsRemoved = str_replace(["[", "]"], "", $value);
            $actual = explode(",", $squareBracketsRemoved);
            $this->assertEquals($expected[$count], $actual);
            $count++;
        }
    }
}
