<?php
// 1.  DB接続します
try {
    //ID:'root', Password: xamppは 空白 ''
    $pdo = new PDO('mysql:dbname=php_kadai02;charset=utf8;host=localhost','root','');
    } catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
    }

// 2. データ登録SQL作成
// 1. SQL文を用意
$stmt = $pdo->prepare("SELECT * FROM gschannel ORDER BY id DESC");
$status = $stmt->execute();

//  2.表示
$view="";
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
$error = $stmt->errorInfo();
exit("ErrorQuery:".$error[2]);

}else{
    //Selectデータの数だけカード形式で自動でループしてくれる
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $view .= '<div class="card" style="width: 18rem;">';
        $view .= '<div class="card-body">';
        $view .= '<h5 class="card-title">'.$result["name"].'</h5>';
        $view .= '<h6 class="card-subtitle mb-2 text-muted">'.$result["class"].'</h6>';
        $view .= '<p class="card-text">'.$result["content"].'</p>';
        $view .= '<a href="sled.php?id='.$result["id"].'" class="card-link">詳細</a>';
        $view .= '<a href="edit.php?id='.$result["id"].'" class="card-link">編集</a>';
        $view .= '</div>';
        $view .= '</div>';
    }


}

// もしもデータが存在しない場合は、以下のように表示する
if($view==""){
    $view = "<h1>投稿がありません。あなたが最初の投稿者になりましょう！</h1>"
            ."<a href='form.php'>"
            ."投稿画面へ"
            ."</a>"
    ;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>投稿一覧</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>
    div{
        padding: 10px;
        font-size:16px;    
    }
    .jumbotron{
        padding: 10px;
        font-size:16px;    
    }
    .card{
        padding: 10px;
        font-size:16px;    
    }
    .card-body{
        padding: 10px;
        font-size:16px;    
    }
    .flex{
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    .border{
        border: solid 1px black;
    }
    .container-fluid{
        background-color: #e3f2fd;
    }
    
    .form{
        border: solid 1px black;
    }

    
</style>
</head>

<header>

    <div class="container jumbotron border">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
            <h1>投稿一覧</h1>

                <a href="form.php">投稿画面へ</a>
            </div>
        </div>
    </nav>
    </div>
</header>

<body id="main">
    <div class="container jumbotron form">

        <form action="post_content.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="name">名前：</label>
                    <input type="text" name="name" id="name">
                </div>
                <div>
                    <label for="class">クラス</label>
                    <select name="class" id="class">
                        <option value="東京DEV25期">東京DEV25期</option>
                        <option value="札幌DEV6期">札幌DEV6期</option>
                    </select>
                </div>
                <div>
                    <label for="title">投稿タイトル</label>
                    <input type="text" name="title" id="title" >
                </div>
                <div>
                    <label for="content">投稿内容</label>
                    <textarea name="content" id="content" cols="30" rows="10"></textarea>
                </div>
                <div>
                <label>画像を選択</label>
                    <input type="file" name="image" required>
                </div>
                <div>
                    <input type="submit" value="送信">
                </div>

            </form>
    </div>
<div >
    <div class="container jumbotron flex"><?=$view?></div>
</div>
<!-- Main[End] -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>