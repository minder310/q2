<?php 
include_once "./base.php";

// 判斷是哪一篇文章。
$news=$_POST['news'];
// 判斷是哪一個帳號。
$user=$_POST['user'];

// 確認是否有投過票的。
$chk=$log->count(['news'=>$news,'user'=>$user]);
$row=$news->find($news);

if($chk)
