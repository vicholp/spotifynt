@extends('template.main')

@section('title', 'Spotifynt')

@section('content')
<div class="grid grid-flow-row mt-5 mb-5 pb-5 px-3 gap-5 ">
  <div id="row-player" class="content-center" hidden>

    <div class="grid grid-cols-12
                shadow-lg rounded bg-white
                dark:bg-white dark:bg-opacity-10 dark:text-white  dark:-white dark:-opacity-20">
      <div class="col-span-12 sm:col-span-3">
        <img id="img-songArt" src="" class="h-64 rounded-l bg-white bg-opacity-10" >
      </div>
      <div class="col-span-12 sm:col-span-9 flex flex-col items-center justify-center py-6 px-3">
        <div class="flex items-center flex-col">
          <h3 id="text-songTitle" class="text-3xl text-center"></h5>
          <h4 id="text-songArtist" class="text-white text-opacity-40 mt-1"></h6>
        </div>
        <div class="flex items-center mt-2" >
          <button id="btn-prevSong" class="text-4xl"><span class="iconify" data-icon="ic:round-navigate-before"></span></button>
          <button id="btn-playpause" class="text-4xl">
            <div id="icon-pause" hidden>
              <span class="iconify" data-icon="ic:round-pause" ></span>
            </div>
            <div id="icon-play" hidden>
              <span class="iconify" data-icon="ic:round-play-arrow" ></span>
            </div>
          </button>
          <button id="btn-nextSong" class="text-4xl"><span class="iconify" data-icon="ic:round-navigate-next"></span></button>
        </div>
        <div class="flex mt-4 text-sm divide-x divide-white divide-opacity-10 cursor-default">
          <button class="p-2 rounded-none rounded-l bg-white bg-opacity-10 flex items-center gap-1.5">
            <span class="iconify" data-icon="mdi:broadcast"></span>
            <div id="text-songBitrate"></div>
          </button>
          <button class="p-2 rounded-none rounded-r bg-white bg-opacity-10 flex items-center gap-1.5">
            <span class="iconify" data-icon="mdi:file"></span>
            <div id="text-songFormat"></div>
          </button>
        </div>
      </div>
      <audio id="audio-player" src="" preload="auto"></audio>
    </div>
  </div>
  <div class="p-3 grid grid-flow-row
              shadow-lg rounded bg-white
              dark:bg-white dark:bg-opacity-10 dark:text-white  dark:-white dark:-opacity-20">
      <input id="input-search" type="text" class=" rounded -white focus:-gray-900 dark:-opacity-20 dark:bg-white dark:bg-opacity-10">
      <div class="mt-3 flex">
        <button id="btn-resumePlaylist" class="bg-white bg-opacity-10 rounded p-2 text-white text-opacity-30" onclick="beet_resume()">
          <span class="iconify" data-icon="ic:outline-play-arrow"></span>
        </button>
        <div class="relative ml-4">
          <button class="bg-white bg-opacity-10 rounded-l p-2 text-white text-opacity-30" type="button" data-bs-toggle="dropdown">
            <span class="iconify" data-icon="ic:baseline-music-note"></span>
          </button>
          <ul class="absolute" hidden>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('mood_sad:0.7..')">🙁 mood_sad</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('mood_happy:0.7..')">🙂 mood_happy</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('mood_aggressive:0.7..')">😡 mood_aggressive</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('mood_party:0.7..')">🎉 mood_party</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('mood_acoustic:0.7..')">🎸 mood_acoustic</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('mood_electronic:0.7..')">🔌 mood_electronic</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('mood_relaxed:0.7..')">😑 mood_relaxed</button></li>
          </ul>
        </div>
        <div class="relative">
          <button class="bg-white bg-opacity-10 rounded-none p-2 text-white text-opacity-30" type="button" data-bs-toggle="dropdown">
            <span class="iconify" data-icon="ic:baseline-music-note"></span>
          </button>
          <div class="absolute"  hidden>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('genre_rosamerica:cla')">🎻 cla</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('genre_rosamerica:dan')">🎼 dan</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('genre_rosamerica:hip')">🎵 hip</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('genre_rosamerica:jaz')">🎷 jaz</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('genre_rosamerica:pop')">🎹 pop</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('genre_rosamerica:rhy')">🎺 rhy</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('genre_rosamerica:roc')">🎸 roc</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('genre_rosamerica:spe')">📻 spe</button></li>
          </div>
        </div>
        <div class="relative">
          <button class="bg-white bg-opacity-10 rounded-r p-2 text-white text-opacity-30" type="button" data-bs-toggle="dropdown">
            <span class="iconify" data-icon="ic:baseline-music-note"></span>
          </button>
          <div class="absolute" hidden>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('format:FLAC')">🎶 FLAC</button></li>
            <li><button type="button" class="dropdown-item" onclick="Spotifynt.search('format:MP3')">🎵 MP3</button></li>
          </div>
        </div>
        <button id="btn-resumePlaylist" class="bg-white bg-opacity-10 rounded ml-4 p-2" onclick="Spotifynt.displayAlbumResults(false); Spotifynt.displaySongResults(false);">
          <span class="iconify" data-icon="ic:twotone-clear"></span>
        </button>
        <button class="bg-white bg-opacity-10 rounded ml-4 p-2" onclick="">
          <span class="iconify" data-icon="ic:round-playlist-play"></span>
        </button>
        <button class="bg-white bg-opacity-10 rounded ml-4 p-2" onclick="Lists.shuffle('playlist-actual');">
          <span class="iconify-inline" data-icon="ic:round-shuffle"></span>
        </button>
      </div>

  </div>


  <div id="row-albumResults" id="row-player" hidden>
    <div class="row align-items-center" hidden>
      <div class="col-auto" >
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
          <button type="button" class="btn bg-spotifynt">
            <span class="iconify fs-5" data-icon="ic:outline-play-arrow"></span>
          </button>
          <button type="button" class="btn bg-spotifynt">
            <span class="iconify fs-5" data-icon="ic:round-plus"></span>
          </button>
          <div class="btn-group" role="group">
            <button id="btnGroupDrop1" type="button" class="btn bg-spotifynt rounded-end" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="iconify fs-5" data-icon="ic:round-more-vert"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="btnGroupDrop1">
              <li><a class="dropdown-item" href="#">Dropdown link</a></li>
              <li><a class="dropdown-item" href="#">Dropdown link</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col">
        <span class="fs-5">Albums</span>
      </div>
    </div>
    <template id="template-albumResult">
      <div class="relative bg-black bg-opacity-70 rounded shadow flex flex-row items-center justify-center hover:bg-opacity-100 transition duration-300">
        <img loading="lazy" src="" class="opacity-50 w-full h-full object-cover rounded" alt="..." data-album="art">
        <div class="flex items-center flex-col absolute top-0 h-full w-full text-white justify-around px-5">
          <p class="text-center font-bold text-opacity-90" data-album="title"></p>
          <p class="text-sm text-opacity-70" data-album="artist"></p>
          <div class="flex">
            <button class="p-2 rounded-none rounded-l bg-white bg-opacity-10 transition duration-300 hover:bg-opacity-30" data-album="play">
              <span class="iconify text-xl" data-icon="ic:outline-play-arrow"></span>
            </button>
            <button class="p-2 rounded-none rounded-r bg-white bg-opacity-10 transition duration-300 hover:bg-opacity-30" data-album="append">
              <span class="iconify text-xl" data-icon="ic:round-plus"></span>
            </button>
          </div>
        </div>
      </div>
    </template>
    <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-8 gap-3" id="div-albumResults">
    </div>
  </div>

  <div id="row-songResults" class="p-3
          shadow-lg rounded bg-white  dark:
        dark:bg-white dark:bg-opacity-10 dark:text-white  dark:-white dark:-opacity-20" hidden>
    <div class="flex">
      <div class="flex bg-white bg-opacity-10 rounded" role="group">
        <button id="btn-playPlaylist" class="p-2 rounded-none rounded-l bg-white bg-opacity-10 transition duration-300 hover:bg-opacity-30" data-album="play">
          <span class="iconify text-xl" data-icon="ic:outline-play-arrow"></span>
        </button>
        <button id="btn-appendPlaylist" class="p-2 rounded-none rounded-r bg-white bg-opacity-10 transition duration-300 hover:bg-opacity-30" data-album="append">
          <span class="iconify text-xl" data-icon="ic:round-plus"></span>
        </button>
        <div class="btn-group " role="group" hidden>
          <button id="btnGroupDrop1" type="button" class="btn bg-spotifynt rounded-end" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="iconify fs-5" data-icon="ic:round-more-vert"></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="btnGroupDrop1">
            <li><a class="dropdown-item" href="#">Dropdown link</a></li>
            <li><a class="dropdown-item" href="#">Dropdown link</a></li>
          </ul>
        </div>
      </div>
      <div class="ml-5">
        <span class="text-2xl">Songs</span>
      </div>
    </div>
    <template id="template-songResult">
      <div class="items-center grid grid-cols-12 p-3 bg-white bg-opacity-0 hover:bg-opacity-10 transition duration-300">
        <div class="col-span-5" data-song="title">
        </div>
        <div class="col-span-5" data-song="artist">
        </div>
        <div class="col-span-2 flex ml-auto">
          <div class="flex bg-white bg-opacity-10 rounded">
            <button type="button" class="p-2" data-song="play" hidden>
              <span class="iconify text-xl" data-icon="ic:outline-play-arrow"></span>
            </button>
            <button type="button" class="p-2" data-song="append" hidden>
              <span class="iconify text-xl" data-icon="ic:round-plus"></span>
            </button>
            <button type="button" class="p-2" data-song="append">
              <span class="iconify text-xl text-gray-500" data-icon="ic:round-more-vert"></span>
            </button>
          </div>
        </div>
      </div>
    </template>
    <div class="grid grid-flow-row divide-y divide-white divide-opacity-10 mt-4 rounded" id="div-songResults">
    </div>
  </div>
</div>


{{--

  <div class="modal fade" id="modal-info" tabindex="-1" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-infoTitle"></h5>
          <li><button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></li>
        </div>
        <div id="modal-infoBody" class="modal-body">

        </div>
        <div class="modal-footer">
          <li><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></li>
          <li><button type="button" class="btn btn-primary">Save changes</button></li>
        </div>
      </div>
    </div>
  </div>
  --}}
@endsection
