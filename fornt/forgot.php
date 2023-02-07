<h1>忘記密碼頁面</h1>
<fieldset>
    <legend>忘記密碼</legend>
    <div>請輸入信箱以查詢密碼</div>
    <div><input type="text" name="email" id="email"></div>
    <div id="result"></div>
    <div>
        <button onclick="forgot()">尋找</button>
    </div>
</fieldset>

<script>
    function forgot(){
        $.post("api/forgot.php",{email:$("#email").val()},(result)=>{
            $("#result").text(result)
        })
    }
</script>