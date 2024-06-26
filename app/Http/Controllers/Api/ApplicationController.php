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

    public function index(Request $request)
    {
        $query = Application::with('child'); // Ensure 'child' relationship is loaded

        // Filtering by child ID
        if ($request->has('child_id')) {
            $query->where('child_id', $request->child_id);
        }

        // Filtering by multiple statuses
        if ($request->has('statuses')) {
            $statuses = explode(',', $request->statuses);
            $query->whereIn('status', $statuses);
        }

        // Searching by date submitted
        if ($request->has('date_submitted')) {
            $searchQuery = $request->date_submitted;
            $query->whereDate('date_submitted', '=', $searchQuery);
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
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $applications = $query->get();
        return ApplicationResource::collection($applications);
    }
    // public function index()
    // {
    //     $applications = Application::with('child')->paginate(3);

    //     return ApplicationResource::collection($applications);
    // }

    public function show($id)
    {
        $application = Application::with('child')->find($id);

        if (!$application) {
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

    public function update(Request $request, $id) {
        $application = Application::find($id);
    
        if (!$application) {
            return $this->errorResponse('Application not found', 404);
        }

        $status = $request->input('status'); // Use a default value to avoid issues
    
        if (empty($status)) {
            return $this->errorResponse('Status is required', 400);
        }
    
        $application->status = $status;
        $application->save();
    
        return $this->successResponse(new ApplicationResource($application), 'Application status updated successfully');
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
