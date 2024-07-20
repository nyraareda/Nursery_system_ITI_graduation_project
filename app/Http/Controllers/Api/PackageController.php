<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Http\Resources\PackageResource;
use App\Trait\ApiResponse;
use App\Http\Requests\PackageStoreRequest;
use Illuminate\Validation\ValidationException;

class PackageController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $packages = Package::all();
        return PackageResource::collection($packages);
    }

    public function show(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        if (!$package) {
            return $this->errorResponse('Package not found', 404);
        }

        return $this->successResponse(new PackageResource($package));
    }

    public function store(PackageStoreRequest $request)
    {
        try {
            $package = new Package;
            $package->name = $request->name;
            $package->advantages = $request->advantages;
            $package->price = $request->price;
            $package->save();

            return $this->successResponse(new PackageResource($package), 'Package added successfully');
        } catch (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while adding the package', 500);
        }
    }

    public function update(PackageStoreRequest $request, $id)
    {
        try {
            $package = Package::find($id);

            if (!$package) {
                return $this->errorResponse('Package not found', 404);
            }

            $validatedData = $request->validated();

            $package->fill($validatedData);
            $package->save();

            return $this->successResponse(new PackageResource($package), 'Package updated successfully');
        } catch (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while updating the package', 500);
        }
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);

        if (!$package) {
            return $this->errorResponse('Package not found', 404);
        }

        $package->delete();

        return $this->successResponse(new PackageResource($package), 'Package deleted successfully');
    }
}
