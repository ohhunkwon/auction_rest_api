<?php 
  class Bids {//Do i add a check where, the latest bid,has to be rejected if its lower, or is that front end??
    // DB stuff
    private $conn;
    private $bids_table = 'Bids';
    private $items_table = 'Items';
    private $users_table = 'Users';


    //bid properties
    public $bidID;
    public $createdAt;
    public $amount;
    public $userID;
    public $itemID;

    public $highestPrice;

    // Constructor with DB
      public function __construct($db) {
        $this->conn = $db;
    }

    // Get user's role (Seller/Buyer)
    public function get_user_role($USER_ID) {
      $query = 'SELECT
        u.role
      FROM
          ' . $this->users_table . ' u
      WHERE userID = ?';

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $USER_ID);

      // Execute query
      $stmt->execute();

      return $stmt;
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

      // Get latest bid's userID
      public function get_latest_bid_userID($item_id) {
        //create query
        $query = 'SELECT
          b.userID
        FROM
            ' . $this->bids_table . '
        INNER JOIN $
        WHERE itemID = ?';
  
        // Prepare Statement
        $stmt = $this->conn->prepare($query);
  
        // Bind ID
        $stmt->bindParam(1, $item_id);
  
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

    // Update Highest Price in Items Table - Input: ID is itemID, PRICE is amount of bid just created, BIDID is bidID
    public function update_highest_price($ID, $BIDID, $PRICE) {
      // Create query
      $query = 'UPDATE ' . $this->items_table . '
          SET
              highestPrice = :highestPrice,
              bidID = :bidID
          WHERE
              itemID = :itemID';

      //Prepare Statement
      $stmt = $this->conn->prepare($query);
  
      // Clean Data
      $this->highestPrice = htmlspecialchars(strip_tags($this->highestPrice));
      $this->bidID = htmlspecialchars(strip_tags($this->bidID));
      $this->itemID = htmlspecialchars(strip_tags($this->itemID));

      // Bind Data
      $stmt->bindParam(':highestPrice', $PRICE);
      $stmt->bindParam(':bidID', $BIDID);
      $stmt->bindParam(':itemID', $ID);

      // Execute query
      if ($stmt->execute()) {
          return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
  }

  }
