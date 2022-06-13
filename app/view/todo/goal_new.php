<?php
require_once(__DIR__ . '/../../controller/TodoController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $controller = new GoalController();
  $controller->goal_new();
  exit;
}

$goal = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['goal'])) {
    $goal = $_GET['goal'];
  }
}

session_start();
$error_msg = '';
if (isset($_SESSION['error_msg'])) {
  $error_msg = $_SESSION['error_msg'];
  unset($_SESSION['error_msg']);
}

if (isset($_SESSION['name'])) {
  var_dump($_SESSION['name']);
  exit;
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>目標設定</title>
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
    <h1>目標設定</h1>
  
    <?php if ($error_msg): ?>
      <ul>
        <li><?php echo $error_msg; ?></li>
      </ul>
    <? endif; ?>
  
    <form action="./goal_new.php" method="post"> 
      <div>
        <textarea name="goal" class="goal-new-textarea"><?php echo $goal; ?></textarea>
      </div>
      <button type="submit">設定</button>
    </form> 
  </main>
</body>
</html>