<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\Curriculum;
use App\Models\ChildCurriculum;
use App\Models\Subject;
use App\Http\Resources\ChildwithParentResource;
use App\Http\Resources\ChildCurriculumResource;
use App\Http\Requests\StoreChildCurriculumRequest;

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
        $child = Child::with(['parent', 'applications', 'grades.subject', 'subjects'])
            ->findOrFail($childId);
        return response()->json(['data' => $child]);
    }

    public function addChildToCurriculum(Request $request)
    {

        $child = Child::findOrFail($request->child_id);
        $curriculum = Curriculum::with('subjects')->findOrFail($request->curriculum_id);


        $childCurriculum = ChildCurriculum::create([
            'child_id' => $child->id,
            'curriculum_id' => $curriculum->id
        ]);

        foreach ($curriculum->subjects as $subject) {
            $child->subjects()->attach($subject->id);
        }

        return response()->json(['message' => 'Child added to curriculum with subjects successfully'], 201);
    }



    public function getSubjectsByCurriculumAndChild($curriculumId, $childId)
    {
        $curriculum = Curriculum::with('subjects')->findOrFail($curriculumId);
        $child = Child::with('subjects')->findOrFail($childId);
        $childSubjects = $child->subjects()->whereIn('subjects.id', $curriculum->subjects->pluck('subjects.id'))->get();
        return response()->json([
            'message' => 'Subjects in curriculum and child retrieved successfully',
            'curriculum_id' => $curriculum->id,
            'curriculum_name' => $curriculum->name,
            'all_subjects' => $curriculum->subjects,
            'child_id' => $child->id,
            'child_name' => $child->name,
            'child_subjects' => $childSubjects
        ], 200);
    }

}
