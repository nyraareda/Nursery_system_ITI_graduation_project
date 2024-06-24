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
use App\Models\Application;

class ChildrenController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Child::with(['parent.user', 'applications' => function($query) {
            $query->latest()->first();
        }]);

        // Filtering by parent ID
        if ($request->has('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        }

        // Filtering by gender
        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }

        // Searching
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

        $children = $query->get();
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
    
        $imagePath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $imageName = time().'.'.$photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $imageName);
            $imagePath = 'images/'.$imageName;
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
            return response()->json(['error' => 'Child not found'], 404);
        }

        $child->fill($validatedData);

        if ($request->has('parent_id')) {
            $child->parent_id = $request->parent_id;
        }
        if ($request->has('full_name')) {
            $child->full_name = $request->full_name;
        }
        if ($request->has('birthdate')) {
            $child->birthdate = $request->birthdate;
        }
        if ($request->has('place_of_birth')) {
            $child->place_of_birth = $request->place_of_birth;
        }
        if ($request->has('gender')) {
            $child->gender = $request->gender;
        }
        if ($request->has('current_residence')) {
            $child->current_residence = $request->current_residence;
        }
        
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $imageName = time().'.'.$photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $imageName);
            $imagePath = 'images/'.$imageName;
            $child->photo = $imagePath;
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

        if (!$remainingChildren) {
            $parent->delete();
        }
        return $this->successResponse(new ChildwithParentResource($child), 'Child deleted successfully');
    }
}
