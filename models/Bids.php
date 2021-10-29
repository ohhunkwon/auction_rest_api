<?php 
  class Bids {//Do i add a check where, the latest bid,has to be rejected if its lower, or is that front end??
    // DB stuff
    private $conn;
    private $bids_table = 'bids';
    private $items_table = 'items';


    //bid properties
    public $bid_ID;
    public $created_at;
    public $amount;
    public $user_Id;
    public $item_id;

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
        INNER JOIN ' . $items_table . ' i ON i.bidID = b.bidID 
        WHERE b.itemID = ? ';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->itemID);

        // Execute query
        $stmt->execute();

        return $stmt;
        
    }

  // Delete bids
  public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
          return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
  }


  }
