<?php
include_once "./base.php";

$type=$_GET['type'];

$lists=$news->all(['type'=>$type,"sh"=>1]);

foreach($lists as $list){ ?>
    <a href="#" style="display: block;" onclick="getNews(<?=$list['id']?>)">
    <?= $list['title']?>
    </a>
 <?php } ?>