<?php
    class Item {
        // DB stuff
        private $conn;
        private $items_table = 'Items';
        private $users_table = 'Users';
        private $bids_table = 'Bids';

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

        // Get Single Item, used if an auction is currently ongoing
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
                    userID = :userID,
                    highestPrice = :highestPrice

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
            $this->highestPrice = htmlspecialchars(strip_tags($this->highestPrice));

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
            $stmt->bindParam(':highestPrice', $this->highestPrice);

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

        // Get Items of that match a specific search query
        public function read_search() {
            // Create query
            $query = 'SELECT 
                *
            FROM
                ' . $this->items_table . '
            WHERE ';

            $word_searched = "";//The original term that the user is searching for, to be used for throwing back an error
            
            $search_words = explode(' ', $this->input);

            foreach ($search_words as $word){
                $query .= "title LIKE '%" . $word . "%' OR "; 
                $word_searched .= $word. ' ';
            }

            $query = substr_replace($query, "", -4);
            $word_searched = substr_replace($word_searched, "", -1);

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // This method should always be called before Item info page loads! To check if it has ended
        public function has_auction_ended() {
            // Create query
            $query = 'SELECT 
                i.endDateTime
            FROM
                ' . $this->items_table . ' i
            WHERE
                i.itemID = ?
            LIMIT 0, 1';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->itemID);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Single Item, when the auction has ended
        public function read_item_auction_end() {
            // Create query
            $query = 'SELECT 
                b.userID,
                i.highestPrice,
                i.reservePrice,
                i.title,
                i.description,
                i.category,
                i.bidID,
                i.endDateTime,
                i.startDateTime
            FROM
                ' . $this->items_table . ' i
            INNER JOIN ' . $this->bids_table .' b ON i.bidID = b.bidID
            WHERE
                i.itemID = ?';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->itemID);

            // Execute query
            $stmt->execute();

            return $stmt;
        }
    }