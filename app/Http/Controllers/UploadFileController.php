<?php

namespace App\Http\Controllers;

use App\Enums\FileSourceEnum;
use App\Jobs\LoadFileInfoJob;
use App\Jobs\NewFileJob;
use App\Models\File;
use App\Services\Api\TaggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, TaggerService $taggerService)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $path = $request->file('file')->store('files');

        $file = File::create([
            'path' => $path,
            'source' => FileSourceEnum::USER_UPLOAD->value,
        ]);

        $info = $taggerService->getInfo(
            $path
        );

        $tags = $info['tags'] ?? [];

        $recordingMbId = $tags['musicbrainz track id'][0] ?? $tags['musicbrainz_trackid'][0] ?? null;
        $trackId = $tags['musicbrainz release track id'][0] ?? $tags['musicbrainz_releasetrackid'][0] ?? null;

        $releaseMbId = $tags['musicbrainz album id'][0] ?? $tags['musicbrainz_albumid'][0] ?? null;

        if ((empty($recordingMbId) && empty($trackId)) || empty($releaseMbId)) {
            Storage::delete($path);

            $file->delete();

            return response()->json([
                'error' => 'No MusicBrainz recording ID found in the file.',
                'tags' => $tags,
            ], 422, [], JSON_UNESCAPED_SLASHES);
        }

        NewFileJob::dispatch(
            file: $file,
            recordingMbId: $recordingMbId,
            releaseMbId: $releaseMbId,
            trackId: $trackId
        );

        LoadFileInfoJob::dispatch($this->file);


        return response()->json([
            'file' => $file,
            'url' => Storage::url($path),
        ], 201, [], JSON_UNESCAPED_SLASHES);
    }
}
