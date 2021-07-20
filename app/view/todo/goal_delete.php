<?php
require_once(__DIR__ . '/../../controller/TodoController.php');

$controller = new GoalController;
$result = $controller->goal_delete();

$response = array();
if ($result) {
  $response['result'] = 'success';
} else {
  $response['result'] = 'fail';
}

echo json_encode($response);