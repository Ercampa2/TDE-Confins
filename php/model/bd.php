<?php
    function connect_confins() {
        
        $mysqli = new mysqli("localhost","root","","Confins");
        
        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit();
        }
        return $mysqli; 
    }
?>