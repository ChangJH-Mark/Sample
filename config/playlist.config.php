<?php
/**
 * Created by PhpStorm.
 * User: 常佳辉
 * Date: 2019/3/25
 * Time: 21:27
 */
use NoahBuscher\Macaw\Macaw;
header("Content-type: text/html; charset=utf-8");
Macaw::get('/',function(){
    echo "playlist service works";
});

Macaw::get('/all','\Controller\Playlist\PlaylistController@getAllPlaylists');

Macaw::get('/create','\Controller\Playlist\PlaylistController@createPlaylist');

Macaw::post('/create','\Controller\Playlist\PlaylistController@createPlaylist');

Macaw::get('/show','\Controller\Playlist\PlaylistController@showPlaylist');

Macaw::get('/api/getPlaylistByUser','\Controller\Playlist\PlaylistController@getPlaylistByUser');

Macaw::get('/api/havePlaylist','\Controller\Playlist\PlaylistController@havePlaylist');
Macaw::dispatch();