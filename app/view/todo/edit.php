<?php
require_once(__DIR__ . '/../../controller/TodoController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $controller = new TodoController();
  $controller->update();
  exit;
}

$controller = new TodoController();
$data = $controller->edit();
$todo = $data['todo'];
$params = $data['params'];

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
  <title>編集</title>
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
    <h1>編集ページ</h1>
  
    <?php if ($error_msgs): ?>
      <ul>
        <?php foreach ($error_msgs as $error_msg): ?>
          <li><?php echo $error_msg; ?></li>
        <?php endforeach; ?>
      </ul>
    <? endif; ?>
  
    <form action="./edit.php" method="post"> 
      <div>
        <div class="edit-title">タイトル</div>
        <input name="title" type="text" class="edit-title-text" 
        value="<?php if (isset($params['title'])): ?><?php echo $params['title']; ?><?php else: ?><?php echo $todo['title']; ?><?php endif; ?>">
      </div>
  
      <div>
        <div class="edit-detail">詳細</div>
        <textarea name="detail" class="edit-detail-textarea"><?php if (isset($params['detail'])): ?><?php echo $params['detail']; ?><?php else: ?><?php echo $todo['detail']; ?><?php endif; ?></textarea>
      </div>
  
      <input type="hidden" name="todo_id" value="<?php echo $todo['id']; ?>">
  
      <button type="submit">更新</button>
    </form> 
  </main>
  
</body>
</html>