<?php

require_once 'config.php';
require 'vendor/autoload.php';

class emailFunction{
    //send_email("johnny","dbtestsimon833@gmail.com","macbook");
    // Constructor with DB

    public static function send_outbid_email($user_id,$item_id, $db){

        $conn = $db;

        #get name and email
        $query = self::get_name_email($user_id, $conn);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $name =  $result["firstName"];
        $email = $result["email"];

        echo json_encode(
            $email
        );

        #get item title
        $data = self::get_item_name($item_id, $conn);
        $item_title = $data->fetch(PDO::FETCH_ASSOC)["title"];

        #send message
        self::send_email($name,$email,$item_title);
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

    private static function send_email($name,$email_input,$item_title){

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("epay.notification.noreply@gmail.com", "epay Notification");
        $email->setSubject("You have been outbid!");
        $email->addTo($email_input, $name);
        
        $body_message = "Hi, " . $name . " you have been outbid on " . $item_title;
        
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

}