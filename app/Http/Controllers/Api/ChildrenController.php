<?php

namespace App\Http\Controllers\Api;

use App\Models\Child;
use App\Models\Classes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ChildStoreRequest;
use App\Http\Resources\ChildwithParentResource;
use App\Trait\ApiResponse;
use Illuminate\Support\Facades\File;
use App\Models\Application;

class ChildrenController extends Controller
{
    use ApiResponse;

    public function getChildrenByParentId($parentId)
    {
        $children = Child::with(['grades.subject'])->where('parent_id', $parentId)->get();
        return $this->successResponse(ChildwithParentResource::collection($children), 'Children fetched successfully');
    }

    
        public function index(Request $request)
    {
        $children = Child::with(['parent.user', 'applications', 'grades.subject'])->paginate(2); // Adjust '10' as per your pagination needs

        return ChildwithParentResource::collection($children);
    }
    

    public function show($id)
    {
        $child = Child::with(['parent.user', 'applications', 'grades.subject'])->find($id);

        if (!$child) {
            return $this->errorResponse('Child not found', 404);
        }

        return $this->successResponse(new ChildwithParentResource($child));
    }

    public function store(ChildStoreRequest $request)
    {

        $existingEnrollment = Enrollment::where('child_id', $request->child_id)
                                        ->where('class_id', $request->class_id)
                                        ->first();

        if ($existingEnrollment) {
            return $this->errorResponse('Child is already enrolled in this class', 400);
        }

        $child = new Child;
        $child->parent_id = $request->parent_id;
        $child->full_name = $request->full_name;
        $child->birthdate = $request->birthdate;
        $child->place_of_birth = $request->place_of_birth;
        $child->gender = $request->gender;
        $child->current_residence = $request->current_residence;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $imageName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
            $child->photo = $imagePath;
        }

        $child->save();

        $application = new Application;
        $application->child_id = $child->id;
        $application->status = 'pending';
        $application->date_submitted = now();
        $application->save();

        return $this->successResponse(new ChildwithParentResource($child), 'Child and corresponding application added successfully');
    }

    public function update(ChildStoreRequest $request, $id)
    {
        $validatedData = $request->validated();
        $child = Child::find($id);

        if (!$child) {
            return $this->errorResponse('Child not found', 404);
        }


        $existingEnrollment = Enrollment::where('child_id', $id)
                                        ->where('class_id', $request->class_id)
                                        ->first();

        if ($existingEnrollment) {
            return $this->errorResponse('Child is already enrolled in this class', 400);
        }

        $child->fill($validatedData);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $imageName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
            $child->photo = $imagePath;
        }

        $child->save();

        return $this->successResponse(new ChildwithParentResource($child), 'Child updated successfully');
    }

    public function destroy($id)
    {
        $child = Child::find($id);

        if (!$child) {
            return $this->errorResponse('Child not found', 404);
        }

        $parent = $child->parent;
        $imageName = $child->photo;
        $imagePath = public_path('images') . '/' . $imageName;

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $child->delete();

        // If the parent has no remaining children, delete the parent as well
        $remainingChildren = Child::where('parent_id', $parent->id)->exists();
        if (!$remainingChildren) {
            $parent->delete();
        }

        return $this->successResponse(null, 'Child deleted successfully');
    }

    }
