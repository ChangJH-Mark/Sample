<?php
/**
 * Created by PhpStorm.
 * User: 常佳辉
 * Date: 2019/3/25
 * Time: 23:09
 */
use NoahBuscher\Macaw\Macaw;
header("Content-type: text/html; charset=utf-8");

Macaw::get('/',function(){
   echo "user service works";
});

Macaw::get('/all','\Controller\User\UserController@getAllUsers');

Macaw::post('/create','\Controller\User\UserController@createUser');

Macaw::get('/create','\Controller\User\UserController@createUser');

Macaw::get('/showPlaylist','\Controller\User\UserController@showPlaylist');

Macaw::get('/api/haveUser','\Controller\User\UserController@haveUser');
Macaw::dispatch();