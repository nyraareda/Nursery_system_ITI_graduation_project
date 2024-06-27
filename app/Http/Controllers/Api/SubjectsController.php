<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Resources\SubjectResource;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('curriculum')->get();
        return SubjectResource::collection($subjects);
    }

    public function show($id)
    {
        $subject = Subject::find($id);
        if (!$subject) {
            return response()->json(['message' => 'Subject not found'], 404);
        }
        return new SubjectResource($subject);
    }

    public function store(StoreSubjectRequest $request)
    {
        $subject = Subject::create($request->validated());
        // $subject->load('curriculum');
        return new SubjectResource($subject);
    }

    public function update(StoreSubjectRequest $request, $id)
    {
        $subject = Subject::find($id);
        if (!$subject) {
            return response()->json(['message' => 'Subject not found'], 404);
        }

        $subject->update($request->validated());
        // $subject->load('curriculum');
        return new SubjectResource($subject);
    }

    public function destroy($id)
    {
        $subject = Subject::find($id);
        if (!$subject) {
            return response()->json(['message' => 'Subject not found'], 404);
        }

        $subject->delete();
        return response()->json(['message' => 'Subject deleted successfully']);
    }

    public function getByLevel($levelId)
    {
        $subjects = Subject::where('level_id', $levelId)->get();
        return response()->json($subjects);
    }
}
