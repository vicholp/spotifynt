<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Resources\FileCollection;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $files = File::query();

        if ($request->has('checksum_md5')) {
            $files->where('checksum_md5', $request->input('checksum_md5'));
        }

        return new FileCollection($files->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        return new FileResource($file);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        //
    }
}
