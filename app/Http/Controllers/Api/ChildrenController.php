<?php

namespace App\Http\Controllers\Api;

use App\Models\Child;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ChildStoreRequest;
use App\Http\Resources\ChildwithParentResource;
use App\Http\Resources\ChildResource;
use App\Trait\ApiResponse;
use Illuminate\Support\Facades\File;


class ChildrenController extends Controller
{
    use ApiResponse;
    // public function index()
    // {
    //     $children = Child::with('parent')->get();
    //     return ChildResource::collection($children);
    // }

    public function index(Request $request)
    {
        $query = Child::query();

        // Filtering by parent ID
        if ($request->has('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        }

        // Filtering by gender
        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }

        //searching
        if ($request->has('search')) {
            $searchQuery = $request->search;
            $query->where('full_name', 'like', "%$searchQuery%");
        }

        // Sorting
        if ($request->has('sort_by')) {
            switch ($request->sort_by) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
            }

        } else {
            $query->orderBy('created_at', 'desc');
        }

        $children = $query->with(['parent', 'fees'])->get();
        return ChildwithParentResource::collection($children);
    }


    public function show($id)
    {
        $child = Child::with('parent')->find($id);

        if (! $child) {
            return $this->errorResponse('Child not found', 404);
        }

        return $this->successResponse(new ChildwithParentResource($child));
    }

    public function store(ChildStoreRequest $request)
    {
        $child = new Child;
        $child->parent_id = $request->parent_id;
        $child->full_name = $request->full_name;
        $child->birthdate = $request->birthdate;
        $child->place_of_birth = $request->place_of_birth;
        $child->gender = $request->gender;
        $child->current_residence = $request->current_residence;

        if ($request->hasFile('photo')) {
            $originalFilename = $request->photo->getClientOriginalName();
            $request->photo->move(public_path('images'), $originalFilename);
            $child->photo = $originalFilename;
        } else {
            $child->photo = 'default.jpg';
        }

        $child->save();
        return $this->successResponse(new ChildwithParentResource($child), 'Child added successfully');
    }

    public function update(ChildStoreRequest $request, $id)
    {

        $validatedData = $request->validated();
        $child = Child::find($id);
        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }

        $child->fill($validatedData);

        if ($request->hasFile('photo')) {
            $originalFilename = $request->photo->getClientOriginalName();
            $request->photo->move(public_path('photos'), $originalFilename);
            $child->photo = $originalFilename;
        } else {
            $child->photo = 'default.jpg';
        }

        $child->save();
        return $this->successResponse(new ChildwithParentResource($child), 'Child updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        $child = Child::find($id);

        if (! $child) {
            return $this->errorResponse('child not found', 404);
        }
        $parent = $child->parent;
        $imageName = $child->photo;
        $imagePath = public_path('images').'/'.$imageName;

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $child->delete();
        $remainingChildren = Child::where('parent_id', $parent->id)->exists();

        // If the parent has no remaining children, delete the parent as well
        if (!$remainingChildren) {
            $parent->delete();
        }
        return $this->successResponse(new ChildwithParentResource($child), 'Child deleted successfully');
    }
}
