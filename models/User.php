<?php
    class User {
        // DB stuff
        private $conn;
        private $users_table = 'Users';
        private $bids_table = 'Bids';
        private $watchlist_table = 'WatchList';

        // User Properties
        public $userID;
        public $firstName;
        public $lastName;
        public $email;
        public $role;
        public $createdAt;
        public $updatedAt;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }