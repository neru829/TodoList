<?php
    session_start();
    $error_msg = array();

    if(!empty($_POST)){
        $email = $_POST['email'];

        //データベースの情報
        $hostname = '***.***.***.***';
        $username = '****';
        $password = '******';

        $dbname = 'todo';
        $tablename = 'user';

        $link = mysqli_connect($hostname, $username, $password);
        if(!$link){ exit("Connect error!"); }

        $result = mysqli_query($link, "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8");
        if(!$result){ exit("Create DB failed!"); }

        $result = mysqli_query($link, "USE $dbname");
        if(!$result){ exit("Use failed!"); }

        $result = mysqli_query($link, "CREATE TABLE IF NOT EXISTS $tablename (id INT NOT NULL AUTO_INCREMENT, name BLOB, email BLOB, password BLOB, PRIMARY KEY(id))CHARACTER SET utf8");
        if(!$result){ exit("Create table failed!"); }

        $result = mysqli_query($link, "SELECT * FROM $tablename WHERE email = '$email'");
        $row = mysqli_fetch_assoc($result);

        if(empty($row)){
            if(!($_POST['pass'] === $_POST['pass2'])){
                $_SESSION['name'] = $_POST['name'];
                $_SESSION['email'] = $_POST['email'];
                $error_msg['pass'] = 'パスワードが正しくありません。';
            } else {
                $_SESSION['name'] = $_POST['name'];
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['pass'] = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                header('Location: http://127.0.0.1:10800/~sspuser/task_final/confirm.php?');
                exit;
            }
        } else {
            $error_msg['email'] = '登録済みのメールアドレスです。';
        }
        mysqli_free_result($result);
        mysqli_close($link);
    }

    
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
            <div class="box-register">
                <h2>アカウント登録</h2>
                <p>セキュリティ対策が不完全なため、通常使用しているメールアドレスやパスワードは入力しないでください。</p>
                <form method="post" action="">
                    <div class="flex">
                        <label>ユーザネーム</label>
                        <input type="text" name="name" value="<?php if(isset($_SESSION['name'])){echo $_SESSION['name'];} ?>" required>
                        <label>メールアドレス</label>
                        <div class="error_msg"><?php if(!empty($error_msg['email'])){ echo $error_msg['email'];} ?></div>
                        <input type="email" pattern="^[a-zA-Z0-9.!#$&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$" name="email" value="<?php if(isset($_SESSION['email'])){echo $_SESSION['email'];} ?>" required>
                        <label>パスワード(半角英数)</label>
                        <div class="error_msg"><?php if(!empty($error_msg['pass'])){ echo $error_msg['pass'];} ?></div>
                        <input type="password" pattern="^[0-9A-Za-z]+$" name="pass" required>
                        <label>パスワード(確認用)</label>
                        <input type="password" pattern="^[0-9A-Za-z]+$" name="pass2" required>                            
                        <div class="buttons">
                            <button type="button" onclick="history.back()" class=" btn negative">戻る</button>
                            <button type="submit" class="btn positive">確認へ</button>
                        </div>
                    </div>
                </form>
<?php
    //セッション
    session_destroy();
?>
        </div>
    </body>
</html>