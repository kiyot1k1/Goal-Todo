<?php
require_once(__DIR__ . '/../config/db.php');

// 目標設定用
class Goal {
  public $goal_id;
  public $goal;
  public $user_id;

  public function goal_setId($goal_id) {
    $this->goal_id = $goal_id;
  }

  public function goal_getId() {
    return $this->goal_id;
  }

  public function setGoal($goal) {
    $this->goal = $goal;
  }

  public function getGoal() {
    return $this->goal;
  }

  public function setUser($user_id) {
    $this->user_id = $user_id;
  }

  public static function goal_findAll() {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
    } catch (PDOException $e) {
      echo 'DB接続エラー： ' . $e->getMessage();
    };

    $stmh = $pdo->query("SELECT g.id, goal, g.completed_at, g.created_at, g.updated_at, g.deleted_at, user_id FROM goals g, users u WHERE g.user_id = u.id");
    // $stmh = $pdo->query("SELECT * FROM goals");
    $goal_list = $stmh->fetchAll(PDO::FETCH_ASSOC);

    return $goal_list;
  }

  public function goal_save() {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
      $query = sprintf("INSERT INTO goals (user_id, goal, created_at, updated_at) VALUES ('%s', '%s', now(), now())",
                        $this->user_id,
                        $this->goal
                      );
      // $query = sprintf("INSERT INTO goals (goal, created_at, updated_at) VALUES ('%s', now(), now()) ",
      //                   $this->goal
      //                   );
      $result = $pdo->query($query);
    } catch (Exception $e) {
      error_log("目標設定の作成に失敗しました。");
      error_log($e->getMessage());
      error_log($e->getTraceAsString());

      return false;
    };

    return $result;
  }

  public static function goal_isExistById($goal_id) {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
    } catch (PDOException $e) {
      echo 'DB接続エラー： ' . $e->getMessage();
    };

    $stmh = $pdo->query(sprintf("SELECT * FROM goals WHERE id = '%s'", $goal_id));
    $goal = $stmh->fetch(PDO::FETCH_ASSOC);

    if ($goal) {
      return true;
    } else {
      return false;
    }
  }

  public static function goal_findById($goal_id) {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
    } catch (PDOException $e) {
      echo 'DB接続エラー： ' . $e->getMessage();
    };

    $stmh = $pdo->query(sprintf("SELECT * FROM goals WHERE id = '%s'", $goal_id));
    $goal = $stmh->fetch(PDO::FETCH_ASSOC);

    return $goal;
  }

  public function goal_update() {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
      $query = sprintf("UPDATE goals  SET goal = '%s', updated_at = '%s' WHERE id = '%s'",
                        $this->goal,
                        date("Y-m-d H:i:s"),
                        $this->goal_id
                        );

      $result = $pdo->query($query);
    } catch (Exception $e) {
      error_log("更新に失敗しました。");
      error_log($e->getMessage());
      error_log($e->getTraceAsString());
      
      return false;
    };

    return $result;
  }

  public function goal_delete() {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
      $query = sprintf("DELETE FROM goals WHERE id = '%s'", $this->goal_id);

      $result = $pdo->query($query);
    } catch (Exception $e) {
      error_log("削除に失敗しました。");
      error_log($e->getMessage());
      error_log($e->getTraceAsString());
      
      return false;
    };

    return $result;
  }
}


// ここからTODO用
class Todo {
  const STATUS_INCOMPLETE = 0;
  const STATUS_COMPLETED = 1;

  const STATUS_INCOMPLETE_TXT = "未完了";
  const STATUS_COMPLETED_TXT ="完了";

  public $id;
  public $title;
  public $detail;
  public $status;

  public function setId($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }
  
  public function setTitle($title) {
    $this->title = $title;
  }

  public function getTitle() {
    return $this->title;
  }
  
  public function setDetail($detail) {
    $this->detail = $detail;
  }

  public function getDetail() {
    return $this->detail;
  }
  
  public function setStatus($status) {
    $this->status = $status;
  }

  public function getStatus() {
    return $this->status;
  }

  public static function findByQuery($query) { 
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
    } catch (PDOException $e) {
      echo 'DB接続エラー： ' . $e->getMessage();
    };
    
    $stmh = $pdo->query($query);
    $todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);

    if ($todo_list && count($todo_list) > 0) {
      foreach ($todo_list as $index => $todo) {
        $todo_list[$index]['display_status'] = self::getDisplayStatus($todo['status']);
      }
    }

    return $todo_list;
  }
    
  public static function findAll() {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
    } catch (PDOException $e) {
      echo 'DB接続エラー： ' . $e->getMessage();
    };
    
    $stmh = $pdo->query("SELECT t.id, title, detail, status, t.completed_at, t.created_at, t.updated_at, t.deleted_at, user_id FROM todos t, users u WHERE t.user_id = u.id");
    // $stmh = $pdo->query("SELECT * FROM todos");
    $todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);

    if ($todo_list && count($todo_list) > 0) {
      foreach ($todo_list as $index => $todo) {
        $todo_list[$index]['display_status'] = self::getDisplayStatus($todo['status']);
      }
    }

    return $todo_list;
  }

  public static function findById($todo_id) {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
    } catch (PDOException $e) {
      echo 'DB接続エラー： ' . $e->getMessage();
    };
    
    $stmh = $pdo->query(sprintf("SELECT * FROM todos WHERE id = '%s'", $todo_id));
    $todo = $stmh->fetch(PDO::FETCH_ASSOC);

    if ($todo) {
      $todo['display_status'] = self::getDisplayStatus($todo['status']);
    }

    return $todo;
  }

  public static function getDisplayStatus($status) {
    if ($status == self::STATUS_INCOMPLETE) {
      return self::STATUS_INCOMPLETE_TXT;
    } else if ($status == self::STATUS_COMPLETED) {
      return self::STATUS_COMPLETED_TXT;
    }

   return "";    
  }
  
  public function save() {
    try {
      session_start();
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
      $query = sprintf("INSERT INTO todos (user_id, title, detail, status, created_at, updated_at) VALUES ('%s', '%s', '%s', 0 ,now(), now()) ",
                        $_SESSION['id'],
                        $this->title,
                        $this->detail
                        );
      // $query =  sprintf("INSERT INTO todos (title, detail, status, created_at, updated_at) VALUES ('%s', '%s', 0 ,now(), now()) ",
      //                   $this->title,
      //                   $this->detail
      //                   );
                      
      $result = $pdo->query($query);
    } catch (Exception $e) {
      error_log("新規作成に失敗しました。");
      error_log($e->getMessage());
      error_log($e->getTraceAsString());
      
      return false;
    };

    return $result;
  }

  public function update() {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
      $query = sprintf("UPDATE todos  SET title = '%s', detail = '%s', updated_at = '%s' WHERE id = '%s'",
                        $this->title,
                        $this->detail,
                        date("Y-m-d H:i:s"),
                        $this->id
                        );

      $result = $pdo->query($query);
    } catch (Exception $e) {
      error_log("更新に失敗しました。");
      error_log($e->getMessage());
      error_log($e->getTraceAsString());
      
      return false;
    };

    return $result;
  }

  public static function isExistById($todo_id) {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
    } catch (PDOException $e) {
      echo 'DB接続エラー： ' . $e->getMessage();
    };
    
    $stmh = $pdo->query(sprintf("SELECT * FROM todos WHERE id = '%s'", $todo_id));
    $todo = $stmh->fetch(PDO::FETCH_ASSOC);

    if ($todo) {
     return true;
    } else {
      return false;
    }
  }

  public function delete() {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
      $query = sprintf("DELETE FROM todos WHERE id = '%s'", $this->id);
      $result = $pdo->query($query);
    } catch (Exception $e) {
      error_log("削除に失敗しました。");
      error_log($e->getMessage());
      error_log($e->getTraceAsString());
      
      return false;
    };

    return $result;
  }

  public function updateStatus() {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
      $query = sprintf("UPDATE todos  SET status = '%s', updated_at = '%s' WHERE id = '%s'",
                        $this->status,
                        date("Y-m-d H:i:s"),
                        $this->id
                        );
      $result = $pdo->query($query);
    } catch (Exception $e) {
      error_log("ステータス更新に失敗しました。");
      error_log($e->getMessage());
      error_log($e->getTraceAsString());

      return false;
    };

    return $result;
  }
}

// ここからユーザー管理用
class User {

  public static $name;
  public static $mail;
  public static $pass;

  public function setName($name) {
    self::$name = $name;
  }
  
  public function setMail($mail) {
    self::$mail = $mail;
  }

  public function setPass($pass) {
    self::$pass = $pass;
  }

  public static function join() {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
    } catch (PDOException $e) {
      echo 'DB接続エラー： ' . $e->getMessage();
    };

    $query =  "SELECT * FROM users WHERE mail = ?";
    $stmh = $pdo->prepare($query);
    $stmh->bindValue(1, self::$mail);
    $stmh->execute();
    $record = $stmh->fetchAll(PDO::FETCH_ASSOC);
    
    if ($record) {
      return false;
    } else {
      $query =  sprintf("INSERT INTO users (name, mail, password, created_at) VALUES ('%s', '%s', '%s', '%s') ",
                        self::$name,
                        self::$mail,
                        self::$pass,
                        date("Y-m-d H:i:s")
                        );
                      
      $stmh = $pdo->query($query);

      return true;
    }
  }

  public static function login() {
    try {
      $pdo = new PDO(DSN, USERNAME, PASSWORD);
    } catch (PDOException $e) {
      echo 'DB接続エラー： ' . $e->getMessage();
    };

    $query = "SELECT * FROM users WHERE mail = ? ";
    $stmh = $pdo->prepare($query);
    $stmh->bindValue(1, self::$mail);
    $stmh->execute(); 
    $member = $stmh->fetch(PDO::FETCH_ASSOC);
    
    if (password_verify($_POST['pass'], $member['password'])) {
      return $member;
    } else {
      return false;
    }
  }
}