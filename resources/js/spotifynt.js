import FastAverageColor from 'fast-average-color';

window.Lists = new (function () {
    this.store = function (list, items){

      sessionStorage.setItem('list-'+list, JSON.stringify(items))
    }

    this.clear = function (list){

      sessionStorage.setItem('list-'+list, JSON.stringify([]))
    }

    this.appendOrStore = function (list, items){
      if (Lists.get(list)){
        Lists.append(list, items)
      }else{

        Lists.store(list, items)
      }
    }

    this.removeDuplicates = function(list){
      let items = Lists.get(list)
      items = items.reduce(function(a,b){if(a.indexOf(b)<0)a.push(b);return a;},[]);
      Lists.store(list, items)

    }

    this.append = function (list, songs){
      let items = Lists.get(list)
      items = items.concat(songs)
      sessionStorage.setItem('list-'+list, JSON.stringify(items))
    }

    this.merge = function (lista, listb){
      let itemsa = Lists.get(lista)
      let itemsb = Lists.get(listb)
      itemsa = itemsa.concat(itemsb)
      sessionStorage.setItem('list-'+lista, JSON.stringify(itemsa))
    }

    this.shuffle = function (list){
      let items = JSON.parse(sessionStorage.getItem('list-'+list))

      for (let i = items.length - 1; i > 0; i--) {
          let j = Math.floor(Math.random() * (i + 1));
          let temp = items[i];
          items[i] = items[j];
          items[j] = temp;
      }

      sessionStorage.setItem('list-'+list, JSON.stringify(items))
      return this;
    }

    this.get = function (list){
      try {
        return JSON.parse(sessionStorage.getItem('list-'+list));
      } catch {
        return false;
      }
    }
  });

window.Spotifynt = new (function () {
  let port = "8337";
  let url = "http://localhost";

  this.player = new (function () {
    this.show = function(song){
      document.querySelector("#audio-player").src = Spotifynt.command.fileUrl(song.id);
      document.querySelector("#text-songTitle").textContent = song.title
      document.querySelector("#text-songArtist").textContent = song.artist
      document.querySelector("#img-songArt").src =  Spotifynt.command.artUrl(song.album_id)
      document.querySelector("#row-player").hidden = false;

      Spotifynt.metadata.set(song, Spotifynt.command.artUrl(song.album_id))

      Spotifynt.displayPlayer(true);

      const fac = new FastAverageColor();

      fac.getColorAsync(document.querySelector("#img-songArt").src)
          .then(color => {
            document.querySelector("#app").style.backgroundColor = color.hex + "99"
            document.querySelector("meta[name='theme-color'").content = color.hex;
          })
          .catch(e => console.log(e));
      }
  });

  this.playlist = new(function () {

    function get(playlist="playlist-actual") {
      return Lists.get(playlist);
    }
    this.new = function(playlist, songs){
      let items = []
      for (let song of songs){
        items.push(song.id)
      }
      Lists.clear(playlist)
      Lists.store(playlist, items)
      Lists.removeDuplicates(playlist)

      return this;
    }
    this.load = function(songs, random=false, playlist="playlist-actual") {
      if(random){
        Lists.shuffle(songs);
      }
      Lists.appendOrStore(playlist, get(songs));
      Lists.removeDuplicates(playlist)
      return this;
    }

    this.clear = function(playlist="playlist-actual") {
      Lists.clear(playlist);

      return this;
    }

    this.play = function(i=false, playlist="playlist-actual") {
      if (i === false){
        i = parseInt(sessionStorage.getItem("playlist-actual-i"));
      }
      sessionStorage.setItem("playlist-actual-i", i);
      Spotifynt.command.item(get(playlist)[i])
        .then(song => {
          Spotifynt.player.show(song)
          Spotifynt.player_playpause("play");
        })

    }

    this.move = function(i, playlist="playlist-actual") {
      let length = get(playlist).length;
      let actual = parseInt(sessionStorage.getItem("playlist-actual-i"));
      let nuevo = (((actual + i) % length) + length) % length;
      sessionStorage.setItem("playlist-actual-i", nuevo);

      return this;
    }

  })

  this.metadata = new (function () {
    this.set = function (item, image){
      navigator.mediaSession.metadata = new MediaMetadata({
        title: item.title,
        artist: item.artist,
        album: item.album,
        artwork: [
          { src: image, sizes: '512x512', type: 'image/png' },
        ]
      });
    }
  });

  this.command = new (function () {
    this.getAlbumSongs = function (id){

      return command(`album/${id}?expand`)
    }

    this.item = function (id){

      return command(`item/${id}`)
    }

    this.querySong = function (query){

      return command(`item/query/${query}`)
    }

    this.queryAlbum = function (query){

      return command(`album/query/${query}`)
    }

    this.artUrl = function (id){

      return `${url}:${port}/album/${id}/art`
    }

    this.fileUrl = function (id){

      return `${url}:${port}/item/${id}/file`
    }

    function command(arg){
      return fetch(`${url}:${port}/${arg}`, {method: 'GET'})
        .then(response => response.json())
    }
  });

  this.search = function (query){
    this.command.querySong(query)
      .then(response => {
        let results = response.results
        show_songs(results, 'search')
        Spotifynt.playlist.new('search', results)
      })
      .catch(err => console.error(err))

    this.command.queryAlbum(query)
      .then(response => {
        let results = response.results
        show_albums(results)
      })
      .catch(err => console.error(err))
  }

  this.show_info = function (item=0){
    let list = sessionStorage.getItem("list_showing")
    let song_id = JSON.parse(sessionStorage.getItem(`list-${list}`))[item]

    beet_getItem(song_id)
    .then(song => {
      document.querySelector("#modal-infoBody").innerHTML = ""
      for (e in song) {
        p = document.createElement("p")
        p.innerHTML = `<b>${e}</b>: ${song[e]}`
        document.querySelector("#modal-infoBody").appendChild(p)
      }
      document.querySelector("#modal-infoTitle").textContent = song.title

      $('#modal-info').modal('show')
    })
  }

  this.getAlbumSongs = function (id){
    return Spotifynt.command.getAlbumSongs(id);
  }


  function show_albums(albums) {
    let l = document.querySelector("#div-albumResults");
    l.innerHTML = "";

    for (const [i, album] of albums.entries()){
      let t = document.querySelector("#template-albumResult").cloneNode(true).content;

      t.querySelector("[data-album='title']").textContent = `${album.album}`
      t.querySelector("[data-album='artist']").textContent = `${album.albumartist}`
      t.querySelector("[data-album='art']").src = Spotifynt.command.artUrl(album.id)
      t.querySelector("[data-album='append']").addEventListener("click", () => {
        Spotifynt.getAlbumSongs(album.id)
        .then(songs => Spotifynt.playlist.new(`album-${album.id}`, songs.items).load(`album-${album.id}`))
      })
      t.querySelector("[data-album='play']").addEventListener("click", () => {

        Spotifynt.getAlbumSongs(album.id)
        .then(songs => {
          Spotifynt.playlist.new(`album-${album.id}`, songs.items).clear().load(`album-${album.id}`).play(0)
        })
      })
      //t.querySelector(".list-song-info").onclick = () => show_info(i);

      //if (song.format === "FLAC"){
        //t.querySelector(".list-song-title").classList.add('mdi')
        //t.querySelector(".list-song-title").classList.add('mdi-quality-high')
      //}

      l.appendChild(t);

    }
    Spotifynt.displayAlbumResults(true);
  }

  function show_songs(songs, list){
    sessionStorage.setItem("list_showing", list);
    //document.querySelector("#row-songResults").hidden = false;
    let l = document.querySelector("#div-songResults");
    l.innerHTML = "";

    for (const [i, song] of songs.entries()){
      let t = document.querySelector("#template-songResult").cloneNode(true).content;

      t.querySelector("[data-song='title']").textContent = `${song.title}`
      t.querySelector("[data-song='artist']").textContent = `${song.artist}`
      //t.querySelector(".list-song-album").textContent = `${song.album}`
      //t.querySelector(".list-song-play").onclick = () => btn_play(i);
      //t.querySelector(".list-song-info").onclick = () => show_info(i);

      //if (song.format === "FLAC"){
        //t.querySelector(".list-song-title").classList.add('mdi')
        //t.querySelector(".list-song-title").classList.add('mdi-quality-high')
      //}

      l.appendChild(t);

    }

    Spotifynt.displaySongResults(true);
  }


  this.btn_play = function (i){
    let list = sessionStorage.getItem("list_showing");
    list.clear('playlist')
    list.merge('playlist', list)
    playlist_play(i)
  }

  this.player_playpause = function (action=""){
    let player = document.querySelector("#audio-player");
    if (player.paused || action === "play"){
      sessionStorage.setItem("player_playing", 'playing');

      document.querySelector("#icon-pause").hidden = false;
      document.querySelector("#icon-play").hidden = true;

      player.play()

    }else if(!player.paused || action === "pause"){
      sessionStorage.setItem("player_playing", 'paused');

      document.querySelector("#icon-play").hidden = false;
      document.querySelector("#icon-pause").hidden = true;

      player.pause()
    }
  }

  this.displaySongResults = function (e){
    document.querySelector("#row-songResults").hidden = !e
  }

  this.displayAlbumResults = function (e){
    document.querySelector("#row-albumResults").hidden = !e
  }

  this.displayPlayer = function (e){
    document.querySelector("#row-player").hidden = !e
  }

});

navigator.mediaSession.setActionHandler('play', () => Spotifynt.player_playpause('play'));
navigator.mediaSession.setActionHandler('pause', () => Spotifynt.player_playpause('pause'));
navigator.mediaSession.setActionHandler('previoustrack', () => Spotifynt.playlist.move(-1).play());
navigator.mediaSession.setActionHandler('nexttrack', () => Spotifynt.playlist.move(1).play());

document.querySelector('#input-search').addEventListener('change', e => Spotifynt.search(e.target.value))
document.querySelector("#audio-player").addEventListener('ended', () => Spotifynt.playlist.move(1).play())
document.querySelector("#btn-nextSong").addEventListener('click', () => Spotifynt.playlist.move(1).play())
document.querySelector("#btn-prevSong").addEventListener('click', () => Spotifynt.playlist.move(-1).play())
document.querySelector("#btn-playpause").addEventListener('click', () => Spotifynt.player_playpause())

document.querySelector("#btn-playPlaylist").addEventListener('click', () => {
  Spotifynt.playlist.clear().load("search", true).play(0);
})

document.querySelector("#btn-appendPlaylist").addEventListener('click', () => {
  Spotifynt.playlist.load("search")
})

window.addEventListener('beforeunload', e => {
  e.preventDefault();
  e.returnValue = '';
});
