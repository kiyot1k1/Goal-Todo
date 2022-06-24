<?php
require_once(__DIR__ . '/controller/TodoController.php');

$goal_controller = new GoalController;
$goal_list = $goal_controller->goal_index();

// var_dump($goal_list);
// exit;

$todo_controller = new TodoController;
$todo_list = $todo_controller->index();

$error_msg = '';
session_start();
if (isset($_SESSION['error_msgs'])) {
  $error_msg = $_SESSION['error_msgs'];
  unset($_SESSION['error_msgs']);
}

if (isset($_SESSION['name'])) {
  $username = $_SESSION['name'];
}

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();
  $msg = htmlspecialchars($username, ENT_QUOTES) . 'さん<br>TODOを管理して、目標を達成しましょう！';
  $logout = '<a href="./user/logout.php" class="top-logout">ログアウト</a>';
} else {
  header("Location: ./user/login.php");
}

if (isset($_POST['todo_id'])) {
  $todo_id = $_POST['todo_id'];
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>目標・Todo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="./public/css/main.css" rel="stylesheet" type="text/css">
</head>
<body>
  <header>
    <a href="./index.php">
      <div class="header-zone">
        <div>
          <img src="./img/Goal.jpg" alt="目標の写真" class="goal-pic">
        </div>
        <div>
          <img src="./img/Todolist.jpg" alt="TODOの写真" class="todo-pic">
        </div>
      </div>
      <h1>目標とTODOの管理アプリ</h1>
    </a>
  </header>

  <main>

    <div class="top-msg">
      <?php echo $msg; ?>
    </div>    

    <div class="top-logout-area">
      <?php echo $logout; ?>
    </div>
      
    <!-- 目標設定 -->
    <h2><a href="./view/todo/goal_new.php">目標設定</a></h2>

    <?php if ($error_msg): ?>
      <div><?php echo $error_msg; ?></div>
    <? endif; ?>
    
    <?php if ($goal_list): ?>
      <ul class="list-group">
        <?php foreach($goal_list as $goal): ?>
          <li class="list-group-item"> 
            <a href="./view/todo/goal_edit.php?goal_id=<?php echo $goal['id'] ?>" class="goal-list"><?php echo $goal['goal']; ?></a>
            <div class="goal-delete-btn" data-id="<?php echo $goal['id']; ?>">
              <button>削除</button>
            </div>
          </li>
        <?php endforeach; ?> 
      </ul>
    <?php else: ?>
      <p>No date.</p>
    <?php endif; ?> 


    <!-- ここからTODO -->
    <h2><a href="./view/todo/new.php">TODO作成</a></h2>

    <?php if ($error_msg): ?>
      <div><?php echo $error_msg; ?></div>
    <? endif; ?>

    <?php if ($todo_list): ?>
      <ul class="list-group">
        <?php foreach($todo_list as $todo): ?>
          <li class="list-group-item"> 
            <input type="checkbox" class="todo-checkbox" data-id="<?php echo $todo['id']; ?>"<?php if ($todo['status']): ?>checked<?php endif; ?>>
            <a href="./view/todo/detail.php?todo_id=<?php echo $todo['id'] ?>" class="todo-list"><?php echo $todo['title']; ?></a>
            <div class="delete-btn" data-id="<?php echo $todo['id']; ?>">
              <button>削除</button>
            </div>
          </li>
        <?php endforeach; ?> 
      </ul>
    <?php else: ?>
      <p>No date.</p>
    <?php endif; ?> 

  </main>


  <script src="./public/js/jquery-3.6.0.min.js"></script>
  <script>
  //目標設定
    $(".goal-delete-btn").click(function() {
      if (confirm("削除してもよろしいですか？")) {
        let goal_id = $(this).data('id');
        $(".goal-delete-btn").prop("disabled", true);
        let data = {};
        data.goal_id = goal_id;
    
        $.ajax({
          url: './view/todo/goal_delete.php',
          type: 'POST',
          data: data
        }).then(
          function(data) {
            let json = JSON.parse(data);
            console.log("success", json);
            if (json.result == 'success') {
              window.location.href = "./index.php";
            } else {
              console.log("failed to delete.");
              alert("failed to delete.");
              $(".goal-delete-btn").prop("disabled", false);
            }
        },
          function() {
            console.log("failed to ajax.");
            alert("failed to ajax.");
            $(".delete-btn").prop("disabled", false);
          }
        );
      }
    });


  //ここからTODO
    $(".delete-btn").click(function() {
      if (confirm("削除してもよろしいですか？")) {
        let todo_id = $(this).data('id');
        $(".delete-btn").prop("disabled", true);
        let data = {};
        data.todo_id = todo_id;
    
        $.ajax({
          url: './view/todo/delete.php',
          type: 'POST',
          data: data
        }).then(
          function(data) {
            let json = JSON.parse(data);
            console.log("success", json);
            if (json.result == 'success') {
              window.location.href = "./index.php";
            } else {
              console.log("failed to delete.");
              alert("failed to delete.");
              $(".delete-btn").prop("disabled", false);
            }
        },
          function() {
            console.log("failed to ajax.");
            alert("failed to ajax.");
            $(".delete-btn").prop("disabled", false);
          }
        );
      }
    });

    $(".todo-checkbox").change(function() {
      let todo_id = $(this).data('id');
      let data = {};
      data.todo_id = todo_id;

      $.ajax({
        url: './view/todo/update_status.php',
        type: 'POST',
        data: data
      }).then(
        function(data) {
          let json = JSON.parse(data);
          console.log("success", json);
          if (json.result == 'success') {
            console.log("success.");
            
            if ($(this).is(':checked')) {
              $(this).parent().find('.todo-list').css({'text-decoration': 'line-through', 'color': 'gray'});
            } else {
              $(this).parent().find('.todo-list').css({'color': 'black', 'text-decoration': 'underline', 'cursor': 'pointer' });
            }            
            
          } else {
            console.log("failed to update status.");
            alert("failed to update status.");
          }
      }.bind(this),
        function() {
          console.log("failed to ajax.");
          alert("failed to ajax.");
        }
      );      
    })
  </script>
</body>
</html>