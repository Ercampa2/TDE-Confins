<?php

    function connect_confins() {
        
        $mysqli = new mysqli("localhost:3306","root","","confins");
        // $mysqli = new mysqli("localhost:3307","root","","confins");
        
        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit();
        }
        return $mysqli; 
    }
    
?>