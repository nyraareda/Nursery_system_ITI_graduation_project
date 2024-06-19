<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fee;
use App\Http\Resources\FeesResource;
use App\Http\Requests\FeeStoreRequest;
use App\Trait\ApiResponse;

class FeesController extends Controller
{
    use ApiResponse;
    public function index(Request $request)
    {
        $query = Fee::query();

        // Filtering by child ID
        if ($request->has('child_id')) {
            $query->where('child_id', $request->child_id);
        }

        // Filtering by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Searching by due date
        if ($request->has('due_date')) {
            $searchQuery = $request->due_date;
            $query->where('due_date', $searchQuery);
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

        $fees = $query->get();
        return FeesResource::collection($fees);
    }

    public function show($id)
    {
        $fee = Fee::with('child')->find($id);

        if (! $fee) {
            return $this->errorResponse('fee not found', 404);
        }

        return $this->successResponse(new FeesResource($fee));
    }

    public function store(FeeStoreRequest $request)
{
    $fee = new Fee;
    $fee->child_id = $request->child_id;
    $fee->amount = $request->amount;
    $fee->status = $request->status;
    $fee->due_date = $request->due_date;
    // $fee->date_paid = $request->date_paid;
    $fee->description = $request->description;

    $fee->save();
    
    return $this->successResponse(new FeesResource($fee), 'Fee added successfully');
}
public function update(FeeStoreRequest $request, $id)
{
    $validatedData = $request->validated();
    $fee = Fee::find($id);
    
    if (!$fee) {
        return response()->json(['error' => 'Fee not found'], 404);
    }

    $fee->fill($validatedData);
    $fee->save();
    
    return $this->successResponse(new FeesResource($fee), 'Fee updated successfully');
}

public function destroy($id)
{
    $fee = Fee::find($id);

    if (!$fee) {
        return response()->json(['error' => 'Fee not found'], 404);
    }

    $fee->delete();

    return $this->successResponse($fee, 'Fee deleted successfully');
}
}
