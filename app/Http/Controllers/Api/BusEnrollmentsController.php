<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusEnrollmentsController extends Controller
{
    public function index()
    {
        $busEnrollments = BusEnrollment::all();
        return response()->json($busEnrollments);
    }

    public function show($id)
    {
        $busEnrollment = BusEnrollment::find($id);
        if (!$busEnrollment) {
            return response()->json(['message' => 'Bus Enrollment not found'], 404);
        }
        return response()->json($busEnrollment);
    }

    public function store(StoreBusEnrollmentRequest $request)
    {
        $busEnrollment = BusEnrollment::create($request->validated());
        return response()->json($busEnrollment, 201);
    }

    public function update(StoreBusEnrollmentRequest $request, $id)
    {
        $busEnrollment = BusEnrollment::find($id);
        if (!$busEnrollment) {
            return response()->json(['message' => 'Bus Enrollment not found'], 404);
        }

        $busEnrollment->update($request->validated());
        return response()->json($busEnrollment);
    }

    public function destroy($id)
    {
        $busEnrollment = BusEnrollment::find($id);
        if (!$busEnrollment) {
            return response()->json(['message' => 'Bus Enrollment not found'], 404);
        }

        $busEnrollment->delete();
        return response()->json(['message' => 'Bus Enrollment deleted successfully']);
    }
}
