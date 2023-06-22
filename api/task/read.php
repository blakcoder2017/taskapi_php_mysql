<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';

  include_once '../../models/Tasks.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate category object
  $tasks = new Tasks($db);

  // Category read query
  $result = $tasks->read();
  
  // Get row count
  $num = $result->rowCount();

  // Check if any categories
  if($num > 0) {
        // Cat array
        $tasks_arr = array();
        $tasks_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $task_item = array(
            'id' => $id,
            'description' => $description,
            'details' => $details,
            'owner' => $owner,
            'created_at' => $created_at
          );

          // Push to "data"
          array_push($tasks_arr['data'], $task_item);
        }

        // Turn to JSON & output
        echo json_encode($tasks_arr);

  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No Tasks Found')
        );
  }