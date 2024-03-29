<?php
    class User {
        // DB stuff
        private $conn;
        private $users_table = 'Users';
        private $bids_table = 'Bids';
        private $items_table = 'Items';
        private $watchlist_table = 'WatchList';

        // User Properties
        public $userID;
        public $email;
        public $pwhash;
        public $firstName;
        public $lastName;  
        public $role;
        public $createdAt;
        public $updatedAt;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Register user
        public function register_user() {
            // Create query
            $query = 'INSERT INTO ' . $this->users_table . '
                SET
                    firstName = :firstName,
                    lastName = :lastName,
                    email = :email,
                    role = :role,
                    createdAt = :createdAt,
                    updatedAt = :updatedAt,
                    pwhash = :pwhash';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);
        
            // Clean Data
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->pwhash = htmlspecialchars(strip_tags($this->pwhash));
            $this->firstName = htmlspecialchars(strip_tags($this->firstName));
            $this->lastName = htmlspecialchars(strip_tags($this->lastName));
            $this->role = htmlspecialchars(strip_tags($this->role));
            $this->createdAt = htmlspecialchars(strip_tags($this->createdAt));
            $this->updatedAt = htmlspecialchars(strip_tags($this->updatedAt));

            // Hash password
            $this->pwhash = password_hash($this->pwhash, PASSWORD_DEFAULT);
            
            // Bind Data
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':pwhash', $this->pwhash);
            $stmt->bindParam(':firstName', $this->firstName);
            $stmt->bindParam(':lastName', $this->lastName);
            $stmt->bindParam(':role', $this->role);
            $stmt->bindParam(':createdAt', $this->createdAt);
            $stmt->bindParam(':updatedAt', $this->updatedAt);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        public function check_unique_email($EMAIL) {
            // Create query
            $query = 'SELECT * FROM ' . $this->users_table . ' WHERE email = ?';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $EMAIL);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        public function read_user() {
            // Create query
            $query = 'SELECT *
            FROM
                ' . $this->users_table .'
            WHERE
                userID = :userID';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':userID', $this->userID);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        public function read_listings_by_seller() {
            // Create query
            $query = 'SELECT *
            FROM
                ' . $this->items_table .'
            WHERE
                userID = :userID';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':userID', $this->userID);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Login user
        public function select_user() {
            // Create query
            $query = 'SELECT u.userID, u.pwhash FROM ' . $this->users_table . ' u WHERE u.userID = ?';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Category
            $stmt->bindParam(1, $this->userID);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        public function user_login() {
            // Create query
            $query = 'SELECT * FROM ' . $this->users_table . ' WHERE email = :email';

            //Prepare Statement
            $stmt = $this->conn->prepare($query);
        
            // Clean Data
            $this->email = htmlspecialchars(strip_tags($this->email));

            // Bind Data
            $stmt->bindParam(':email', $this->email);

            // Execute query
            $stmt->execute();

            return $stmt;
        }
    }