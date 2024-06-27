<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCurriculumRequest;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use App\Http\Resources\CurriculumResource;

class CurriculumController extends Controller
{
    public function index()
    {
        $curriculums = Curriculum::with(['subjects', 'activities'])->get();
        return CurriculumResource::collection($curriculums);
    }

    public function show($id)
    {
        $curriculum = Curriculum::with(['subjects', 'activities'])->find($id);
        if (!$curriculum) {
            return response()->json(['message' => 'Curriculum not found'], 404);
        }
        return new CurriculumResource($curriculum);
    }

    public function store(StoreCurriculumRequest $request)
    {
        $curriculum = Curriculum::create($request->validated());
        return response()->json($curriculum, 201);
    }

    public function update(StoreCurriculumRequest $request, $id)
    {
        $curriculum = Curriculum::find($id);
        if (!$curriculum) {
            return response()->json(['message' => 'Curriculum not found'], 404);
        }

        $curriculum->update($request->validated());
        return response()->json($curriculum);
    }

    public function destroy($id)
    {
        $curriculum = Curriculum::find($id);
        if (!$curriculum) {
            return response()->json(['message' => 'Curriculum not found'], 404);
        }

        $curriculum->delete();
        return response()->json(['message' => 'Curriculum deleted successfully']);
    }
}
