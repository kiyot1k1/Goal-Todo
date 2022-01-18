<?php
require_once(__DIR__ . '/../../controller/TodoController.php');

$controller = new TodoController;
$todo = $controller->detail();

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>詳細ページ</title>
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
        <h1>目標 ＆ TODOリスト</h1>
        <div>
          <img src="./../../img/Todolist.jpg" alt="TODOの写真" class="todo-pic">
        </div>
      </div>
    </a>  
  </header>

  <h1 class="detail-page">詳細ページ </h1>
  
  <div class="detail-block">
    <div>
      <div class="detail-title">タイトル</div>
      <div class="detail-title-text"><?php echo $todo['title']; ?></div>
    </div>
  
    <div>
      <div class="detail-detail">詳細</div>
      <div class="detail-detail-textarea"><?php echo $todo['detail']; ?></div>
    </div>
  
    <div>
      <div class="detail-status">ステータス</div>
      <div class="detail-status-text"><?php echo $todo['display_status']; ?></div>
    </div>
  
    <div>
      <button class="detail-button">
        <a href="./edit.php?todo_id=<?php echo $todo['id']; ?>">編集</a>
      </button>
    </div>
  </div>
</body>
</html>