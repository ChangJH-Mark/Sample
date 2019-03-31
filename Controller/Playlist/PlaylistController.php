<?php
/**
 * Created by PhpStorm.
 * User: 常佳辉
 * Date: 2019/3/25
 * Time: 21:29
 */

namespace Controller\Playlist;
use Controller\BaseController;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

$baseDir=__DIR__.'/../../';
if(file_exists($baseDir.'function.php'))
{
    include $baseDir.'function.php';
}
else{
    renderData("Error:   file function.php not found");
}

class PlaylistController extends BaseController
{
    public function getAllPlaylists()
    {
        $mysql=connectSql();
        $query="select * from playlist";
        $result=$mysql->query($query);
        while($result and $raw=$result->fetch_object())
        {
            $data[]=$raw;
        }
        $mysql->close();
        $data=json_encode($data??[]);
        include $this->baseDir.'public/static/php/displayPlaylist.php';
    }

    public function createPlaylist()
    {
        if(empty($_POST))
        {
            header('location:/static/createPlaylist.html');
        }

        $data['name']=$this->request->get('name')??null;
        $data['user']=$this->request->get('user')??null;
        $this->checkUserExistence($data['user']);
        $data['describtion']=$this->request->get('describtion')??null;
        $data=array_filter($data);

        $mysql=connectSql();
        $columns=implode(',',array_keys($data));
        foreach($data as $key=>$value)
        {
            $value='"'.str_replace('"','\"',$value).'"';
            $data[$key]=$value;
        }
        $values=implode(',',$data);

        $query="insert into playlist ($columns) values ($values)";
        $mysql->query($query);
        $error=$mysql->error;
        if($mysql->errno!=0)
            renderData($error);
        renderData("success");
    }

    private function checkUserExistence($user)
    {
        $client=New Client();
        try{
            $response=$client->request('GET','user.test.com/api/haveUser?id='.$user,['timeout'=>5]);
            $data=$response->getBody()->getContents();
            if($data=="\"yes\"")
                return;
            else
                renderData("user that id=$user does not exist");
        }catch (\Exception $e)
        {
            renderData($e->getMessage());
        }
    }

    public function showPlaylist()
    {
        $id=$_GET['id']??0;
        try {
            $client = new Client();
            $response=$client->request('GET','http://song.test.com/api/getSongByPlaylist?playlist='.$id,['timeout'=>5]);
            $data=$response->getBody()->getContents();
            include $this->baseDir.'public/static/php/displaySongs.php';
        }catch (\Exception $e)
        {
            print_r($e->getMessage());
        }
    }

    public function getPlaylistByUser()
    {
        $user=$_GET['user']??0;
        $mysql=connectSql();
        $query="select * from playlist where user=".$user;
        $result=$mysql->query($query);
        while($result and $raw=$result->fetch_object())
        {
            $ans[]=$raw;
        }
        $error=$mysql->error;
        if($mysql->errno!=0)
        {
            $mysql->close();
            renderData($error);
        }else{
            $mysql->close();
            renderData($ans??[]);
        }
    }

    public function havePlaylist()
    {
        $id=$_GET['id']??0;
        $mysql=connectSql();
        $query="select * from playlist where id=$id";
        $result=$mysql->query($query);
        $mysql->close();
        if($result->fetch_object())
            renderData("yes");
        else
            renderData("no");
    }
}