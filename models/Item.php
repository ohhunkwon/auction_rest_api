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
        public $image;
        public $firstName;

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
                i.bidID,
                i.image
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

        // Get Single Item
        public function read_item() {
            // Create query
            $query = 'SELECT 
                i.itemID,
                i.title,
                i.userID,
                i.startDateTime,
                i.reservePrice,
                i.description,
                i.category,
                i.endDateTime,
                i.startingPrice,
                i.bidID,
                i.image,
                u.firstName
            FROM
                ' . $this->items_table . ' i, ' . $this->users_table .' u
            WHERE
                i.itemID = ? AND u.userID = i.userID
            LIMIT 0, 1';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->itemID);

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
                i.bidID,
                i.image
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

        // Create Listing Items
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->items_table . '
                SET
                    title = :title,
                    description = :description,
                    category = :category,
                    startingPrice = :startingPrice,
                    reservePrice = :reservePrice,
                    startDateTime = :startDateTime,
                    endDateTime = :endDateTime,
                    image = :image,
                    userID = :userID

            ';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);
        
            // Clean Data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->startingPrice = htmlspecialchars(strip_tags($this->startingPrice));
            $this->reservePrice = htmlspecialchars(strip_tags($this->reservePrice));
            $this->startDateTime = htmlspecialchars(strip_tags($this->startDateTime));
            $this->endDateTime = htmlspecialchars(strip_tags($this->endDateTime));
            $this->image = htmlspecialchars(strip_tags($this->image));
            $this->userID = htmlspecialchars(strip_tags($this->userID));

            // Bind Data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':startingPrice', $this->startingPrice);
            $stmt->bindParam(':reservePrice', $this->reservePrice);
            $stmt->bindParam(':startDateTime', $this->startDateTime);
            $stmt->bindParam(':endDateTime', $this->endDateTime);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':userID', $this->userID);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Update Listing Item
        public function update() {
            // Create query
            $query = 'UPDATE ' . $this->items_table . '
                SET
                    title = :title,
                    description = :description,
                    category = :category,
                    startingPrice = :startingPrice,
                    reservePrice = :reservePrice,
                    startDateTime = :startDateTime,
                    endDateTime = :endDateTime,
                    image = :image
                WHERE
                    itemID = :itemID';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);
        
            // Clean Data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->startingPrice = htmlspecialchars(strip_tags($this->startingPrice));
            $this->reservePrice = htmlspecialchars(strip_tags($this->reservePrice));
            $this->startDateTime = htmlspecialchars(strip_tags($this->startDateTime));
            $this->endDateTime = htmlspecialchars(strip_tags($this->endDateTime));
            $this->image = htmlspecialchars(strip_tags($this->image));
            $this->itemID = htmlspecialchars(strip_tags($this->itemID));

            // Bind Data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':startingPrice', $this->startingPrice);
            $stmt->bindParam(':reservePrice', $this->reservePrice);
            $stmt->bindParam(':startDateTime', $this->startDateTime);
            $stmt->bindParam(':endDateTime', $this->endDateTime);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':itemID', $this->itemID);

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
            $query = 'DELETE FROM ' . $this->items_table . ' WHERE itemID = :itemID';

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