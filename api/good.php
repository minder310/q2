<?php 
include_once "./base.php";

// 判斷是哪一篇文章。
$news=$_POST['news'];
// 判斷是哪一個帳號。
$user=$_POST['user'];

// 確認是否有投過票的。
// 要是news
$chk=$log->count(['news'=>$news,'user'=>$user]);
$row=$news->find($news);

if($chk>0){
    // 要收回讚。->刪除。
    $log->del(['news'=>$news,'user'=>$user]);
    $row['good']--;
    $news->save($row);
}else{
    // 按讚->新增
    $row["good"]++;
    $log->save(['news'=>$news,'user'=>$user]);
    $news->save($row);
}
