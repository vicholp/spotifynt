<?php

namespace App\Http\Controllers;

use App\Services\Api\RecService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function batchStore(Request $request, RecService $recService)
    {
        $events = $request->validate([
            'events' => 'required|array',
            'events.*.event_type' => 'required|string',
            'events.*.payload' => 'nullable',
        ]);

        $success = $recService->storeEvents($events['events']);

        if (!$success) {
            return response()->json(['message' => 'Failed to process events'], 500);
        }

        return response()->json(['message' => 'Events processed successfully'], 200);
    }
}


