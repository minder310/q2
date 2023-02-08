<fieldset>
    <legend>目前位置:首頁 >最新文章區</legend>
    <table>
        <tr>
            <td width="30%">標題</td>
            <td width="50%">內容</td>
            <td></td>
        </tr>
        <?php
        $all=$News->count(['sh'=>1]);
        $div=5;
        $pages=ceil($all/$div);
        $now=$_GET['p']??1;
        $start=($now-1)*$div;

        $rows=$News->all(['sh'=>1]," limit $start,$div");
        foreach($rows as $row){
        ?>
            <tr></tr>
        <?php } ?>
    </table>
</fieldset>