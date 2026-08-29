<?php

namespace App\Http\Controllers;

use App\Enums\MarkTypeEnum;
use App\Models\Mark;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'resource_type' => 'required|string',
            'resource_id' => 'required|integer',
            'comment' => ['nullable', 'string', new Enum(MarkTypeEnum::class)],
        ]);

        $mark = Mark::create($request->only('resource_type', 'resource_id', 'comment'));

        return response()->json($mark, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mark $mark)
    {
        return response()->json($mark);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mark $mark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mark $mark)
    {
        //
    }
}
