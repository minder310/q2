<style>
    .full{
        /* full display:設定為隱藏。 */
        display: none;
    }
    .news-title{
        cursor: pointer;
        background-color: #eee;
    }
</style>
<fieldset>
    <legend>目前位置:首頁 >最新文章區</legend>
    <table>
        <tr>
            <td width="30%">標題</td>
            <td width="50%">內容</td>
            <td></td>
        </tr>
        <?php
        $all = $news->count(['sh' => 1]);
        $div = 5;
        $pages = ceil($all / $div);
        $now = $_GET['p'] ?? 1;
        $start = ($now - 1) * $div;

        $rows = $news->all(['sh' => 1], " limit $start,$div");
        // dd($rows);
        foreach ($rows as $row) {
        ?>
            <tr>
                <td class="news-title"><?= $row['title']; ?></td>
                <td>
                    <!-- 顯示部分內文文章，並且能夠點擊。 -->
                    <div class="short"><?= mb_substr($row['text'], 0, 20); ?>...</div>
                    <div class="full"><?= nl2br($row['text']); ?></div>
                </td>
                <td>
                    <?php
                        // 案讚區。
                        // 要是你有登錄就可。
                        if(isset($_SESSION['login'])){
                            if($log->count(['news'=>$row['id'],'user'=>$_SESSION['login']])>0) { ?>
                            <a href="#" class="goods" data-user='<?= $_SESSION['login']?>' data-news="<?= $row['id'] ?>">收回讚</a>
                            <?php }else{ ?>
                                <a href="#" class="goods" data-user='<?= $_SESSION['login']?>' data-news="<?= $row['id'] ?>">讚</a>
                            <?php }
                        }
                    ?>
                </td>
            </tr>
        <?php } ?>

    </table>
    <div>
        <!-- 這邊是顯示分頁，並且顯示第幾頁，與下一頁上一頁箭頭。區。 -->
        <?php
        if(($now-1)>0){
            $prev=$now-1;
            ?><a href="index.php?do=pop&p=<?=$prev?>"> < </a><?php
        }
        for($i=1;$i<$pages;$i++){
            $size=($now==$i)?"26px":"16px";
            ?><a href="index.php?do=pop&p=<?=$i?>" style="font-size:<?= $size?>;"><?=$i?></a><?php
        }
        if(($now+1)<=$pages){
            $next=$now+1;
            ?><a href="index.php?do=pop&p=<?=$next?>"> > </a><?php
        }
        ?>
    </div>
</fieldset>

<script>
    $(".news-title").on("click", function() {
        $(this).next().children('.short,.full').toggle()
        //點擊的，下一個物件，的子元件(class short 跟 full)，交互顯示。
    })
</script>