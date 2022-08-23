<?php

use App\Models\Track;
use App\Services\CoverArtService;

test('get front', function () {
    expect((new CoverArtService())->getFront('7416e707-94b5-3810-b6b8-4229ab2182ec'))->toBeObject(GdImage::class);
});

test('lala', function () {
    $a = Track::factory()->create();
});
