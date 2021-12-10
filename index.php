<?php
    session_start();
    session_destroy();
    $_SESSION = array();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <link href="http://fonts.googleapis.com/earlyaccess/notosansjp.css">
        <link rel="stylesheet" href="style.css">
        <title>Todo</title>
    </head>
    <body>
        <div class="container">
            <div class="nav">
                <h1>Todo</h1>
                <form action="login.php">
                    <button class="btn btn-color">ログイン</button>
                </form>
            </div>
            <form action="register.php" class="btn-register">
                <p>＼まずはご登録から！／</p>
                <button class="btn btn-color">新規登録</button>
            </form>
        </div>
    </body>
</html>