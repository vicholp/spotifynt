<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeviceCollection;
use App\Http\Resources\DeviceResource;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $devices = $request->user()->devices;

        return DeviceCollection::make($devices);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $device = $request->user()->devices()->findOrFail($id);

        return DeviceResource::make($device);
    }

    /**
     * Upsert the specified resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|max:255',
            'uuid' => 'sometimes|string|max:255',
        ]);

        $device = $request->user()->devices()->updateOrCreate(
            ['uuid' => $data['uuid']],
            $data
        );

        return DeviceResource::make($device);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $device = $request->user()->devices()->findOrFail($id);
        $device->delete();

        return response()->noContent();
    }
}
