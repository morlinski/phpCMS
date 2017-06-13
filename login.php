<?php
    include_once('./utilities/dbAuth.php');

    include_once('./utilities/sessionCRUD.php');
    sessionCRUD_startSession();
    
    $testAllManagerGUIS = false;
    if($testAllManagerGUIS)
    {
        /*NEW METHOD REFLECTING THE USER STATUS IN head.php*/
        if( empty($_SESSION['activeAccount']) ) 
            { 
                $_SESSION['activeAccount'] = "ActiveUserTest";
                $_SESSION['probationAccount'] = "1";
                $_SESSION['bannedAccount'] = "1";
                session_write_close();

                header('Location: ./index.php');
                exit;
            }
            else
            {

            }
        /*END OF*/
    }
    else 
    {
        if( empty($_SESSION['activeAccount']) ) 
        {
            global $db;
            $UserNameFromLogin = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $PasswordFromLogin = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if(isset($UserNameFromLogin) && isset($PasswordFromLogin)){
                $query = "SELECT role, probation, banned FROM authorizedusers WHERE uname = :lgn_usr AND secret = :lgn_key";
                $statement = $db->prepare($query);
                $statement->bindValue(':lgn_usr', $UserNameFromLogin);
                $statement->bindValue(':lgn_key', sha1($UserNameFromLogin.$PasswordFromLogin));
                $statement->execute();
                $results = $statement->fetch();
                if(count($results)>0){
                    sessionCRUD_create('activeAccount', $results[0]);
                    sessionCRUD_create('probationAccount', $results[1]);
                    sessionCRUD_create('bannedAccount', $results[2]);
                        //$_SESSION['probationAccount'] = "0";
                        //$_SESSION['bannedAccount'] = "0";
                        $OnProbation = $_SESSION['probationAccount'];
                        $IsBanned = $_SESSION['bannedAccount'];
                    //session_write_close();
                }
                $statement->closeCursor();
                session_write_close();
                header('Location: ./index.php');
                exit;
            }
        }
    }
?>