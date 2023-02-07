<h1>註冊會員葉面。</h1>
<fieldset>
    <legend>會員註冊</legend>
    <div style="color:red">*請設定您要註冊的帳號及密碼(最長12個字元)</div>
    <table>
        <tr>
            <td>Step1:登入帳號</td>
            <td><input type="text" name="acc" id="acc"></td>
        </tr>
        <tr>
            <td>Step2:登入密碼</td>
            <td><input type="password" name="pw" id="pw"></td>
        </tr>
        <tr>
            <td>Step3:再次確認密碼</td>
            <td><input type="password" name="pw2" id="pw2"></td>
        </tr>
        <tr>
            <td>Step:信箱(忘記密碼時使用)</td>
            <td><input type="text" name="email" id="email"></td>
        </tr>
        <tr>
            <td>
                <button onclick="reg()">註冊</button>
                <button onclick="reset()">清除</button>
            </td>
            <td></td>
        </tr>
    </table>
</fieldset>
<script>
    function reset() {
        $("#acc,#pw,#pw2,#email").val("")
    }

    function reg() {
        let regs = {
            acc: $("#acc").val(),
            pw: $("#pw").val(),
            pw2: $("#pw2").val(),
            email: $("#email").val(),
        }
        if (regs.acc === "" || regs.pw === "" || regs.pw2 === "" || regs.email === "") {
            alert("不得空白")
        } else {
            // 沒空白
            if (regs.pw == regs.pw2) {
                $.post("./api/chk_acc.php", regs, (result) => {
                    //如果有帳號一樣及回傳帳號重覆。
                    if (parseInt(result) === 1) {
                        alert("帳號重複")
                    } else {
                        // 不重複
                        $.post("./api/reg.php", regs, () => {
                            alert("註冊完成，歡迎加入")
                            reset();
                        })
                    }
                })
            }else{
                alert("密碼錯誤")
            }
        }
    }
</script>