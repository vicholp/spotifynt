<?php

use App\Models\Server;
use App\Services\Api\BeetsService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

describe('check single track', function () {
    test('when track exists returns true', function () {
        Http::fake(function () {
            return Http::response('OK', 200);
        });

        $server = Server::factory()->create();
        $beets = new BeetsService($server);

        expect($beets->checkTrack(1))->toBeTrue();

        Http::assertSent(function (Request $request) use ($server) {
            return $request->url() == $server->path.'/item/'.str(1);
        });
    });

    test('when track does not exist returns false', function () {
        Http::fake(function () {
            return Http::response('Not Found', 404);
        });

        $server = Server::factory()->create();
        $beets = new BeetsService($server);

        expect($beets->checkTrack(1))->toBeFalse();

        Http::assertSent(function (Request $request) use ($server) {
            return $request->url() == $server->path.'/item/'.str(1);
        });
    });
});
