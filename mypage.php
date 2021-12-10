<?php
    session_start();
    $error_msg = array();

    //データベースの情報
    $hostname = '***.***.***.***';
    $username = '****';
    $password = '******';

    $dbname = 'todo';
    $tablename = 'todolist';
    $tablename_user = 'user';

    $link = mysqli_connect($hostname, $username, $password);
    if(!$link){ exit("Connect error!"); }

    $result = mysqli_query($link, "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8");
    if(!$result){ exit("Create DB failed!"); }

    $result = mysqli_query($link, "USE $dbname");
    if(!$result){ exit("Use failed!"); }

    $result = mysqli_query($link, "CREATE TABLE IF NOT EXISTS $tablename (id INT NOT NULL AUTO_INCREMENT, email BLOB, todo VARCHAR(255) BINARY, PRIMARY KEY(id))CHARACTER SET utf8");
    if(!$result){ exit("Create table failed!"); }

    if((!empty($_POST['name'])) && (!empty($_POST['email']) && (!empty($_POST['pass'])))){
        $name = mysqli_real_escape_string($link, $_POST['name']);
        $email = mysqli_real_escape_string($link, $_POST['email']);
        $pass = mysqli_real_escape_string($link, $_POST['pass']);

        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;

        $result = mysqli_query($link, "INSERT INTO user(name, email, password) VALUES('$name', '$email', '$pass')");
        if(!$result){ exit("Insert error!"); }
    }

    $email = $_SESSION['email'];

    //ボタンが押されたら
    if(!empty($_POST)){
        //Todoの追加
        if((!empty($_POST['todo'])) && (!empty($_SESSION['email']))){
            $todo = mysqli_real_escape_string($link, $_POST['todo']);

            $result = mysqli_query($link, "INSERT INTO $tablename(email, todo) VALUES('$email', '$todo')");
            if(!$result){ exit("Insert error!"); }
        } elseif(!empty($_POST['del'])) {
            $id = $_POST['del'];
            $result = mysqli_query($link, "DELETE FROM $tablename WHERE id = $id");
            if(!$result){ exit("Delete error!"); }
        } else {
            $error_msg['add'] = 'Todoを入力してください。';
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
            <div class="nav">
                <h1>Todo</h1>
                <form method="post" action="index.php">
                    <button type="submit" class="btn negative">ログアウト</button>
                </form>
            </div>
            <div class="box-todo">
                <div class="flex">
                    <div class="error_msg"><?php if(!empty($error_msg['add'])){ echo $error_msg['add'];} ?></div>
                    <form method="post" action="">
                        <input type="text" maxlength="250" name="todo">
                        <button type="submit" class="btn-short positive">追加</button>
                    </form>
<?php 
                echo "<h3>{$_SESSION['name']}さんのTodo</h3>";

                $result = mysqli_query($link, "SELECT * FROM $tablename WHERE email = '$email'");
                if(!$result){ exit("Get record failed!"); }

                echo '<ul class="list">';
                while($row = mysqli_fetch_row($result)){
                    foreach($row as $key => $values){
                        if($key === 2){
                            echo '<div class="todo">';
                            echo "<li>";
                            $columns = htmlspecialchars($values);
                            echo $columns;
                            echo "</li>";
                        } 
                    }
                    echo '<form method="post" action="" class="del">';
                    echo '<input type="hidden" name="del" value="'.$row[0].'">';
                    echo '<button type="submit" class="btn-short negative right">削除</button>';
                    echo '</div>';
                    echo '</form>';
                }
                mysqli_free_result($result);
                echo '</ul>';

                mysqli_close($link);
?>
                    </div>
                </div>
            </div>
        </div>   
    </body>
</html>