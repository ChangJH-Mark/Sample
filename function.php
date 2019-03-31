<?php
/**
 * Created by PhpStorm.
 * User: 常佳辉
 * Date: 2019/3/25
 * Time: 16:47
 */
use Symfony\Component\HttpFoundation\Response;
function connectSql()
{
    $mysql=new mysqli('localhost','root','cjh123','mytest');
    if($mysql->errno==0)
        return $mysql;
    else
    {
        return "Error in Connect DB:</br>".$mysql->error;
    }
}
function renderData($data){
    $response=Response::create();
    $data=json_encode($data,JSON_UNESCAPED_UNICODE);
    $response->setContent($data);
    $response->send();
    exit();
}