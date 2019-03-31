<?php
/**
 * Created by PhpStorm.
 * User: 常佳辉
 * Date: 2019/3/24
 * Time: 11:30
 */
use NoahBuscher\Macaw\Macaw;

header("Content-type: text/html; charset=utf-8");

Macaw::get('/',function(){
   echo "song service works";
});

Macaw::get('/all','\Controller\Songs\SongsController@getAllSongs');
Macaw::get('/api/all','\Controller\Songs\SongsController@getAllSongs');

Macaw::get('/create','\Controller\Songs\SongsController@createSong');

Macaw::post('/create','\Controller\Songs\SongsController@createSong');

Macaw::get('/getSongById','\Controller\Songs\SongsController@getSongById');

Macaw::get('/api/getSongByPlaylist','\Controller\Songs\SongsController@getSongByPlaylist');

Macaw::post('/update','\Controller\Songs\SongsController@updateSong');

Macaw::get('/update','\Controller\Songs\SongsController@updateSong');
Macaw::dispatch();