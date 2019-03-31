<?php
/**
 * Created by PhpStorm.
 * User: 常佳辉
 * Date: 2019/3/28
 * Time: 17:27
 */
use NoahBuscher\Macaw\Macaw;

header("Content-type: text/html; charset=utf-8");

Macaw::get('/songs/all','\Controller\TestApi\TestApiController@getAllSongs');

Macaw::get('/localLog','\Controller\TestApi\TestApiController@localLog');
Macaw::dispatch();