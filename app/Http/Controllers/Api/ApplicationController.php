<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Http\Resources\ApplicationResource;
use App\Trait\ApiResponse;
use App\Http\Requests\ApplicationStoreRequest;



class ApplicationController extends Controller
{    
    use ApiResponse;

    // public function index()
    // {
    //     $application = Application::with('child')->get();
    //     return ApplicationResource::collection($application);
    // }

    public function index(Request $request)
{
    $query = Application::query();

    // Filtering by child ID
    if ($request->has('child_id')) {
        $query->where('child_id', $request->child_id);
    }

    // Filtering by status
    if ($request->has('status')) {
        $query->where('status', $request->status);
    }

    // Searching by date submitted
    if ($request->has('date_submitted')) {
        $searchQuery = $request->date_submitted;
        $query->where('date_submitted', $searchQuery);
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

    $applications = $query->get();
    return ApplicationResource::collection($applications);
}
    public function show($id)

        {
            $application = Application::with('child')->find($id);
        
            if (! $application) {
                return $this->errorResponse('Application not found', 404);
            }
        
            return $this->successResponse(new ApplicationResource($application));
        }
    public function store(ApplicationStoreRequest $request)

        {
            $existingApplication = Application::where('child_id', $request->child_id)->exists();
            if ($existingApplication) {
                return $this->errorResponse('Child already has an existing application', 400);
            }
        
            $application = new Application;
            $application->child_id = $request->child_id;
            $application->status = $request->status;
            $application->date_submitted = now();
            $application->save();
            
            return $this->successResponse(new ApplicationResource($application), 'Application added successfully');
        }

    public function update(ApplicationStoreRequest $request, $id)

        {
            $validatedData = $request->validated();
            $application = Application::find($id);
            
            if (!$application) {
                return response()->json(['error' => 'Application not found'], 404);
            }
    
            $application->fill($validatedData);
            $application->date_submitted = now();
            $application->save();
            
            return $this->successResponse(new ApplicationResource($application), 'Application updated successfully');
        }

        public function destroy($id)
    {
        $application = Application::find($id);

        if (!$application) {
            return $this->errorResponse('Application not found', 404);
        }

        $application->delete();

        return $this->successResponse($application, 'Application deleted successfully');
    }
    }
