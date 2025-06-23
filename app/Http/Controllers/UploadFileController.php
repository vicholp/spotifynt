<?php

namespace App\Http\Controllers;

use App\Jobs\NewFileJob;
use App\Models\File;
use App\Models\Recording;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Kiwilan\Audio\Audio;

class UploadFileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file',
        ]);

        $path = $request->file('file')->store('files');

        $audio = Audio::read($request->file('file')->getRealPath());

        $recordingMbId = $audio->getRawKey('musicbrainz_trackid', 'vorbiscomment');
        $releaseMbId = $audio->getRawKey('musicbrainz_releaseid', 'vorbiscomment');

        if (empty($recordingMbId)) {
            $recordingMbId = $audio->getRawKey('musicbrainz_trackid', 'id3v2');
            $releaseMbId = $audio->getRawKey('musicbrainz_releaseid', 'id3v2');
        }

        if (empty($recordingMbId)) {
            $recordingMbId = $audio->getRawKey('musicbrainz_trackid', 'id3v1');
            $releaseMbId = $audio->getRawKey('musicbrainz_releaseid', 'id3v1');
        }

        if (empty($recordingMbId)) {
            return response()->json([
                'error' => 'No MusicBrainz recording ID found in the file.',
                'tags' => $audio->toArray(),
            ], 422, [], JSON_UNESCAPED_SLASHES);
        }

        $recording = Recording::firstOrCreate(
            ['mb_id' => $recordingMbId],
        );

        $file = File::create([
            'path' => $path,
            'recording_id' => $recording->id,
        ]);

        NewFileJob::dispatch($file, $recordingMbId, $releaseMbId);

        return response()->json([
            'file' => $file,
            'recording' => $recording,
            'url' => Storage::url($path),
        ], 201, [], JSON_UNESCAPED_SLASHES);
    }
}
