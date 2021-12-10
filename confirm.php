<?php
    session_start();
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
            <h1>Todo</h1>
            <div class="box-confirm">
                <h2>確認画面</h2>
                <form method="post" action="mypage.php">
                    <div class="flex">
                        <p>以下の内容でよろしければ登録ボタンをクリックしてください。</p>
                        <p>内容を変更する場合は戻るボタンをクリックして入力画面にお戻りください。</p>
<?php
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $pass = $_SESSION['pass'];

        echo '<label>ユーザネーム</label>';
        echo '<p>'.htmlspecialchars($name).'</p>';
        echo '<label>メールアドレス</label>';
        echo '<p>'.htmlspecialchars($email).'</p>';
        echo '<label>パスワード</label>';
        echo '<p>パスワードはセキュリティの観点から表示しません。</p>';
?>
                    <input type="hidden" name="name" value="<?php echo $_SESSION['name']; ?>">
                    <input type="hidden" name="email"  value="<?php echo $_SESSION['email']; ?>">
                    <input type="hidden" name="pass"  value="<?php echo $_SESSION['pass']; ?>">
                        <div class="buttons">
                            <button type="button" onclick="history.back()" class=" btn negative">修正</button>
                            <button type="submit" class="btn positive">登録</button>
                        </div>
                    </div>
                </form>
            </div>
<?php
            session_destroy();
?>
        </div>
    </body>
</html>