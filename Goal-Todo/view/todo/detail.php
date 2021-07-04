<?php
require_once('./../../controller/TodoController.php');

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
      <div><?php echo $todo['display_status']; ?></div>
    </div>
  
    <div>
      <button class="detail-button">
        <a href="./edit.php?todo_id=<?php echo $todo['id']; ?>">編集</a>
      </button>
    </div>
  </div>
</body>
</html>