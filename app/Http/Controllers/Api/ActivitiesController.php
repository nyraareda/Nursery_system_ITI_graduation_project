<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    public function index()
    {
        $activities = Activity::all();
        return response()->json($activities);
    }

    public function show($id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }
        return response()->json($activity);
    }

    public function store(StoreActivityRequest $request)
    {
        $activity = Activity::create($request->validated());
        return response()->json($activity, 201);
    }

    public function update(StoreActivityRequest $request, $id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }

        $activity->update($request->validated());
        return response()->json($activity);
    }

    public function destroy($id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }

        $activity->delete();
        return response()->json(['message' => 'Activity deleted successfully']);
    }
}
