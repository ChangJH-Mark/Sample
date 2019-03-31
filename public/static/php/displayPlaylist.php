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
      <title>展示歌曲列表</title>
</head>
<body>
<table border='1'>
    <tr>
        <th>id</th>
        <th>名字</th>
        <th>用户</th>
        <th>描述</th>
</tr>";
$json=json_decode($data);
if(is_array($json))
foreach($json as $item)
{
    $id=$item->id??null;
    $name=$item->name??null;
    $author=$item->user??null;
    $describtion=$item->describtion??null;
    echo "<tr>
    <td>{$id}</td>
    <td>{$name}</td>
    <td>{$author}</td>
    <td>{$describtion}</td>
</tr>";
}
echo "</body></table></html>";