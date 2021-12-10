<?php
    session_start();

    $email = '';
    $pass = '';
    $error_msg = array();

    if(!empty($_POST)){
        $email = $_POST['email'];
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

        //データベースから情報とる
        $hostname = '***.***.***.***';
        $username = '****';
        $password = '******';

        $dbname = 'todo';
        $tablename = 'user';

        $link = mysqli_connect($hostname, $username, $password, $dbname);
        if(!$link){ exit("Connect error!"); }

        $result = mysqli_query($link, "SELECT * FROM user WHERE email = '$email'");
        while($row = mysqli_fetch_assoc($result)){
            $login_user = $row['name'];
            $login_hash_pass = $row['password'];
        }

        mysqli_free_result($result);
        mysqli_close($link);

        //認証
        if((password_verify($_POST['pass'], $login_hash_pass)) && (isset($login_hash_pass))){
            $_SESSION['name'] = $login_user;
            $_SESSION['email'] = $email;

            header('Location: http://127.0.0.1:10800/~sspuser/task_final/mypage.php?');
            exit;
        } else {
            $error_msg['error'] = 'メールアドレスまたはパスワードが違います。';
        }
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
            <form method="post" action="" class="box-login">
                <h2>Login</h2>
                <div class="flex">
                    <div class="error_msg"><?php if(!empty($error_msg['error'])){ echo $error_msg['error'];} ?></div>
                    <input type="email" placeholder="Email" pattern="^[a-zA-Z0-9.!#$&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$" name="email" value="<?php if(isset($_SESSION['email'])){echo $_SESSION['email'];} ?>" required>
                    <input type="password" placeholder="Password" pattern="^[0-9A-Za-z]+$" name="pass" required>
                    <div class="buttons">
                        <button type="button" onclick="history.back()" class="btn negative">戻る</button>
                        <button type="submit" class="btn positive">ログイン</button>
                    </div>
                </div>
            </form>
        </div>
<?php
    session_destroy();
?>
    </body>
</html>