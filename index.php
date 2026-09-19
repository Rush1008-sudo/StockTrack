<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to main page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: main.php");
    exit;  //記得要跳出來，不然會重複轉址過多次
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta charset="UTF-8"/>
<title>登入介面</title>
<link rel="stylesheet" href="loginstyle.css">

</head>
<body>

    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="glass-card">
        <h3>Log In</h3>
        <p class="subtitle">歡迎使用股票資產管理系統~</p>

        <div class="visitor-container">
            <a href="main.php" class="visitor-btn">
                🌐 訪客進入：瀏覽股票資訊
            </a>
            <span class="tooltip-text">
                💡 未登入的話只提供瀏覽無法編輯
            </span>
        </div>

        <form method="post" action="login.php">
            
            <label for="username">帳號</label>
            <input type="text" name="username" id="username" placeholder="username" required>

            <label for="password">密碼</label>
            <input type="password" name="password" id="password" placeholder="password" required>

            <button type="submit" name="submit">
                <b>登入</b>
            </button>
            
        </form>
    </div>

</body>
</html>