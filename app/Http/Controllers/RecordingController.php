<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecordingRequest;
use App\Http\Requests\UpdateRecordingRequest;
use App\Http\Resources\RecordingCollection;
use App\Http\Resources\RecordingResource;
use App\Models\Recording;
use Illuminate\Http\Request;

class RecordingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $recordings = Recording::query();

        if ($request->has('mb_id')) {
            $recordings->where('mb_id', $request->input('mb_id'));
        }

        return new RecordingCollection($recordings->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecordingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Recording $recording)
    {
        return new RecordingResource($recording);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecordingRequest $request, Recording $recording)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recording $recording)
    {
        //
    }
}
