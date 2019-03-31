<?php
/**
 * Created by PhpStorm.
 * User: 常佳辉
 * Date: 2019/3/25
 * Time: 23:11
 */

namespace Controller\User;

use Controller\BaseController;
use GuzzleHttp\Client;

$baseDir=__DIR__.'/../../';
if(file_exists($baseDir.'function.php'))
{
    include $baseDir.'function.php';
}
else{
    renderData("Error:   file function.php not found");
}
class UserController extends BaseController
{
    public function getAllUsers()
    {
        $mysql=connectSql();
        $query="select * from users";
        $result=$mysql->query($query);
        while($result and $raw=$result->fetch_object())
        {
            $ans[]=$raw;
        }
        if($mysql->errno!=0)
        {
            $error=$mysql->error;
            $mysql->close();
            renderData($error);
        }
        else{
            $data=json_encode($ans??[]);
            include $this->baseDir.'public/static/php/displayUsers.php';
        }
    }

    public function createUser()
    {
        if(empty($_POST))
        {
            header('location:/static/createUser.html');
        }
        $mysql=connectSql();
        $postData=array_filter($_POST);
        $colums=implode(',',array_keys($postData));
        foreach($postData as $key=>$value)
        {
            str_replace('"','\'',$value);
            $postData[$key]="\"$value\"";
        }
        $values=implode(',',$postData);
        $query="insert into users ($colums) values ($values)";
        $mysql->query($query);
        $error=$mysql->error;
        if($mysql->errno!=0) {
            $mysql->close();
            renderData("$error");
        }
        else {
            $mysql->close();
            renderData("success");
        }
    }

    public function showPlaylist()
    {
        $id=$_GET['id']??0;
        $client=New Client();
        try {
            $response = $client->request('GET', 'playlist.test.com/api/getPlaylistByUser?user=' . $id,['timeout'=>5]);
            $data=$response->getBody()->getContents();
            include $this->baseDir.'public/static/php/displayPlaylist.php';
        }catch (\Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function haveUser()
    {
        $id=$_GET['id']??0;
        if(!is_numeric($id))
            renderData("no");
        $mysql=connectSql();
        $query="select * from users where id=$id";
        $result=$mysql->query($query);
        $mysql->close();
        if($result and $result->fetch_row())
            renderData("yes");
        else
            renderData("no");
    }
}