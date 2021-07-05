<?php

// 目標設定用
class GoalValidation {
  public $data= array();
  public $error_msg = '';
  
  public function goal_setData($data) {
    $this->data = $data;
  }
  
  public function goal_getData() {
    return $this->data;
  }
  
  public function goal_getErrorMessage() {
    return $this->error_msg;
  }
  
  public function goal_check() {
    if (isset($this->data['goal']) && empty($this->data['goal'])) {
      $this->error_msg = "目標を記入して下さい。";
  
      return false;
    }
    
    return true;
  }
}
  
// ここからTODO用
class TodoValidation {
  public $data = array();
  public $error_msgs = array();
  
  public function setData($data) {
    $this->data = $data;
  }
  
  public function getData() {
    return $this->data;
  }
  
  public function getErrorMessages() {
    return $this->error_msgs;
  }

  public function check() {
    if (isset($this->data['title']) && empty($this->data['title'])) {
      $this->error_msgs[] = "タイトルを記入して下さい。";
    }
    if (isset($this->data['detail']) && empty($this->data['detail'])) {
      $this->error_msgs[] =  "詳細を記入して下さい。";
    }

    if (count($this->error_msgs) > 0) {
     return false;
    } 

    return true;
  }
}