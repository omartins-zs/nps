<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        return response()->json(Survey::with('department')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        $survey = Survey::create($request->all());
        return response()->json($survey, 201);
    }

    public function show($id)
    {
        $survey = Survey::with('responses')->findOrFail($id);
        return response()->json($survey);
    }

    public function update(Request $request, $id)
    {
        $survey = Survey::findOrFail($id);
        $survey->update($request->all());
        return response()->json($survey);
    }

    public function destroy($id)
    {
        $survey = Survey::findOrFail($id);
        $survey->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
