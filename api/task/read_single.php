<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/Tasks.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog category object
  $task = new Tasks($db);

  // Get ID
  $task->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $task->read_single();

  // Create array
  $task_arr = array(
    'id' => $task->id,
    'description' => $task->description,
    'details' => $task->details,
    'owner' => $task->owner,
    'created_at' => $task->created_at,
  );

  // Make JSON
  print_r(json_encode($category_arr));