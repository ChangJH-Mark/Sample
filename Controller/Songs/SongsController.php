<?php
/**
 * Created by PhpStorm.
 * User: 常佳辉
 * Date: 2019/3/25
 * Time: 15:57
 */
namespace Controller\Songs;

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

class SongsController extends BaseController
{
    public function getAllSongs()
    {
        $uri=$_SERVER['REQUEST_URI'];
        $mysql=connectSql();
        $query="select * from songs";
        $result=$mysql->query($query);
        while($result and $raw=$result->fetch_object())
        {
            $ans[]=$raw;
        }
        $mysql->close();
        if(strpos($uri,"/api/")===0)
            renderData($ans??[]);
        else
        {
            $data=json_encode($ans??[]);
            include $this->baseDir."public/static/php/displaySongs.php";
        }
    }

    public function createSong()
    {
        if(empty($_POST))
        {
            header('location:/static/createSong.html');
        }
        $mysql=connectSql();
        $colums=implode(',',array_keys($_POST));
        foreach($_POST as $key=>$value)
        {
            str_replace('"','\'',$value);
            if($key=="position")
            {
                $value="/home/mark/music".$value;
            }
            $_POST[$key]="\"$value\"";
        }
        $values=implode(',',$_POST);
        $query="insert into songs ($colums) values ($values)";
        $mysql->query($query);
        $error=$mysql->error;
        if($mysql->errno!=0)
            renderData("$error");
        else
            renderData("success <a href='create'>继续添加</a>");
    }

    public function getSongById()
    {
        $id=$_GET['id']??0;
        $mysql=connectSql();
        $query="select * from songs where id=$id";
        $result=$mysql->query($query);
        while($raw=$result->fetch_object())
        {
            $data[]=$raw;
        }
        if(count($data??[])<=0)
        {
            renderData("Song that id=$id does not exist, check if id is specified.");
        }
        renderData($data??[]);
    }

    public function getSongByPlaylist()
    {
        $playlist=$_GET['playlist']??0;
        $mysql=connectSql();
        $query="select * from songs where playlist=$playlist";
        $result=$mysql->query($query);
        while($raw=$result->fetch_object())
        {
            $data[]=$raw;
        }
        if(count($data??[])<=0)
        {
            renderData("Playlist that id=$playlist does not exist");
        }
        $mysql->close();
        renderData($data??[]);
    }

    public function updateSong()
    {
        if(empty($_POST))
        {
            header('location:/static/updateSong.html');
        }
        $postData=array_filter($_POST);
        $this->checkPlaylistExistence($postData['playlist']??0);
        $mysql=connectSql();
        $statement="update songs set ";
        foreach($postData as $key=>$value)
        {
            str_replace('"','\'',$value);
            if($key=="position")
            {
                $value="/home/mark/music".$value;
            }
            if($key!="id")
            {
                if($key!="playlist")
                    $value="\"$value\"";
                $statement.=$key."=$value,";
            }
        }
        $statement=substr($statement,0,strlen($statement)-1);
        $statement.=" where id={$postData['id']}";
        $mysql->query($statement);
        if($mysql->errno!=0) {
            $error=$mysql->error;
            $mysql->close();
            renderData($error);
        }
        else {
            $mysql->close();
            renderData("updateSuccess");
        }
    }

    private function checkPlaylistExistence($id)
    {
        $client=New Client();
        try{
            $response=$client->request('GET','playlist.test.com/api/havePlaylist?id='.$id,['timeout'=>5]);
            $data=$response->getBody()->getContents();
            if($data=="\"yes\"")
                return;
            else
                renderData("playlist that id=$id does not exist");
        }catch (\Exception $e)
        {
            renderData($e->getMessage());
        }
    }
}