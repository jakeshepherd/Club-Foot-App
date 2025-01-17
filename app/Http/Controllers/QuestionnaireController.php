<?php

namespace App\Http\Controllers;

use App\Models\OutcomeQuestionnaireResult;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class QuestionnaireController extends Controller
{
    public function getAllResults(): JsonResponse
    {
        $results = OutcomeQuestionnaireResult::where('user_id', Auth::id())
            ->get(['created_at', 'questionnaire_data'])->toArray();

        $toReturn = [];
        foreach ($results as $result) {
            $toReturn[Carbon::parse($result['created_at'])->format('d-m-Y')] = $result['questionnaire_data'];
        }

        return response()->json($toReturn);
    }

    public function setRoyeScoreQuestionnaire(): JsonResponse
    {
        // check if there is a questionnaire submitted today already and exit early
        $thereIsARecordForCurrentDay = OutcomeQuestionnaireResult::where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->get();

        if (!$thereIsARecordForCurrentDay->isEmpty()) {
            Log::warning('Roye Score questionnaire already submitted today. Please try again tomorrow.');
            return response()->json(
                '⌛️ Roye Score questionnaire already submitted today. Please try again tomorrow.',
                409
            );
        }

        // now we can validate the request and add to database
        try {
            $this->validate(request(), [
                'questionnaire_data' => 'required'
            ]);
        } catch (ValidationException $e) {
            Log::error('questionnaire_data not specified in POST. Please try again.');
            return response()->json('Please answer every question.', 400);
        }

        if (count(request('questionnaire_data')) < 9) {
            Log::error('questionnaire_data too small, not all questions answered. Please try again.');
            return response()->json('Please answer every question.', 400);
        }

        OutcomeQuestionnaireResult::create([
            'user_id' => Auth::id(),
            'questionnaire_id' => 0,
            'questionnaire_data' => json_encode(request('questionnaire_data')),
        ]);

        return response()->json(true, 201);
    }
}
