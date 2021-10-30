<?php
    class Watchlist {
        // DB stuff
        private $conn;
        private $watch_table = 'Watchlist';
        private $user_table = 'Users';

        // Item Properties
        public $itemID;
        public $userID;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Watchlist of specific User
        public function read() {
            $query = 'SELECT 
                Watchlist.itemID,
                Users.userID
            FROM
                ' . $this->watch_table . '
            INNER JOIN ' . $this->user_table . ' ON Users.userID = Watchlist.userID AND Users.userID = ?';

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
            $query = 'DELETE FROM ' . $this->watch_table . ' WHERE itemID = :itemID';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->itemID = htmlspecialchars(strip_tags($this->itemID));

            // Bind data
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