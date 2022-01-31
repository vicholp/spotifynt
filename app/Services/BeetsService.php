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
    static public function test()
    {
        echo Http::get('http://192.168.1.5:9000/item/query/amiga');
    }

    static public function syncAlbums()
    {
        $albums = self::queryAlbums()->albums;
        foreach($albums as $album) {
            $album = Album::updateOrCreate([
                'mb_id' => $album->mb_albumid,
            ],[
                'name' => $album->album,
                'year' => $album->year,
                'beets_tags' => $album,
            ]);
        }
    }
    static public function syncLibrary()
    {
        $albums = self::queryAlbums()->albums;
        foreach($albums as $album) {
            $artist = Artist::updateOrCreate([
                'mb_id' => $album->mb_albumartistid,
            ],[
                'name' => $album->albumartist,
            ]);

            $album_model = Album::updateOrCreate([
                'mb_id' => $album->mb_albumid,
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
                dump($track->mb_trackid);
                $track_model = Track::updateOrCreate([
                    'mb_id' => $track->mb_trackid,
                ], [
                    'name' => $track->title,
                    'beets_id' => $track->id,
                    'album_id' => $album_model->id,
                    'path' => $track->path,
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
