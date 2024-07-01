<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreChildCurriculumRequest;
use App\Http\Resources\ChildwithParentResource;
use App\Http\Resources\ChildCurriculumResource;
use App\Models\ChildCurriculum;
use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use Illuminate\Http\Request;

class ChildCurriculumController extends Controller
{
    public function index()
    {
        return ChildCurriculumResource::collection(ChildCurriculum::all());
    }

    public function store(StoreChildCurriculumRequest $request)
    {

        $existsInAnyCurriculum = ChildCurriculum::where('child_id', $request->child_id)->exists();

        if ($existsInAnyCurriculum) {
            return response()->json(['message' => 'This child is already enrolled in a curriculum.'], 422);
        }


        $childCurriculum = ChildCurriculum::create($request->validated());


        $subjects = Subject::where('curriculum_id', $request->curriculum_id)->get();


        $childCurriculum->subjects()->attach($subjects->pluck('id'));

        return new ChildCurriculumResource($childCurriculum);
    }
    public function show(ChildCurriculum $childCurriculum)
    {
        return new ChildCurriculumResource($childCurriculum);
    }

    public function update(StoreChildCurriculumRequest $request, ChildCurriculum $childCurriculum)
    {
        $childCurriculum->update($request->validated());
        return new ChildCurriculumResource($childCurriculum);
    }

    public function destroy($id)
    {
        \Log::info('Destroy method called with ID: ' . $id);

        try {
            $childCurriculum = ChildCurriculum::findOrFail($id);
            \Log::info('ChildCurriculum found: ' . $childCurriculum);

            $childCurriculum->delete();
            \Log::info('ChildCurriculum deleted: ' . $id);

            return response()->noContent();
        } catch (\Exception $e) {
            \Log::error('Failed to delete ChildCurriculum: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to delete the record: ' . $e->getMessage()], 500);
        }
    }


    public function getChildrenByCurriculum($curriculumId)
    {
        $curriculum = Curriculum::with([
            'children.subjects',
            'children.grades',
            'children.parent.user',
            'children.applications'
        ])->findOrFail($curriculumId);

        return ChildwithParentResource::collection($curriculum->children);
    }

    public function getChildById($childId)
    {
        $child = Child::with(['parent', 'application', 'grades.subject', 'subjects'])
            ->findOrFail($childId);
        return response()->json(['data' => $child]);
    }
}


