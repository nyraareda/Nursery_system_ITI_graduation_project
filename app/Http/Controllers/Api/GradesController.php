<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;
use Illuminate\Http\Request;
use App\Http\Resources\GradeWithSubjectResource;
use Illuminate\Support\Facades\Validator;

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

    public function getGradesByChild($child_id)
    {
        $grades = Grade::with('subject')->where('child_id', $child_id)->get();

        if ($grades->isEmpty()) {
            return response()->json(['message' => 'No grades found for this child.'], 404);
        }

        return GradeWithSubjectResource::collection($grades);
    }

    public function updateGradesByChild(Request $request, $child_id)
    {
        $validator = Validator::make($request->all(), [
            '*.id' => 'required|exists:grades,id',
            '*.subject_id' => 'required|exists:subjects,id',
            '*.grade' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $gradesData = $request->all();

        foreach ($gradesData as $gradeData) {
            $grade = Grade::where('child_id', $child_id)
                ->where('id', $gradeData['id'])
                ->first();

            if ($grade) {
                $grade->update([
                    'subject_id' => $gradeData['subject_id'],
                    'grade' => $gradeData['grade']
                ]);
            }
        }

        $updatedGrades = Grade::with('subject')->where('child_id', $child_id)->get();

        return GradeWithSubjectResource::collection($updatedGrades);
    }
}

