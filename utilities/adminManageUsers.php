<?php
    //echo getcwd();
    include('./dbAuth.php');
    //only set debug values locally after any includes 
    //to prevent unintentially setting the value back to falsse
    $debug= false;
    $mysqlTF = array('0','1');
    global $db;
        
    //printBooleanValue($debug);
    
    try{
        //FROM JS. var submitData = { 'editname':uname, 'editrole':urole, 'editprobation':uprob, 'editban':uban };
        $createNewUser = filter_input(INPUT_GET, 'create', FILTER_SANITIZE_STRING);
        $submitedName = filter_input(INPUT_GET, 'editname', FILTER_SANITIZE_STRING);
        $submitedRole = filter_input(INPUT_GET, 'editrole', FILTER_SANITIZE_STRING);
        $submitedProbation = filter_input(INPUT_GET, 'editprobation', FILTER_SANITIZE_STRING);
        $submitedBan = filter_input(INPUT_GET, 'editban', FILTER_SANITIZE_STRING);
        
            $submitedProbation = ($submitedProbation == "true")? 1: 0;
            $submitedBan = ($submitedBan == "true")? 1: 0;
            //printBooleanValue($debug);
        if($debug) { 
            print_r([$submitedName, $submitedRole, $submitedProbation, $submitedBan]);
   
        }
        
        if(isset($createNewUser) && $createNewUser=="+++" &&
               !empty($submitedRole) && in_array($submitedProbation, $mysqlTF ) && in_array($submitedBan, $mysqlTF) && !empty($submitedName)){
                    
                    $query = "INSERT INTO authorizedusers (role, probation, banned, uname, secret, reset) VALUES (:value_1,:value_2,:value_3,:value_4,:value_5,:value_6)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':value_1', $submitedRole);
                    $statement->bindValue(':value_2', $submitedProbation);
                    $statement->bindValue(':value_3', $submitedBan);
                    $statement->bindValue(':value_4', $submitedName);
                    
                    $passKey = str_shuffle('ABCDEFGHIJKLMNOPqrstuvwxyz0123456');
                    $hash = sha1($submitedName.$passKey);
                    $hash2 = sha1($passKey.$submitedName);
                    
                    $statement->bindValue(':value_5', $hash);
                    $statement->bindValue(':value_6', $hash2);
                    
                    echo " generated login keys , ${'passKey'}";
               }
        elseif(!isset($createNewUser) && !empty($submitedRole) && in_array($submitedProbation, $mysqlTF ) && in_array($submitedBan, $mysqlTF) && !empty($submitedName)){
            //update the users permission levels.
            $query = "UPDATE authorizedusers SET role = :value_1, probation = :value_2, banned = :value_3 WHERE uname = :value_4";
            $statement = $db->prepare($query);
            $statement->bindValue(':value_1', $submitedRole);
            $statement->bindValue(':value_2', $submitedProbation);
            $statement->bindValue(':value_3', $submitedBan);
            $statement->bindValue(':value_4', $submitedName);
            echo "Modifying User Now";
        }
        elseif(!isset($createNewUser) && empty($submitedRole) && in_array($submitedProbation, $mysqlTF ) && in_array($submitedBan, $mysqlTF) && !empty($submitedName)){
            //remove the user.
            $query = "DELETE FROM authorizedusers WHERE uname = :value_4";
            $statement = $db->prepare($query);
            $statement->bindValue(':value_4', $submitedName);
            echo "Removing User Now";
        }
        if(!empty($statement)){
            $statement->execute();
            echo "Affected ".$statement->rowCount()." Number Of Rows.";
            $statement->closeCursor();
        }
        else
            { echo "Could Not Complete The Requested Query."; }
        
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
    
    function printBooleanValue($bool){
        $bool = ($bool)?".IS TRUE.":".IS FALSE.";
        echo 'Testing scope for ${bool}'.$bool.",";
    }
?>