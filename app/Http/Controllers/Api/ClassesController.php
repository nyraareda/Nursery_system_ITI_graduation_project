<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    public function index()
    {
        $classes = ClassModel::all();
        return response()->json($classes);
    }

    public function show($id)
    {
        $class = ClassModel::find($id);
        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }
        return response()->json($class);
    }

    public function store(StoreClassRequest $request)
    {
        $class = ClassModel::create($request->validated());
        return response()->json($class, 201);
    }

    public function update(StoreClassRequest $request, $id)
    {
        $class = ClassModel::find($id);
        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        $class->update($request->validated());
        return response()->json($class);
    }

    public function destroy($id)
    {
        $class = ClassModel::find($id);
        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        $class->delete();
        return response()->json(['message' => 'Class deleted successfully']);
    }
}
