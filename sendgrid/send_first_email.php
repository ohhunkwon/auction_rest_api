<?php

require_once 'config.php';
require 'vendor/autoload.php';

class emailFunction{

    //send_email("johnny","dbtestsimon833@gmail.com","macbook");

    public static function send_outbid_email($user_id,$item_id){

        #get name and email
        $res = get_name_email($user_id);
        $name = $res->fetch(PDO::FETCH_ASSOC)["firstName"];
        $email = $res->fetch(PDO::FETCH_ASSOC)["email"];

        #get item title
        $data = get_item_name($item_id);
        $item_title = $res->fetch(PDO::FETCH_ASSOC)["title"];

        #send message
        send_email($name,$email,$item_title);
    }

    private function get_name_email($user_id){

        // Create query
        $query = 'SELECT firstName, email FROM Users 
        WHERE userID = ?';
    
        //Prepare Statement
        $stmt = $this->conn->prepare($query);
    
        // Bind Data
        $stmt->bindParam(1, $user_id);
    
        // Execute query
        if ($stmt->execute()) {
            return $stmt; 
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
    
        return false;    
    }

    private function get_item_name($item_id){

        // Create query
        $query = 'SELECT title FROM Items 
        WHERE itemID = ?';
    
        //Prepare Statement
        $stmt = $this->conn->prepare($query);
    
        // Bind Data
        $stmt->bindParam(1, $item_id);
    
        // Execute query
        if ($stmt->execute()) {
            return $stmt; 
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
    
        return false;    
    }

    public function send_email($name,$email,$item_title){
    
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("epay.notification.noreply@gmail.com", "epay Notification");
        $email->setSubject("You have been outbid!");
        $email->addTo($email, $name);
        
        $body_message = "Hi, " . $name . "you have been outbid on " . $item_title;
        
        $email->addContent("text/plain", $body_message);
        
        $html_body = "<strong>" . $body_message . "<strong>";

        $email->addContent("text/html", $html_body);
        $sendgrid = new \SendGrid(SENDGRID_API_KEY);
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }

}