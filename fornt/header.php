<div class="title">
    <?=date("m月d號 l");?>
    |今日導覽:<?=$total->find(['date'=>date("Y-m-d")])['total'];?>
    |累積導覽:<?=$total->sum("total");?>
    <!--                       float(浮動元素)，靠右邊。 -->
    <a href="index.php" style="float:right">回首頁</a>
</div>
<div class="title2">
    <a href="index.php" title="健康促進網-回首頁">
        <img src="./icon/02B01.jpg" alt="">
    </a>
</div>