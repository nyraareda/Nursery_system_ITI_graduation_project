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

    public function index()
    {
        $enrolls = Enrollment::with('child')->get();
        return EnrollmentsResource::collection($enrolls);
    }

    public function show($id)

    {
        $enroll = Enrollment::with('child')->find($id);
    
        if (! $enroll) {
            return $this->errorResponse('Enrollement not found', 404);
        }
    
        return $this->successResponse(new EnrollmentsResource($enroll));
    }

    public function store(EnrollmentStoreRequest $request)
        {
        
            $enroll = new Enrollment;
            $enroll->child_id = $request->child_id;
            $enroll->class_id = $request->class_id;
            $enroll->description= $request->description;
            $enroll->status = $request->status;
            $enroll->data_enrolled = now();
            $enroll->save();
            
            return $this->successResponse(new EnrollmentsResource($enroll), 'Enrollment added successfully');
        }

        public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validated();

        // Find the enrollment by ID
        $enrollment = Enrollment::find($id);
    
        if (! $enrollment) {
            return $this->errorResponse('Enrollment not found', 404);
        }

        // Update the enrollment with validated data
        $enrollment->fill($validatedData);
            $enrollment->date_enrolled = now();
            $enrollment->save();

        return $this->successResponse(new EnrollmentsResource($enrollment), 'Enrollment updated successfully');
    }

    public function destroy($id)
    {
        $enrollment = Enrollment::find($id);
    
        if (! $enrollment) {
            return $this->errorResponse('Enrollment not found', 404);
        }

        $enrollment->delete();

        return $this->successResponse($enrollment, 'Enrollment deleted successfully');
    }


}
