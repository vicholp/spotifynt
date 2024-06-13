<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): Response
    {
        return response('Not implemented', 501);
    }

    /**
     * Get the authenticated User.
     */
    public function me(Request $request)
    {
        return $request->user();
    }
}
