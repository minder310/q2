<!-- 熱門文章頁面。 -->
<style>
    .full {
        display: none;
        position: absolute;
        background-color: rgb(100, 100, 100);
        z-index: 99;
        padding: 1rem;
        box-shadow: 0 0 10px #999;
        left: -10px;
        top: 5px;
        width: 95%;
        height: 500px;
        overflow: auto;
    }

    .news-title {
        cursor: pointer;
        background-color: #eee;
    }

    .a {
        width: unset;
    }
</style>
<fieldset>
    <legend>目前位置:首頁>人氣文章</legend>
    <table>
        <tr>
            <td width="30%" ;></td>
            <td width="50%" ;></td>
            <td>人氣</td>
        </tr>
        <?php
        // 先取出全部的值
        $all = $news->count(["sh" => 1]);
        // dd($all);
        // 一頁顯示的數量。
        $div = 5;
        // 取最大整數。
        $pages = ceil($all / $div);
        // 用get判斷現在再第幾頁。??if(isset$_get['p'])如果有輸出$grt['p']，如果沒有輸出1;
        $now = $_get['p'] ?? 1;
        // 這句不知道。
        $start = ($now - 1) * $div;
        echo $now;
        echo $start;

        // 取出所有資料表內的資料，並且依照good的數量進行排列。
        $rows = $news->all(['sh' => 1], " order by `good` desc limit $start,$div");


        foreach ($rows as $row) {
        ?>
            <tr>
                <!-- 取出資料表中的抬頭。 -->
                <td class="news-title"><?= $row['title']; ?></td>
                <td style="position: relative;">
                    <!-- 取出文章前20個字，並且顯示。 -->
                    <div class="short"><?= mb_substr($row['text'], 0, 20) ?>...</div>
                    <div class="full">
                        <h3 style="color:skyblue"><?php $news->type[$row['type']] ?></h3>
                        <div style="color: white"><?php echo nl2br($row['text']) ?></div>
                    </div>
                </td>
                <td>
                    <span class="unm"><?php $log->count(['news' => $row['id']]) ?></span>
                    個人說:
                    <!-- 讚的點擊圖案。 -->
                    <img src="./icon/02b03.jpg" alt="" style="width:20px;height: 20px;">
                    <?php
                    // 判斷是否有登錄。
                    if (isset($_SESSION['login'])) {
                        // 判斷是否按過讚，如果案過讚，用count搜尋時數值就會大於，就代表投過票。
                        if ($log->count(['news' => $row['id'], 'user' => $_SESSION['login']])) {
                            echo "<a href='#' class='goods' data-user='{$_session['loging']} data-news='{$row['id']}'>";
                            echo "收回讚";
                            echo "</a>";
                        } else {
                            // 代表沒點過讚。
                    ?>
                            <a href="#" class="goods" data-user="<?= $_session['login']; ?>" data-news="<?= $_session['id']; ?>">
                                讚
                            </a>
                    <?php }
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div>
        <!-- 宣告上一頁下一頁的地方。 -->
        <?php 
        // 避免頁數=0，所以寫這段。
        if(($now-1)>0){
            $prev=$now-1;
            echo "<a href='index.php?do=pop&p=prve'>　< </a>";
        }

        for($i=1;$i<=$pages;$i++){
            // 這邊的ｓｉｚｅ是表示現在顯示在哪一頁。
            $size=($now==$i)?"26px":"16px";
            ?>
            <a href="index.php?do=pop&p=<?=$i?>" style="font-size: <?=$size?>;"><?=$i?></a>
            <?php
        }
        // 要是大於等於１就＋１頁。
        if($now+1<=$pages){
            $next=$now+1;
            echo "<a href='index.php?do=pop&p=$next'";
        }
        ?>
    </div>
</fieldset>
<script>
    $(".news-title").hover(
        function(){
            $(this).next().children('.full').show()
        },
        function(){
            $(this).next().children('.full').hide()
        }
    )
</script>
