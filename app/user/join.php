<?php
require_once(__DIR__ . '/controller/TodoController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $controller = new UserController();
  $controller->join();
  exit;
}

$error_msg = '';
session_start();
if (isset($_SESSION['error_msg'])) {
  $error_msg = $_SESSION['error_msg'];
  unset($_SESSION['error_msg']);
}

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
      <h1>目標とTODOの管理ツール</h1>
    </a>
  </header>

  <h1>ユーザー登録</h1>
  <form action="join.php" method="post">
    <div>
      <label>名前：<label>
      <input type="text" name="name" required>
    </div>
    <div>
      <label>メールアドレス：<label>
      <input type="text" name="mail" required>
    </div>
    <div>
      <label>パスワード：<label>
      <input type="password" name="pass" required>
    </div>
    <input type="submit" value="ユーザー登録">
  </form>

</body>
</html>