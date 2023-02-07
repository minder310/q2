<?php
include_once './base.php';
echo $user->count(['acc'=>$_POST['acc']]);
