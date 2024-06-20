<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiblingRequest;
use App\Models\Sibling;

class SiblingController extends Controller
{
    public function index()
    {
        $siblings = Sibling::all();
        return response()->json($siblings);
    }

    public function show($id)
    {
        $sibling = Sibling::find($id);
        if (!$sibling) {
            return response()->json(['message' => 'Sibling not found'], 404);
        }
        return response()->json($sibling);
    }

    public function store(StoreSiblingRequest $request)
    {
        $sibling = Sibling::create($request->validated());
        return response()->json($sibling, 201);
    }

    public function update(StoreSiblingRequest $request, $id)
    {
        $sibling = Sibling::find($id);
        if (!$sibling) {
            return response()->json(['message' => 'Sibling not found'], 404);
        }

        $sibling->update($request->validated());
        return response()->json($sibling);
    }

    public function destroy($id)
    {
        $sibling = Sibling::find($id);
        if (!$sibling) {
            return response()->json(['message' => 'Sibling not found'], 404);
        }

        $sibling->delete();
        return response()->json(['message' => 'Sibling deleted successfully']);
    }
}
