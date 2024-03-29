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
        public $auctionStatus;
        public $winner;
        public $lastName;

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
                i.image,
                i.auctionStatus,
                i.winner
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

        // // WE WILL NOT BE IMPLEMENTING: Update Listing Item
        /* public function update() {
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
        } */

        // WE WILL NOT BE IMPLEMENTING: Delete Listing Item
        /* public function delete() {
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
        } */

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

        // Get Items of that match a specific search query
        public function read_recommendations($itemID, $IdToRecommend, $db) {
            // Create query
            
            $query = 'SELECT * FROM Items INNER JOIN Bids ON Bids.itemID = Items.itemID WHERE ';

            $word_searched = "";//The original term that the user is searching for, to be used for throwing back an error
            
            $list_of_userIDs = self::get_list_of_user_ids($itemID, $IdToRecommend, $db);

            foreach ($list_of_userIDs as $userID){

                $query .= "Bids.userID = " . $userID['userID'] . " OR "; 
                $word_searched .= $userID. ' ';
            }

            $query = substr_replace($query, "", -4);
            $word_searched = substr_replace($word_searched, "", -1);

            $query .= ' AND Items.itemID NOT IN (:itemID) LIMIT 0, 5';

            if (empty($list_of_userIDs)) {
                $query = 'SELECT * FROM Items INNER JOIN Bids ON Bids.itemID = Items.itemID LIMIT 0,0';
            }
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);
            
            // Bind ID
            $stmt->bindParam(":itemID", $itemID);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Gets userId lists who bidded on that same item except for original user
        private static function get_list_of_user_ids($itemID, $userID, $db) {
            // Create query
            $query = 'SELECT DISTINCT(userID) FROM Bids WHERE itemID = :itemID AND userID NOT IN (:userID)';

            // Prepare Statement
            $stmt = $db->prepare($query);
            
            // Bind Category
            $stmt->bindParam(":userID", $userID);
            $stmt->bindParam(":itemID", $itemID);
        
            // Execute query
            $stmt->execute();


            $userIDs_arr = array();
            $userIDs_arr['data'] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $userID_instance = array(
                    'userID' => $userID
                );

                // Push to "data"
                array_push($userIDs_arr['data'], $userID_instance);
            }

            return $userIDs_arr['data'];
        }

        // Get Items of that match a specific search query
        public function get_all_bidded_items($USERID) {
            // Create query
            $query = 'SELECT DISTINCT(itemID) From Bids WHERE userID = ?'; 

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Category
            $stmt->bindParam(1, $USERID);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        public function set_status_inactive_set_winner() {
            // Create query
            $query = "UPDATE Items
                SET auctionStatus = 'inactive', winner = ?
                WHERE itemID = ?";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Category
            $stmt->bindParam(1, $this->userID);
            $stmt->bindParam(2, $this->itemID);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get userID of a particular Item's latest Bid
        public function read_user_latest_bid() {
            // Create query
            $query = 'SELECT Bids.userID, Users.firstName, Users.lastName 
                FROM Bids 
                INNER JOIN Users ON Bids.userID = Users.userID 
                INNER JOIN Items ON Bids.bidID = Items.bidID AND Items.itemID = ?';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Category
            $stmt->bindParam(1, $this->itemID);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Items of that a User has Won
        public function read_won() {
            // Create query
            $query = 'SELECT 
                *
            FROM
                ' . $this->items_table . '
            WHERE 
                winner = ?';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Category
            $stmt->bindParam(1, $this->userID);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

    }