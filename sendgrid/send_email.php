<?php

require_once 'config.php';
require 'vendor/autoload.php';

class EmailFunction{
    //send_email("johnny","dbtestsimon833@gmail.com","macbook");
    // Constructor with DB

    public static function send_outbid_email($user_id,$item_id, $db){

        $conn = $db;
        #get name and email
        $query = self::get_name_email($user_id, $conn);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $name =  $result["firstName"];
        $email = $result["email"];

        #get item title
        $data = self::get_item_name($item_id, $conn);
        $item_title = $data->fetch(PDO::FETCH_ASSOC)["title"];

        #send message
        $message = " you have been outbid on " . $item_title;
        $message_subject_line = "You have been outbid on " . $item_title . "!";
        self::send_email($name,$email,$message_subject_line, $message,$item_title);
    }

    private static function get_name_email($user_id, $conn){

        // Create query
        $query = 'SELECT firstName, email FROM Users 
        WHERE userID = ?';

        //Prepare Statement
        $stmt = $conn->prepare($query);
    
        // Bind Data
        $stmt->bindParam(1, $user_id);
    
        // Execute query
        $stmt->execute();

        return $stmt;  
    }

    private static function get_item_name($item_id, $conn){

        // Create query
        $query = 'SELECT title FROM Items 
        WHERE itemID = ?';
    
        //Prepare Statement
        $stmt = $conn->prepare($query);
    
        // Bind Data
        $stmt->bindParam(1, $item_id);

        // Execute query
        $stmt->execute();

        return $stmt;     
    }

    private static function send_email($name,$email_input,$message_subject_line,$message,$item_title){

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("epay.notification.noreply@gmail.com", "epay Notification");
        $email->setSubject($message_subject_line);
        $email->addTo($email_input, $name);
        
        $body_message = "Hi " . $name . ", " . $message . ".";
        
        $email->addContent("text/plain", $body_message);
        
        $html_body = "<strong>" . $body_message . "<strong>";

        $email->addContent("text/html", $html_body);
        $sendgrid = new \SendGrid(SENDGRID_API_KEY);
        try {
            $response = $sendgrid->send($email);
            //print $response->statusCode() . "\n";
            //print_r($response->headers());
            //print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

    
    public static function send_watchlist($user_id,$item_id, $db){

        $conn = $db;

        #get list of users ids
        $query_watchlist = self::get_users_watchlist($item_id,$user_id,$conn);

        $users_arr = array();
        $users_arr['data'] = array();

        while ($row = $query_watchlist->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $user_instance = array(
                'userID' => $userID
            );

            // Push to "data"
            array_push($users_arr['data'], $user_instance);
        }

        // Turn to JSON & output
        echo json_encode($users_arr);

        $number_of_results = $query_watchlist->rowCount();

        #get item title
        $data = self::get_item_name($item_id, $conn);
        $item_title = $data->fetch(PDO::FETCH_ASSOC)["title"];

        $message = " a new bid has been placed on the item " . $item_title;
        $message_subject_line = "New bid on your watchlist item " . $item_title . "!";
        
        #send message to everyone
        for($i = 0; $i < $number_of_results; $i++){
            
            $curr_user_id = $users_arr["data"][$i]["userID"];
            
            #get name and email
            $query = self::get_name_email($curr_user_id, $conn);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $name =  $result["firstName"];
            $email = $result["email"];

            self::send_email($name,$email,$message_subject_line,$message,$item_title);
        }
    }

    //Calling the function will send out emails to everyone who watch the email, except for the person who made the bid
    //i.e. $user_id, is the person making the bid
    private static function get_users_watchlist($item_id,$user_id,$conn){
        // Create query
        $query = 'SELECT userID FROM watchlist WHERE itemID = ? AND userID NOT IN (?)';
    
        //Prepare Statement
        $stmt = $conn->prepare($query);
    
        // Bind Data
        $stmt->bindParam(1, $item_id);
        $stmt->bindParam(2, $user_id);

        // Execute query
        $stmt->execute();

        return $stmt;
    }
}