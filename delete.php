<?php

    // idを取得
    $id = $_GET['id'];


    // DB接続
    try {
        $pdo = new PDO('mysql:dbname=php_kadai02;charset=utf8;host=localhost','root','');
    } catch (PDOException $e) {
        exit('DBConnectError:'.$e->getMessage());
    }


    // IDに紐づいているデータとコメントを全て削除SQL

    $stmt = $pdo->prepare("DELETE FROM gschannel WHERE id=:id");


    $stmt2 = $pdo->prepare("DELETE FROM reply WHERE post_id=:id");


    $stmt2->bindValue(':id', $id, PDO::PARAM_INT);
    $status2 = $stmt2->execute();

    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();

    // 削除後のリダイレクト
    if($status==false) {
        $error = $stmt->errorInfo();
        exit("ErrorQuery:".$error[2]);
    } else {        
    
        header("Location: index.php");
        exit;
    }

?>
