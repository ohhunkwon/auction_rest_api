<?php
    class Item {
        // DB stuff
        private $conn;
        private $table = 'Items';

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
                u.firstname,
                i.description,
                i.category,
                i.endDateTime,
                i.startingPrice
            FROM
                ' . $this->table . ' i
            JOIN 
                Users as u ON i.userID = u.userID
            ORDER BY 
                i.itemID DESC';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);
            // Execute query
            $stmt->execute();

            return $stmt;
        }
    }