<?php
    class Item {
        // DB stuff
        private $conn;
        private $items_table = 'Items';
        private $users_table = 'Users';

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

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Items
        public function read() {
            // Create query
            $query = 'SELECT 
                i.itemID,
                i.title,
                i.userID,
                i.startDateTime,
                i.reservePrice,
                u.firstName,
                i.description,
                i.category,
                i.endDateTime,
                i.startingPrice,
                i.bidID
            FROM
                ' . $this->items_table . ' i, ' . $this->users_table . ' u
            WHERE
                i.userID = u.userID
            ORDER BY 
                i.itemID DESC';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);
            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Items of Specific Category
        public function read_category() {
            // Create query
            $query = 'SELECT 
                i.itemID,
                i.title,
                i.userID,
                i.startDateTime,
                i.reservePrice,
                u.firstName,
                i.description,
                i.category,
                i.endDateTime,
                i.startingPrice,
                i.bidID
            FROM
                ' . $this->items_table . ' i, ' . $this->users_table . ' u
            WHERE
                i.userID = u.userID AND i.category = ?
            ORDER BY 
                i.itemID DESC'; 

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Category
            $stmt->bindParam(1, $this->category);

            // Execute query
            $stmt->execute();

            return $stmt;
        }
    }