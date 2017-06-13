<?php
    //Testing and Debugging.
    //echo $hash;
    //echo $role;
    check_new_user();
    
    function check_new_user(){
        $canImake = has_username();
        if(is_string($canImake)){
            echo "Oops! We seem to be experiencing some difficulties";
        }
        else if(is_bool($canImake)){
            if($canImake){
                make_new_user();
            }
            else{
               echo "This username has already been taken please select an alternative.";
            }
            //echo ($canImake)?"Username creation in progress...":"This username has already been taken...Please select an alternative.";
        }
        else{
            echo "Check Code For Errors!";
        }
    }
    
    function make_new_user(){
        global $name; //requested user name. for uname
        global $hash; //All pulled in from register.php. for secret
        global $hash2; //recovery key for reset
        global $role; //user role for role
        global $db;
        
        $query = 'INSERT INTO authorizedusers (uname, secret, role, reset) VALUES (:u_name, :secret, :role, :reset);';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':u_name', $name);
            $statement->bindValue(':secret', $hash);
            $statement->bindValue(':role', $role);
            $statement->bindValue(':reset', $hash2);
            $statement->execute();
            $statement->closeCursor();
            
            //ALSO IN LOGIN.PHP
            include_once('./utilities/sessionCRUD.php');
            sessionCRUD_startSession();
            //
            $_SESSION['activeAccount'] = 'A';
            $_SESSION['probationAccount'] = "0";
            $_SESSION['bannedAccount'] = "0";
            session_write_close();
            //show navigation links from iframes successfull registration.
                include('./views/register/registerSuccessQuickLinks.php');
                
            //
            exit;
            //MODIFIED TO REFLECT GENERALIZED REGISTRATION
            
            echo "Thank You for registering.";
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            echo $ex->getMessage();
        }
    }
    
    function has_username(){
        //global $hash; //All pulled in from register.php
        //global $hash2; //recovery key
        //global $role; //user role
        //global $name; //requested user name.
        
        global $db;
        global $name;
        $query = 'SELECT * FROM authorizedusers WHERE uname = :u_name';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':u_name', $name);
            $statement->execute();
            //found one.
            $result = $statement->fetch();
            //closes the cursor and frees the server for other statements.
            $statement->closeCursor();
            //print_r($result) for fetchall. and arrays
            //return "processed input -- and ".$result[0]." results -- Done";
            if(!empty($result[0])){
                return false;
            }
            else {
                return true;
            }
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            return $ex->getMessage();
        }
    }
?>