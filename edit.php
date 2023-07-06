<?php

    // IDを取得
    $id = $_GET["id"];

    // DB接続
    try {
        $pdo = new PDO('mysql:dbname=php_kadai02;charset=utf8;host=localhost','root','');
    } catch (PDOException $e) {
        exit('DBConnectError:'.$e->getMessage());
    }

    // データ取得SQL作成
    $stmt = $pdo->prepare("SELECT * FROM gschannel WHERE id=:id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status == false) {
        sql_error($stmt);
    } else {
        $row = $stmt->fetch(); //1レコードだけ取得する方法
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>G'sチャンネル</title>
    <style>
        img{
            width: 200px;
        }
    </style>

</head>
<body>
    <h1>G'sチャンネル</h1>
    <a href="index.php">戻る</a>

    <form action="update.php" method="post">
        <p>名前：<input type="text" name="name" value="<?=$row["name"]?>"></p>
        <p>タイトル：<input type="text" name="title" value="<?=$row["title"]?>"></p>
        <p>内容：<input type="text" name="content" value="<?=$row["content"]?>"></p>    
        <p><?=$row["image"]?></p>

        <input type="hidden" name="id" value="<?=$row["id"]?>">
    
        <input type="submit" value="送信">
    </form>


    
    <form action="delete.php" method="GET">
        <input type="hidden" name="id" value="<?=$id?>">
        <input type="submit" value="削除">
    </form>


</body>
</html>