<?php

session_start();
$_SESSION = array();
session_destroy();

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>目標設定</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="./../public/css/main.css" rel="stylesheet" type="text/css">
</head>
<body>
  <header>
    <a href="./../index.php">
      <div class="header-zone">
        <div>
          <img src="./../img/Goal.jpg" alt="目標の写真" class="goal-pic">
        </div>
        <div>
          <img src="./../img/Todolist.jpg" alt="TODOの写真" class="todo-pic">
        </div>
      </div>
      <h1>目標とTODOの管理アプリ</h1>
    </a>
  </header>

  <main>
    <h1>ログアウト</h1>

    <p>ログアウトしました。</p>
    <a href="./../index.php">トップページへ</a>

  </main>

</body>
</html>