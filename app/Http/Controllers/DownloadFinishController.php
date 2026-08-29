<?php

namespace App\Http\Controllers;

use App\Enums\FileSourceEnum;
use App\Jobs\Art\SyncArtJob;
use App\Jobs\LoadFileInfoJob;
use App\Jobs\LoadRecordingLyricsJob;
use App\Models\Artist;
use App\Models\File;
use App\Models\Recording;
use App\Models\Release;
use App\Models\ReleaseGroup;
use App\Models\Track;
use App\Services\Api\AlphaPlugin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DownloadFinishController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, AlphaPlugin $alphaPlugin)
    {
        $request->validate([
            'url' => 'required|string',
            'metadata' => 'required|array',
            'minio_path' => 'nullable|string',
            'status' => 'required|string',
        ]);

        Log::info('Download finished', [
            'url' => $request->input('url'),
            'metadata' => $request->input('metadata'),
            'minio_path' => $request->input('minio_path'),
            'status' => $request->input('status'),
        ]);

        $metadata = $request->input('metadata');

        $song = $alphaPlugin->getSong($metadata['song_id']);

        $album = $alphaPlugin->getAlbum($metadata['album_id']);

        if ($metadata['artist_id']) {
            $artist = $alphaPlugin->getArtist($metadata['artist_id']);

            Artist::updateOrCreate(
                ['alpha_id' => $metadata['artist_id']],
                [
                    'name' => $artist['name'],
                    'alpha_id' => $metadata['artist_id'],
                ]
            );

            $artistModel = Artist::where('alpha_id', $metadata['artist_id'])->firstOrFail();
        } else {
            $artistModel = Artist::firstOrCreate(
                [
                    'name' => 'Unknown Artist',
                    'alpha_id' => $metadata['album_id'],
                ],
                []
            );
        }

        ReleaseGroup::updateOrCreate(
            ['alpha_id' => $metadata['album_id']],
            [
                'title' => $album['title'],
                'alpha_id' => $metadata['album_id'],
                'artist_id' => $artistModel->id,
            ]
        );

        $releaseGroupModel = ReleaseGroup::where('alpha_id', $metadata['album_id'])->firstOrFail();

        $release = $releaseGroupModel->releases()->updateOrCreate(
            ['alpha_id' => $metadata['album_id']],
            [
                'title' => $album['title'],
                'alpha_id' => $metadata['album_id'],
                'release_group_id' => $releaseGroupModel->id,
            ]
        );

        $releaseModel = Release::where('alpha_id', $metadata['album_id'])->firstOrFail();

        Recording::updateOrCreate(
            ['alpha_id' => $metadata['song_id']],
            [
                'title' => $song['videoDetails']['title'],
                'alpha_id' => $metadata['song_id'],
            ]
        );

        $recordingModel = Recording::where('alpha_id', $metadata['song_id'])->firstOrFail();

        Track::updateOrCreate(
            [
                'recording_id' => $recordingModel->id,
                'release_id' => $releaseModel->id,
            ],
            [
                'title' => $song['videoDetails']['title'],
            ]
        );

        $file = File::updateOrCreate(
            [
                'recording_id' => $recordingModel->id,
                'path' => $request->input('minio_path'),
            ],
            [
                'source' => FileSourceEnum::ALPHA_PLUGIN->value,
            ]
        );

        SyncArtJob::dispatch($releaseModel);

        LoadFileInfoJob::dispatch($file);

        LoadRecordingLyricsJob::dispatch($recordingModel);

        return 'OK';
    }
}
