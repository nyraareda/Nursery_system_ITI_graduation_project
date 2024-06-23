<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Http\Requests\StoreClassesRequest;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    public function index()
    {
        $classes = Classes::all();
        return response()->json($classes);
    }

    public function show($id)
    {
        $class = Classes::find($id);
        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }
        return response()->json($class);
    }

    public function store(StoreClassesRequest $request)
    {
        $class = Classes::create($request->validated());
        return response()->json($class, 201);
    }

    public function update(StoreClassesRequest $request, $id)
    {
        $class = Classes::find($id);
        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        $class->update($request->validated());
        return response()->json($class);
    }

    public function destroy($id)
    {
        $class = Classes::find($id);
        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        $class->delete();
        return response()->json(['message' => 'Class deleted successfully']);
    }

    public function children($id)
    {
        $class = Classes::with('enrollments.child')->find($id);
        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        $children = $class->enrollments->map(function ($enrollment) {
            return $enrollment->child;
        });

        return response()->json($children);
    }
}
