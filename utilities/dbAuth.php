<?php
    $debug = false;
    
    //attempt to initilize the database
    //table is authorizedusers with secret and role.
    $dsn = 'mysql:host=localhost;dbname=datacorpdb';
    $username = 'user1';
    $password = 'pass1';
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    
    $error_message = null;
    
    try {
        $db = new PDO($dsn, $username, $password, $options);
    } catch (PDOException $ex) {
        $error_message = $ex->getMessage();
        //for debugging purposes only.
        echo "<p>".$error_message."</p>";
        exit;
    }
    if($debug) echo "<p>PDO connection to DB was successfull.</p>";
?>