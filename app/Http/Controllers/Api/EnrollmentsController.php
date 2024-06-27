<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\EnrollmentsResource;
use App\Models\Enrollment;
use App\Trait\ApiResponse;
use App\Http\Requests\EnrollmentStoreRequest;

class EnrollmentsController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $enrolls = Enrollment::with(['child', 'subjects','subjects.curriculum'])->get();
        return EnrollmentsResource::collection($enrolls);
    }

    public function show(Request $request,$id)
    {
        $enroll = Enrollment::with(['child', 'subjects','subjects.curriculum'])->find($id);

        if (! $enroll) {
            return $this->errorResponse('Enrollment not found', 404);
        }

        return $this->successResponse(new EnrollmentsResource($enroll));
    }


    public function store(EnrollmentStoreRequest $request)
    {
    $enroll = new Enrollment;
    $enroll->child_id = $request->child_id;
    $enroll->subject_id = $request->subject_id;
    $enroll->description = $request->description;
    $enroll->status = $request->status;
    $enroll->date_enrolled = now();
    $enroll->save();

    $enroll->load('child', 'subjects.curriculum');

    return new EnrollmentsResource($enroll);
    }

    public function update(EnrollmentStoreRequest $request, $id)
{
    $validatedData = $request->validated();

    $enrollment = Enrollment::find($id);

    if (!$enrollment) {
        return $this->errorResponse('Enrollment not found', 404);
    }

    $enrollment->fill($validatedData);
    $enrollment->date_enrolled = now();
    $enrollment->save();

    // Eager load relationships after updating
    $enrollment->load('child', 'subjects.curriculum');

    return $this->successResponse(new EnrollmentsResource($enrollment), 'Enrollment updated successfully');
}
public function destroy(Request $request,$id)
{
    $enrollment = Enrollment::find($id);

    if (!$enrollment) {
        return $this->errorResponse('Enrollment not found', 404);
    }

    $enrollment->delete();

    return $this->successResponse($enrollment, 'Enrollment deleted successfully');
}


}
