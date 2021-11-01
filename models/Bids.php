<?php 
  class Bids {//Do i add a check where, the latest bid,has to be rejected if its lower, or is that front end??
    // DB stuff
    private $conn;
    private $bids_table = 'Bids';
    private $items_table = 'Items';


    //bid properties
    public $bidID;
    public $createdAt;
    public $amount;
    public $userID;
    public $itemID;

    // Constructor with DB
      public function __construct($db) {
        $this->conn = $db;
    }

    //Get bids
    public function read_latest_bid() {
        //create query  //modify!!!!!!!!!!!!!!!!!!
        $query = 'SELECT
          b.bidID,
          b.createdAt,
          b.amount,
          b.userID,
          b.itemID
        FROM
            ' . $this->bids_table . ' b
        INNER JOIN ' . $this->items_table . ' i ON i.bidID = b.bidID 
        WHERE b.itemID = ?';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->itemID);

        // Execute query
        $stmt->execute();

        return $stmt;
        
    }

    // Get latest bid price
    public function get_highest_bid($ID) {
      //create query  //modify!!!!!!!!!!!!!!!!!!
      $query = 'SELECT
        highestPrice
      FROM
          ' . $this->items_table . '
      WHERE itemID = ?';

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $ID);

      // Execute query
      $stmt->execute();

      return $stmt;
      
  }

    // Create Bid
  public function create() {
    // Create query
    $query = 'INSERT INTO ' . $this->bids_table . '
        SET
          bidID = :bidID,
          createdAt = :createdAt,
          amount = :amount,
          userID = :userID,
          itemID = :itemID
    ';

      //Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Clean Data
      $this->bidID = htmlspecialchars(strip_tags($this->bidID));
      $this->createdAt = htmlspecialchars(strip_tags($this->createdAt));
      $this->amount = htmlspecialchars(strip_tags($this->amount));
      $this->userID = htmlspecialchars(strip_tags($this->userID));
      $this->itemID = htmlspecialchars(strip_tags($this->itemID));

      // Bind Data
      $stmt->bindParam(':bidID', $this->bidID);
      $stmt->bindParam(':createdAt', $this->createdAt);
      $stmt->bindParam(':amount', $this->amount);
      $stmt->bindParam(':userID', $this->userID);
      $stmt->bindParam(':itemID', $this->itemID);

      // Execute query
      if ($stmt->execute()) {
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
  }


  }
