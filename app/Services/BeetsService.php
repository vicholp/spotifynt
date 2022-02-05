<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Track;
use Illuminate\Support\Facades\Http;

/**
 * Class BeetsService
 * @package App\Services
 */
class BeetsService
{
    static public function syncLibrary()
    {
        $albums = self::queryAlbums()->albums;
        foreach($albums as $album) {
            $artist = Artist::updateOrCreate([
                'name' => $album->albumartist,
                'mb_id' => $album->mb_albumartistid,
            ],[
            ]);

            $album_model = Album::updateOrCreate([
                'mb_id' => $album->mb_releasegroupid,
            ],[
                'name' => $album->album,
                'beets_id' => $album->id,
                'year' => $album->year,
                'artist_id' => $artist->id,
                'beets_tags' => $album,
            ]);

            $tracks = self::queryTracks("album_id:{$album->id}")->results;

            foreach($tracks as $track) {
                $artist->country = $track->artist_country ?? null;
                $artist->save();

                $track_model = Track::updateOrCreate([
                    'mb_id' => $track->mb_trackid,
                ], [
                    'name' => $track->title,
                    'beets_id' => $track->id,
                    'album_id' => $album_model->id,
                    'path' => $track->path,
                    'track_position' => $track->track,

                    'length' => $track->length,
                    'format' => $track->format,
                    'bitrate' => $track->bitrate,
                    'bit_depht' => $track->bitdepth,
                    'sample_rate' => $track->samplerate,

                    'average_loudness' => $track->average_loudness ?? null,
                    'bpm' => $track->bpm  ?? null,
                    'danceable' => $track->danceable  ?? null,
                    'genre_rosamerica' => $track->genre_rosamerica  ?? null,
                    'language' => $track->language  ?? null,
                    'mood_acoustic' => $track->mood_acoustic  ?? null,
                    'mood_aggressive' => $track->mood_aggressive  ?? null,
                    'mood_electronic' => $track->mood_electronic  ?? null,
                    'mood_happy' => $track->mood_happy  ?? null,
                    'mood_party' => $track->mood_party  ?? null,
                    'mood_relaxed' => $track->mood_relaxed  ?? null,
                    'mood_sad' => $track->mood_sad  ?? null,
                    'moods_mirex' => $track->moods_mirex  ?? null,
                    'voice_instrumental' => $track->voice_instrumental  ?? null,

                    'beets_tags' => $track,
                ]);
            }
        }
    }

    static public function getAlbum(int $id)
    {
        return Http::get("http://192.168.1.5:9000/album/{$id}")->object();
    }

    static public function getTrack(int $id)
    {
        return Http::get("http://192.168.1.5:9000/item/{$id}")->object();
    }

    static public function queryAlbums(string $query = "")
    {
        return Http::get("http://192.168.1.5:9000/album/query/{$query}")->object();
    }

    static public function queryTracks(string $query = "")
    {
        return Http::get("http://192.168.1.5:9000/item/query/{$query}")->object();
    }
}
