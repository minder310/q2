<style>
    .tab{
        padding: 3px;
        border: 1px solid gray;
        margin-left: -1px;
        /* 這句不知道什麼意思。 */
        cursor: pointer;
        background-color: #eee;
    }
    .active{
        background-color: white;
        border-bottom: white;
    }
    .box{
        border: 1px solid gray;
        width: 95%;
        margin-top: -1px;
    }
</style>
<h1>我是首頁唷。</h1>
<div style="display:flex;padding-left:1px">
    <div class="tab active">健康新知</div>
    <div class="tab">菸害防制</div>
    <div class="tab">癌症防治</div>
    <div class="tab">慢性病防治</div>
</div>
<div class="box">
    <h2>健康新知</h2>
    <pre>文章內容</pre>
</div>
<div class="box">
    <h2>菸害防制</h2>
    <pre>文章內容</pre>
</div>
<div class="box">
    <h2>癌症文章</h2>
    <pre>文章內容</pre>
</div>
<div class="box">
    <h2>慢性病預防</h2>
    <pre>文章內容</pre>
</div>

<script>
    // 隱藏全部文章
    $(".box").hide()
    // 顯示第一篇
    $(".box").eq(0).show();

    $(".tab").on("click",(e)=>{
        // 先移除全部的active。
        $('.tab').removeClass('active');
        // 針對點擊葉面加入active。
        $(e.target).addClass('active');
        // 隱藏所有.box的文章。
        $(".box").hide();

        // 這邊看不懂。e是指自己，index()是將數值顯示出來。
        // console.log($(e.target).index());
        $(".box").eq($(e.target).index()).show();
    })
</script>