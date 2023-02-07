<h1>我是登陸葉面唷</h1>
<fieldset>
    <table>
        <tr>
            <td>帳號</td>
            <td><input type="text" name="acc" id="acc"></td>
        </tr>
        <tr>
            <td>密碼</td>
            <td><input type="password" name="pw" id="pw"></td>
        </tr>
        <tr>
            <td>
                <button>登入</button>
                <button onclick="reset()">清除</button>
            </td>
            <td>
                <a href="?do=forgot">忘記密碼</a>
                <a href="?do=reg">尚未註冊</a>
            </td>
        </tr>
    </table>
</fieldset>

<script>
        function reset() {
            // 做了什麼動作，id=acc,pw=""刪除acc,pw內資料。
            $("#acc", "#pw").val("")
        }
        function login(){
            let user={
                // 宣告陣列acc跟pw綁定，裡面的val值。
                acc:$("#acc").val(),
                pw:$("#pw").val(),
            }
            // 確認有此帳號。
            $.post("./api/chk_acc.php",user,(result)=>{
                console.log(result);
                // 回傳值轉為整數，並且===類型，數字，數量都對。
                if(parseInt(result)===1){
                    // 有此帳號。
                    $.post("./api/chk_pw.php",user,(result)=>{
                        console.log(result);
                        if(parseInt(result)===1){
                            // 帳密正確。
                            // 此段為判斷是不是gm帳戶。
                            if(user.acc==='admin'){
                                location.href="back.php";
                            }else{
                                location.href="index.php";
                            }
                        }
                    })
                }else{
                    
                    // 密碼錯誤
                    alert("密碼錯誤。")
                    reset()
                }
            })
        }
        
</script>