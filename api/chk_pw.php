<?php
    include_once "./base.php";
    // 這邊chk是一個回傳值，如果大於0就代表帳號密碼正確。
    $chk=$user->count(['acc'=>$_POST['acc'],'pw'=>$_POST['pw']]);
    
    // 如果chk>0代表帳號密碼正確，所以就可以帶入SESSION值，代表帳號登入。
    if($chk>0){
        echo $chk;
        $_SESSION['login']=$_POST['acc'];
    }else{
        echo $chk;
    }
    