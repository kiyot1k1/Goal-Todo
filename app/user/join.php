<?php
require_once(__DIR__ . './../controller/TodoController.php');

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
      <h1>目標とTODOの管理アプリ</h1>
    </a>
  </header>

  <main>
    <h1>ユーザー登録</h1>

    <?php if ($error_msg): ?>
      <div class="error-msg">
        <ul>
          <li><?php echo $error_msg; ?></li>
        </ul>
      </div>
    <? endif; ?>

    <form action="join.php" method="post" class="join-form">
      <dl>
        <dt>名前</dt>
        <dd><input type="text" name="name" size="35" maxlength="255" required></dd>
        <dt>メールアドレス</dt>
        <dd><input type="text" name="mail" class="mail" size="35" maxlength="255" required></dd>
        <dt>パスワード</dt>
        <dd><input type="password" name="pass" class="pass" size="10" maxlength="20" required></dd>
      </dl>
      <input type="submit" value="登録">
    </form>
  </main>

</body>
</html>