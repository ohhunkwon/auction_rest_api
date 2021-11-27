<?php
    class WatchList {
        // DB stuff
        private $conn;
        private $watch_table = 'Watchlist';
        private $user_table = 'Users';
        private $item_table = 'Items';

        // Item Properties
        public $itemID;
        public $title;
        public $userID;
        public $description;
        public $category;
        public $startDateTime;
        public $endDateTime;
        public $startingPrice;
        public $reservePrice;
        public $latestBidID;
        public $image;
        public $firstName;
        public $input;
        public $highestPrice;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Watchlist of specific User
        public function read() {
            $query = 'SELECT 
                Items.itemID,
                Items.title,
                Items.userID,
                Items.startDateTime,
                Items.reservePrice,
                Items.description,
                Items.category,
                Items.endDateTime,
                Items.startingPrice,
                Items.bidID,
                Items.image
            FROM ' . $this->item_table . ' 
            INNER JOIN ' . $this->watch_table . ' ON  Items.itemID = Watchlist.itemID and Watchlist.userID = ?';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Category
            $stmt->bindParam(1, $this->userID);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Add Item to Watchlist
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->watch_table . '
                SET
                    itemID = :itemID,
                    userID = :userID
            ';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);
        
            // Clean Data
            $this->itemID = htmlspecialchars(strip_tags($this->itemID));
            $this->userID = htmlspecialchars(strip_tags($this->userID));

            // Bind Data
            $stmt->bindParam(':itemID', $this->itemID);
            $stmt->bindParam(':userID', $this->userID);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Delete Listing Item
        public function delete() {
            // Create query
            $query = 'DELETE FROM ' . $this->watch_table . ' 
                    WHERE itemID = :itemID AND userID = :userID';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->itemID = htmlspecialchars(strip_tags($this->itemID));
            $this->userID = htmlspecialchars(strip_tags($this->userID));

            // Bind data
            $stmt->bindParam(':itemID', $this->itemID);
            $stmt->bindParam(':userID', $this->userID);

            $stmt->execute();
            $count = $stmt->rowCount();

            // Execute query
            if ($count > 0) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }