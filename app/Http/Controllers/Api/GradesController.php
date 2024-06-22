<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;
use Illuminate\Http\Request;

class GradesController extends Controller
{
    public function index()
    {
        $grades = Grade::all();
        return response()->json($grades);
    }

    public function show($id)
    {
        $grade = Grade::find($id);
        if (!$grade) {
            return response()->json(['message' => 'Grade not found'], 404);
        }
        return response()->json($grade);
    }

    public function store(StoreGradeRequest $request)
    {
        $grade = Grade::create($request->validated());
        return response()->json($grade, 201);
    }

    public function update(StoreGradeRequest $request, $id)
    {
        $grade = Grade::find($id);
        if (!$grade) {
            return response()->json(['message' => 'Grade not found'], 404);
        }

        $grade->update($request->validated());
        return response()->json($grade);
    }

    public function destroy($id)
    {
        $grade = Grade::find($id);
        if (!$grade) {
            return response()->json(['message' => 'Grade not found'], 404);
        }

        $grade->delete();
        return response()->json(['message' => 'Grade deleted successfully']);
    }

}
