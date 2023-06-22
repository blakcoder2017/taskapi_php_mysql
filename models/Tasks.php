<?php
  class Tasks {
    // DB Stuff
    private $conn;
    private $table = 'tasks';

    // Properties
    public $id;
    public $description;
    public $details;
    public $owner;
    public $created_at;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get categories
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        description,
        details,
        owner,
        created_at
      FROM
        ' . $this->table . '
      ORDER BY
        created_at DESC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Category
  public function read_single(){
    // Create query
    $query = 'SELECT
          id,
          description,
          details,
          owner,
          created_at
        FROM
          ' . $this->table . '
      WHERE id = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->id = $row['id'];
      $this->description = $row['description'];
      $this->details = $row['details'];
      $this->owner = $row['owner'];
      $this->created_at = $row['created_at'];
  }

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
      description = :description,
      details = :details,
      owner = :owner';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->description = htmlspecialchars(strip_tags($this->description));
  $this->details = htmlspecialchars(strip_tags($this->details));
  $this->owner = htmlspecialchars(strip_tags($this->owner));
  // Bind data
  $stmt-> bindParam(':description', $this->description);
  $stmt-> bindParam(':details', $this->details);
  $stmt-> bindParam(':owner', $this->owner);
  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: \n", $stmt->error);

  return false;
  }

  // Update Category
  public function update() {
    // Create Query
    $query = 'UPDATE ' .
      $this->table . '
    SET
      description = :description,
      details = :details,
      owner = :owner
      WHERE
      id = :id';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->description = htmlspecialchars(strip_tags($this->description));
  $this->details = htmlspecialchars(strip_tags($this->details));
  $this->owner = htmlspecialchars(strip_tags($this->owner));
  $this->id = htmlspecialchars(strip_tags($this->id));

  // Bind data
  $stmt-> bindParam(':description', $this->description);
  $stmt-> bindParam(':details', $this->details);
  $stmt-> bindParam(':owner', $this->owner);
  $stmt-> bindParam(':id', $this->id);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: \n", $stmt->error);

  return false;
  }

  // Delete Category
  public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind Data
    $stmt-> bindParam(':id', $this->id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: \n", $stmt->error);

    return false;
    }
  }