<?php
require_once(__DIR__ . '/../../controller/TodoController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $controller = new TodoController();
  $controller->new();
  exit;
}

$title = '';
$detail = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['title'])) {
    $title = $_GET['title'];
  }
  if (isset($_GET['detail'])) {
    $detail = $_GET['detail'];
  }
}

session_start();
$error_msgs = array();
if (isset($_SESSION['error_msgs'])) {
  $error_msgs = $_SESSION['error_msgs'];
  unset($_SESSION['error_msgs']);
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Todo作成</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="./../../public/css/main.css" rel="stylesheet" type="text/css">
</head>
<body>
 <header> 
    <a href="./../../index.php">
      <div class="header-zone">
        <div>
          <img src="./../../img/Goal.jpg" alt="目標の写真" class="goal-pic">
        </div>
        <div>
          <img src="./../../img/Todolist.jpg" alt="TODOの写真" class="todo-pic">
        </div>
      </div>
      <h1>目標とTODOの管理アプリ</h1>
    </a>
  </header>
  
  <main>
    <h1>TODO作成</h1>
  
    <?php if ($error_msgs): ?>
      <ul>
        <?php foreach ($error_msgs as $error_msg): ?>
          <li><?php echo $error_msg; ?></li>
        <?php endforeach; ?>
      </ul>
    <? endif; ?>
  
    <form action="./new.php" method="post"> 
      <div>
        <div class="new-title">タイトル</div>
        <input name="title" type="text" class="new-title-text" value="<?php echo $title; ?>">
      </div>
  
      <div>
        <div class="new-detail">詳細</div>
        <textarea name="detail" class="new-detail-textarea"><?php echo $detail; ?></textarea>
      </div>

      <button type="submit">作成</button>
    </form> 
  </main>
  
</body>
</html>