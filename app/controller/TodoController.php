<?php
require_once(__DIR__ . '/../model/Todo.php');
require_once(__DIR__ . '/../validation/TodoValidation.php');

// 目標設定用
class GoalController {
  public function goal_index() {
    $goal_list = Goal::goal_findAll();
    return $goal_list;
  }

  public function goal_new() {
    $data = array(
      "goal" => $_POST['goal']
    );

    $validation = new GoalValidation;
    $validation->goal_setData($data);
 
    if ($validation->goal_check() === false) {
      $error_msg = $validation->goal_getErrorMessage();

      session_start();
      $_SESSION['error_msg'] = $error_msg;

      $param = sprintf("?goal=%s", $_POST['goal']);
      header(sprintf("Location: ./goal_new.php%s", $param));
      return;
    }

    $valid_data = $validation->goal_getData();

    $goal = new Goal;
    $goal->setGoal($valid_data['goal']);
    $result = $goal->goal_save();

    if ($result === false) {
      $param = sprintf("?goal=%s", $_POST['goal']);
      header(sprintf("Location: ./goal_new.php%s", $param));
      return;
    }

    header("Location: https://goal-todo.herokuapp.com/index.php");
  }

  public function goal_edit() {
    $goal_id = '';
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      if (isset($_GET['goal_id'])) {
        $goal_id = $_GET['goal_id'];
      }
    }

    if (!$goal_id) {
      header("Location: ./../error/404.php");
      return;
    }

    if (Goal::goal_isExistById($goal_id) === false) {
      header("Location: ./../error/404.php");
      return;
    }

    $goal = Goal::goal_findById($goal_id);

    return $goal;
  }

  public function goal_update() {
    if (!$_POST['goal_id']) {
      session_start();
      $_SESSION['error_msg'] = "指定したIDに該当するデータがありません。";
      header("Location: https://goal-todo.herokuapp.com/index.php");
      return;
    }

    if (Goal::goal_isExistById($_POST['goal_id']) === false) {
      $params = sprintf("?goal_id=%s&goal=%s", $_POST['goal_id'], $_POST['goal']);
      header(sprintf("Location: ./goal_edit.php%s", $params));
      return;
    }

    $data = array(
      "goal_id" => $_POST['goal_id'],
      "goal" => $_POST['goal']
    );

    $validation = new GoalValidation;
    $validation->goal_setData($data);
    if ($validation->goal_check() === false) {
      $error_msg = $validation->goal_getErrorMessage();
 
      session_start();
      $_SESSION['error_msg'] = $error_msg;

      $params = sprintf("?goal_id=%s&goal=%s", $_POST['goal_id'], $_POST['goal']);
      header(sprintf("Location: ./goal_edit.php%s", $params));
      return;
    }

    $valid_data = $validation->goal_getData();

    $goal = new Goal;
    $goal->goal_setId($valid_data['goal_id']);
    $goal->setGoal($valid_data['goal']);
    $result = $goal->goal_update();

    if ($result === false) {
      $param = sprintf("?goal=%s", $valid_data['goal']);
      header(sprintf("Location: ./goal_edit.php%s", $param));
      return;
    }

    header("Location: https://goal-todo.herokuapp.com/index.php");
  }

  public function goal_delete() {
    $goal_id = '';
    if (isset($_POST['goal_id'])) {
      $goal_id = $_POST['goal_id'];
    }

    if (!$goal_id) {
      error_log(sprintf("[TodoController][delete]goal_id is not found. goal_id: %s", $goal_id));
      return false;
    }

    if (Goal::goal_isExistById($goal_id) === false) {
      error_log(sprintf("[TodoController][delete]record is not found. goal_id: %s", $goal_id));
      return false;
    }

    $goal = new Goal;
    $goal->goal_setId($goal_id);
    $result = $goal->goal_delete();

    return $result;
  }
}


// ここからTODO用
class TodoController {
  public function index() {
    $todo_list = Todo::findAll();
    return $todo_list;
  }

  public function detail() {
    $todo_id = $_GET['todo_id'];

    if (!$todo_id) {
      header("Location: ./../error/404.php");
      return;
    }

    if (Todo::isExistById($todo_id) === false) {
      header("Location: ./../error/404.php");
      return;
    }

    $todo = Todo::findById($todo_id);

    return $todo;
  }

  public function new() {
    $data = array(
      "title" => $_POST['title'],
      "detail" => $_POST['detail']
    );

    $validation = new TodoValidation;
    $validation->setData($data);
    if ($validation->check() === false) {
      $error_msgs = $validation->getErrorMessages();

      session_start();
      $_SESSION['error_msgs'] = $error_msgs;

      $params = sprintf("?title=%s&detail=%s", $_POST['title'], $_POST['detail']);
      header(sprintf("Location: ./new.php%s", $params));
      return;
    }

    $valid_data = $validation->getData();

    $todo = new Todo;
    $todo->setTitle($valid_data['title']);
    $todo->setDetail($valid_data['detail']);
    $result = $todo->save();

    if ($result === false) {
      $params = sprintf("?title=%s&detail=%s", $valid_data['title'], $valid_data['detail']);
      header(sprintf("Location: ./new.php%s", $params));
      return;
    }

    header("Location: https://goal-todo.herokuapp.com/index.php");
  }

  public function edit() {
    $todo_id = '';
    $params = array();
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      if (isset($_GET['todo_id'])) {
        $todo_id = $_GET['todo_id'];
      }
      if (isset($_GET['title'])) {
        $params['title'] = $_GET['title'];
      }
      if (isset($_GET['detail'])) {
        $params['detail'] = $_GET['detail'];
      }
    }

    if (!$todo_id) {
      header("Location: ./../error/404.php");
      return;
    }

    if (Todo::isExistById($todo_id) === false) {
      header("Location: ./../error/404.php");
      return;
    }

    $todo = Todo::findById($todo_id);

    $data = array(
      "todo" => $todo,
      "params" => $params
    );

    return $data;
  }

  public function update() {
    if (!$_POST['todo_id']) {
      session_start();
      $_SESSION['error_msgs'] = "指定したIDに該当するデータがありません。";
      header("Location: https://goal-todo.herokuapp.com/index.php");
      return;
    }

    if (Todo::isExistById($_POST['todo_id']) === false) {
      $params = sprintf("?todo_id=%s&title=%s&detail=%s", $_POST['todo_id'], $_POST['title'], $_POST['detail']);
      header(sprintf("Location: ./edit.php%s", $params));
      return;
    }

    $data = array(
      "todo_id" => $_POST['todo_id'],
      "title" => $_POST['title'],
      "detail" => $_POST['detail']
    );

    $validation = new TodoValidation;
    $validation->setData($data);
    if ($validation->check() === false) {
      $error_msgs = $validation->getErrorMessages();

      session_start();
      $_SESSION['error_msgs'] = $error_msgs;

      $params = sprintf("?todo_id=%s&title=%s&detail=%s", $_POST['todo_id'], $_POST['title'], $_POST['detail']);
      header(sprintf("Location: ./edit.php%s", $params));
      return;
    }

    $valid_data = $validation->getData();

    $todo = new Todo;
    $todo->setId($valid_data['todo_id']);
    $todo->setTitle($valid_data['title']);
    $todo->setDetail($valid_data['detail']);
    $result = $todo->update();

    if ($result === false) {
      $params = sprintf("?title=%s&detail=%s", $valid_data['title'], $valid_data['detail']);
      header(sprintf("Location: ./edit.php%s", $params));
      return;
    }

    header("Location: https://goal-todo.herokuapp.com/index.php");
  }

  public function delete() {
    $todo_id = '';
    if (isset($_POST['todo_id'])) {
      $todo_id = $_POST['todo_id'];
    }

    if (!$todo_id) {
      error_log(sprintf("[TodoController][delete]todo_id is not found. todo_id: %s", $todo_id));
      return false;
    }

    if (Todo::isExistById($todo_id) === false) {
      error_log(sprintf("[TodoController][delete]record is not found. todo_id: %s", $todo_id));
      return false;
    }

    $todo = new Todo;
    $todo->setId($todo_id);
    $result = $todo->delete();

    return $result;
  }

  public function updateStatus() {
    $todo_id = '';
    if (isset($_POST['todo_id'])) {
      $todo_id = $_POST['todo_id'];
    }

    if (!$todo_id) {
      error_log(sprintf("[TodoController][updateStatus]todo_id is not found. todo_id: %s", $todo_id));
      return false;
    }

    if (Todo::isExistById($todo_id) === false) {
      error_log(sprintf("[TodoController][updateStatus]record is not found. todo_id: %s", $todo_id));
      return false;
    }

    $todo = Todo::findById($todo_id);

    $status = $todo['status'];

    if ($status == Todo::STATUS_INCOMPLETE) {
      $status = Todo::STATUS_COMPLETED;
    } else if ($status == Todo::STATUS_COMPLETED) {
      $status = Todo::STATUS_INCOMPLETE;
    }

    $todo = new Todo;
    $todo->setId($todo_id);
    $todo->setStatus($status);
    $result = $todo->updateStatus();

    return $result;
  }
}


// ここからユーザー管理用
class UserController {
  public function join() {
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    $user = new User;
    $user->setName($name);
    $user->setMail($mail);
    $user->setPass($pass);
    $result = $user->join();

    if ($result === false) { 
      session_start();
      $_SESSION['error_msg'] = "同じメールアドレスが登録されています。";
      return;
    } else {
      header("Location: ./../user/thanks.php");
    }
  }

  public function login() {
    $mail = $_POST['mail'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    if ($_POST['mail'] != '' && $_POST['password'] != '') {
      $user = new User;
      $user->setMail($mail);
      $user->setPass($pass);
      $result = $user->login();
    } else {
      session_start();
      $_SESSION['error_msg'] = "メールアドレスとパスワードをご記入ください。";
      return;
    }

    if ($result === false) { 
      session_start();
      $_SESSION['error_msg'] = "ログインに失敗しました。再度やり直してください。";
      return;
    } else {
      header("Location: https://goal-todo.herokuapp.com/index.php");
    }
  }
}