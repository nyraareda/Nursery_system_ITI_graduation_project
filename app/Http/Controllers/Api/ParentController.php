<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\parents;
use Illuminate\Http\Request;
use App\Http\Requests\StoreParentRequest;
use App\Http\Requests\UpdateParentRequest;
use App\Http\Resources\ParentResource;

class ParentController extends Controller
{
    // Display a listing of the resource.
    public function index(Request $request)
    {
        $query = parents::with('children'); // Eager load children relationship

        // Filtering by parent ID
        if ($request->has('parent_id')) {
            $query->where('id', $request->input('parent_id'));
        }

        // Filtering by gender
        if ($request->has('gender')) {
            $query->whereHas('children', function ($q) use ($request) {
                $q->where('gender', $request->input('gender'));
            });
        }

        // Searching by full name
        if ($request->has('full_name')) {
            $fullName = $request->input('full_name');
            $query->where(function ($q) use ($fullName) {
                $q->where('first_name', 'like', "%{$fullName}%")
                    ->orWhere('last_name', 'like', "%{$fullName}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$fullName}%"]);
            });
        }

        // Sorting
        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            $sortOrder = $request->input('sort_order', 'asc'); // default to ascending order
            $query->orderBy($sortBy, $sortOrder);
        }

        $parents = $query->get();
        return ParentResource::collection($parents);
    }

    // Store a newly created resource in storage.
    public function store(StoreParentRequest $request)
    {
        $parent = parents::create($request->validated());
        $parent->load('children'); // Eager load children relationship
        return new ParentResource($parent);
    }

    // Display the specified resource.
    public function show(string $id)
    {
        $parent = parents::with('children')->findOrFail($id); // Eager load children relationship
        return new ParentResource($parent);
    }

    // Update the specified resource in storage.
    public function update(UpdateParentRequest $request, string $id)
    {
        $parent = parents::findOrFail($id);
        $parent->update($request->validated());
        $parent->load('children'); // Eager load children relationship
        return new ParentResource($parent);
    }

    // Remove the specified resource from storage.
    public function destroy(string $id)
    {
        $parent = parents::findOrFail($id);
        $parent->delete();
        return response()->json(null, 204);
    }
}
