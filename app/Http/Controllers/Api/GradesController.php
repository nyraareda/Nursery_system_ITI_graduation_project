<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGradeRequest;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Resources\GradeResource;

class GradesController extends Controller
{
    public function index()
    {
        $grades = Grade::with('subject')->get();
        return GradeResource::collection($grades);
    }

    public function show($id)
    {
        $grade = Grade::with('subject')->find($id);
        if (!$grade) {
            return response()->json(['message' => 'Grade not found'], 404);
        }
        return new GradeResource($grade);
    }

    public function store(StoreGradeRequest $request)
    {
        $grade = Grade::create($request->validated());
        return new GradeResource($grade);
    }

    public function update(StoreGradeRequest $request, $id)
    {
        $grade = Grade::find($id);
        if (!$grade) {
            return response()->json(['message' => 'Grade not found'], 404);
        }

        $grade->update($request->validated());
        return new GradeResource($grade);
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

    public function getGradesByChild($child_id)
    {
        $grades = Grade::with('subject')->where('child_id', $child_id)->get();

        if ($grades->isEmpty()) {
            return response()->json(['message' => 'No grades found for this child.'], 404);
        }

        return GradeResource::collection($grades);
    }
}
