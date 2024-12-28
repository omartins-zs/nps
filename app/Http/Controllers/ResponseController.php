<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'survey_id' => 'required|exists:surveys,id',
            'score' => 'required|integer|between:0,10',
            'comment' => 'nullable|string',
        ]);

        $response = Response::create($request->all());
        return response()->json($response, 201);
    }

    public function showBySurvey($surveyId)
    {
        $responses = Response::where('survey_id', $surveyId)->get();
        return response()->json($responses);
    }
}
