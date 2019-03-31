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
      <title>展示用户</title>
</head>
<body>
<table border='1'>
    <tr>
        <th>id</th>
        <th>名字</th>
        <th>密码</th>
</tr>";
$json=json_decode($data);
if(is_array($json))
foreach($json as $item)
{
    $id=$item->id??null;
    $name=$item->name??null;
    $password=$item->password??null;
    echo "<tr>
    <td>{$id}</td>
    <td>{$name}</td>
    <td>{$password}</td>
</tr>";
}
echo "</body></table></html>";