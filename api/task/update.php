<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/database.php';
  include_once '../../models/Tasks.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $task = new Tasks($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to UPDATE
  $task->id = $data->id;
  $task->description = $data->description;
  $task->details= $data->details;
  $task->owner = $data->owner;

  // Update post
  if($category->update()) {
    echo json_encode(
      array('message' => 'Task Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Task not updated')
    );
  }