<?php

namespace App\Http\Controllers;

use App\Jobs\NewFileJob;
use App\Models\File;
use App\Models\Recording;
use App\Services\Api\TaggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Kiwilan\Audio\Audio;

class UploadFileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, TaggerService $taggerService)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file',
        ]);

        $path = $request->file('file')->store('files');

        $info = $taggerService->getInfo(
            $path
        );

        $tags = $info['tags'] ?? [];
        $info = $info['info'] ?? [];

        $recordingMbId = $tags['musicbrainz track id'][0] ?? $tags['musicbrainz_trackid'][0] ?? null;
        $trackId = $tags['musicbrainz release track id'][0] ?? $tags['musicbrainz_releasetrackid'][0] ?? null;

        $releaseMbId = $tags['musicbrainz album id'][0] ?? $tags['musicbrainz_albumid'][0] ?? null;

        if ((empty($recordingMbId) && empty($trackId)) || empty($releaseMbId)) {
            Storage::delete($path);

            return response()->json([
                'error' => 'No MusicBrainz recording ID found in the file.',
                'tags' => $tags,
            ], 422, [], JSON_UNESCAPED_SLASHES);
        }

        $recording = Recording::firstOrCreate(
            ['mb_id' => $recordingMbId],
        );

        $file = File::create([
            'path' => $path,
            'recording_id' => $recording->id,
        ]);

        NewFileJob::dispatch($file, $recordingMbId, $releaseMbId, $trackId);
        return response()->json([
            'file' => $file,
            'recording' => $recording,
            'url' => Storage::url($path),
        ], 201, [], JSON_UNESCAPED_SLASHES);
    }
}
