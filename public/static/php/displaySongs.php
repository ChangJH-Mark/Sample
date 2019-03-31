<?php
/**
 * Created by PhpStorm.
 * User: 常佳辉
 * Date: 2019/3/26
 * Time: 17:25
 */
echo "<html>
      <head>
      <meta charset='UTF-8'/>
      <title>展示歌曲</title>
</head>
<body>
<table border='1'>
    <tr>
        <th>id</th>
        <th>名字</th>
        <th>作者</th>
        <th>专辑</th>
        <th>地址</th>
        <th>播放列表</th>
</tr>";
$json=json_decode($data);
if(is_array($json))
foreach($json as $item)
{
    $id=$item->id??null;
    $name=$item->name??null;
    $author=$item->author??null;
    $album=$item->album??null;
    $position=$item->position??null;
    $playlist=$item->playlist??null;
    echo "<tr>
    <td>{$id}</td>
    <td>{$name}</td>
    <td>{$author}</td>
    <td>{$album}</td>
    <td>{$position}</td>
    <td>{$playlist}</td>
</tr>";
}
echo "</body></table></html>";