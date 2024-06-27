<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Http\Resources\PackageResource;
use App\Trait\ApiResponse;
use App\Http\Requests\PackageStoreRequest;


class PackageController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $packages = Package::all();
        return PackageResource::collection($packages);
    }

    public function show(Request $request,$id)
    {
        $package = Package::findOrFail($id);

        if(!$package)
        {
            return $this->errorResponse('package not found', 404);
        }

        return $this->successResponse(new PackageResource($package));

    }
    public function store(PackageStoreRequest $request)
    {

    $package = new Package;
    $package->name = $request->name;
    $package->advantages = $request->advantages;
    $package->price = $request->price;

    $package->save();
    
    return $this->successResponse(new PackageResource($package), 'package added successfully');
}

public function update(PackageStoreRequest $request, $id)
{
    $validatedData = $request->validated();
    $package = Package::find($id);
    
    if (!$package) {
        return $this->errorResponse('package not found', 404);
    }

    $package->fill($validatedData);
    $package->save();

    return $this->successResponse(new PackageResource($package), 'Package updated successfully');
}
public function destroy($id)
{
    $package = Package::findOrFail($id);

    $package->delete();

    return $this->successResponse($package, 'Package deleted successfully');
}


}
