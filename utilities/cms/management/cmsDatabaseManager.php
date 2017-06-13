<?php 
    //ADD LOGIC HERE FOR KEEPING TRACK OF secondary category name and pid for later removal when adding removing new elements
    //in the GUI.
    //Remove Sessions using, allSIDS
    //replace this with a new phpJSConversion function notinsubcats
    //query? 
      //REMOVE FROM secondarycategorydb WHERE 
      //((name = providedname) AND (primaryID = (select id from primarycategorydb where name = providedname))) 
      //OR ((...continues with array contents.
     //at the end remove the final OR and replace with "".

    //include this at the top,
    //important for establishing the database connection.
    if(strpos(getcwd(),'\views\cmsManagement')){
        //\views\cmsManagement
        //aka cmsAJAXRequests.php usage.
        include_once('../../utilities/dbAuth.php');
    }else{ include_once('./utilities/dbAuth.php'); }
        //include_once('http://localhost/PhpProject2B/utilities.dbAuth.php');
        //php.ini allow_url_include = On option.
    
    function cms_remove_deleted($byTable,$notInList){
        
        global $db;
        $query = "DELETE FROM ${byTable} WHERE name NOT IN ${notInList}";//:not_in_list;";
        
        //shows sample of query statment before exectuion for testing purposes.
        echo $query."</br>"."with ${notInList}";
        
        try {
            echo "preparing ..</br>";
            $statement = $db->prepare($query);
            //$statement->bindValue(':not_in_list', $notInList, PDO::PARAM_STR);
            /*
             SQLSTATE[42000]: Syntax error or access violation: 1064 
             * You have an error in your SQL syntax; check the manual 
             * that corresponds to your MySQL server version for the right syntax 
             * to use near ''(\'PrimaryDBTest0\',\'PrimaryDBTest1\',\'PrimaryDBTest2\',\'PrimaryDBTest3\',\'' at line 1
             */
            $affectedRows = $statement->execute();
            echo "Executed Query ..</br>";
            echo "closing connections. ..</br>";
            //closes the cursor and frees the server for other statements.
            $statement->closeCursor();
            
            echo "rows affected ".$affectedRows." ..</br>";
            echo "<br/>";
            echo "Done. Cleaning Up Left-Over Categories.</br>";
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            echo $ex->getMessage();
        }
    }
    
    function cms_remove_deleted_SK($byTable,$notInList){
        //exit(); //Edit On.
        global $db;
        $query = "DELETE FROM ${byTable} WHERE id NOT IN ${notInList}";//:not_in_list;";
        
        //shows sample of query statment before exectuion for testing purposes.
        echo $query."</br>"."with ${notInList}";
        
        try {
            echo "preparing ..</br>";
            $statement = $db->prepare($query);
            //$statement->bindValue(':not_in_list', $notInList, PDO::PARAM_STR);
            /*
             SQLSTATE[42000]: Syntax error or access violation: 1064 
             * You have an error in your SQL syntax; check the manual 
             * that corresponds to your MySQL server version for the right syntax 
             * to use near ''(\'PrimaryDBTest0\',\'PrimaryDBTest1\',\'PrimaryDBTest2\',\'PrimaryDBTest3\',\'' at line 1
             */
            $affectedRows = $statement->execute();
            echo "Executed Query ..</br>";
            echo "closing connections. ..</br>";
            //closes the cursor and frees the server for other statements.
            $statement->closeCursor();
            
            echo "rows affected ".$affectedRows." ..</br>";
            echo "<br/>";
            echo "Done. Cleaning Up Left-Over Categories.</br>";
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            echo $ex->getMessage();
        }
    }

    function cms_find_all_major($byTable,$byColumn){
        
        $debug = false;
        
        global $db;
        $query = "SELECT ${byColumn} FROM ${byTable};";
        
        //shows sample of query statment before exectuion for testing purposes.
        if($debug) echo $query."</br>";
        
        try {
            if($debug) echo "preparing ..</br>";
            $statement = $db->prepare($query);
            $statement->execute();
            if($debug) echo "fetching All ..</br>";
            $result = $statement->fetchAll();

            if($debug) echo "closing connections. ..</br>";
            //closes the cursor and frees the server for other statements.
            $statement->closeCursor();
            
            if($debug) echo "showing ".count($result)." results ..</br>";
            if($debug) print_r($result);
            if($debug) echo "<br/>";
            if($debug) print_r(array_values($result));
            
            if($debug) echo "<br/>";
            if($debug) echo "Done. Returning Array now.</br>";
            return $result;
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            return $ex->getMessage();
        }
    }
    
    function cms_find_all_major_SK($byTable,$byColumn){
        
        $debug = false;
        
        global $db;
        
        //THE QUERY.
        //SELECT primarycategorydb.name, secondarycategorydb.name FROM primarycategorydb 
        //JOIN secondarycategorydb ON primarycategorydb.id = secondarycategorydb.primaryID;
        //$query = "SELECT ${byTable}.${byColumn}, primarycategorydb.name FROM ${byTable} JOIN primarycategorydb;";//OLD and WRONG.
        $query = "SELECT primarycategorydb.name, secondarycategorydb.name FROM primarycategorydb JOIN secondarycategorydb ON primarycategorydb.id = secondarycategorydb.primaryID";

        
        if($debug) echo "<br/>".$query."<br/>";
        
        try {
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();
            return $result;
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            echo $ex->getMessage();
            return array();
        }
    }
    
    ////////////////////////////////////////////////////////////////////////////
    //Get major categories WITH IDS now
    //when finding SK, 
    //array creation for the dropdown option for sk
    //get the list of sk's by primary id.
    //show none at first
    //and only show/hide the one with a matching tag id of forPID0, forPID1, etc...
    function cms_find_all_major_withID($byTable)
    {
        
        global $db;
        $query = "SELECT id,name FROM primarycategorydb";
        
        try {
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();
            return $result;

        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
    
    function cms_find_all_major_SK_withID(){
        global $db;
        $query = "SELECT id,name,primaryID FROM secondarycategorydb";
        
        try {
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();
            return $result;
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            echo $ex->getMessage();
            return array();
        }
    }
    //
    ////////////////////////////////////////////////////////////////////////////
    
    function cms_find_all_IDS_SK($a){
        //SELECT id FROM secondarycategorydb WHERE 
        //((secondarycategorydb.name = 'SubCat1') AND secondarycategorydb.primaryID = (select id from primarycategorydb where name = 'PrimaryDBTest0'))
        //OR
        //((secondarycategorydb.name = 'SubCat1') AND secondarycategorydb.primaryID = (select id from primarycategorydb where name = 'PrimaryDBTest0'))
        //;
        global $db;
        $idArray = array('one','two');
        $query = "Select id FROM secondarycategorydb WHERE ";
        foreach($a as $key=>$val){
            echo "<br/>";
            echo $val[0];
            echo $val[1];
            echo "<br/>";
            
            $query .= " ((secondarycategorydb.name = '${val[0]}') AND secondarycategorydb.primaryID = (select id from primarycategorydb where name = '${val[1]}')) OR";
        }
        $query[strlen($query)-1]=" "; //R
        $query[strlen($query)-2]=" "; //O
        echo $query."<br/>";
        $statement = $db->prepare($query);
        $statement->execute();
        $idArray = $statement->fetchAll();
        $statement->closeCursor();
        
        return $idArray;
    }
    
    function submit_primary($newName){
        
        global $db;
        $query = 'INSERT INTO primarycategorydb (name) VALUES (:u_name);';
        
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':u_name', $newName);
            $statement->execute();
            $statement->closeCursor();
            
            //attempting to enter a new item into the database.
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            echo $ex->getMessage();
        }
    }
    
    function submit_secondary($newName, $primID){
        
        global $db;
        $r = null;
        
        try
        {
        //select id from primarycategorydb where name = primid
        //if id exists use this value.
        //otherwise there is an issue with the primary category not being in the db.
            $query = "SELECT id FROM primarycategorydb WHERE name = :p_name";
            $statement = $db->prepare($query);
            $statement->bindValue(':p_name', $primID);
            $statement->execute();
            
            $r = $statement->fetch();
            $primID = $r[0];
            echo $primID; //has been now set to the primary tables index if successfull.

            $statement->closeCursor();
        } 
        catch (PDOException $ex) 
        {
            //quit on failure after sending an error message back to the browser.
            //set debug to false to disable error messages entirely.
            echo $ex->getMessage();
            exit();
        }
        
        
        echo "<br/>Attempting to Submit Secondary Category<br/>".$newName."---".$primID."<br/>";
        $query = 'INSERT INTO secondarycategorydb (name,primaryID) VALUES (:u_name, :p_id);';
        
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':u_name', $newName);
            $statement->bindValue(':p_id', $primID);
            $hasSucceeded = $statement->execute();
            $statement->closeCursor();
            
            if($hasSucceeded){
                $primID = $r[0];
                //$GLOBALS['allSIDS'][] = [$newName, $primID]; 
                echo $primID; //has been now set to the primary tables index if successfull.
                
                echo "<br/>----------------------------<br/>";
                echo "Subcategory has been added.";
            }
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            echo $ex->getMessage();
        }
    }
    
    //add pid and sid defaults here if not included at a later time.
    function only_add_unique_values($checkTable, $checkColumn, $checkValue, $catLevel, $pname=NULL){
        
        global $db;
        
        //TODO:compare all to the current primary subcatagory js arrays to see if any categories have been removed.
        //TODO:check the indexof for each.
        //TODO:if -1 then remove the option after upadting.
        
        $GLOBALS['all'] = array(); //named items that are already in the database.
        $GLOBALS['fresh'] = array(); //named items that need to be added.
        //$GLOBALS['allSIDS'] = array(); //the id of subcategories that should not be removed from the database.
        
        //or keep track of value for a where not in clause. for the second stage of category removal.
        //make sure the (currently primeEditor.php) has set $GLOBALS['notinSK'] = array();
        //CREATING A NOT IN CLAUSE FOR SECONDARY CATEGORY SQL Statements.
        //WHERE (() AND ()) OR (() AND ()) OR (() AND ())...
        
        //The Query...
                //SELECT secondarycategorydb.name, secondarycategorydb.id, primarycategorydb.name FROM secondarycategorydb 
                //JOIN primarycategorydb ON secondarycategorydb.primaryID = primarycategorydb.id
                //WHERE primarycategorydb.name = 'PrimaryDBTest0'
                //AND secondarycategorydb.name = 'SubCat1';
                
               //converted to the below statement for removing deleted items from the list.
        
        /*
         * 
                //SELECT secondarycategorydb.name, secondarycategorydb.id, primarycategorydb.name FROM secondarycategorydb 
                //JOIN primarycategorydb ON secondarycategorydb.primaryID = primarycategorydb.id
                //WHERE primarycategorydb.name = 'PrimaryDBTest0'
                //AND secondarycategorydb.name = 'SubCat1';
         * 
         */
        
        $all = array();
        $fresh = array();

        switch($catLevel){
            case "primary": 
                $query = "SELECT ${checkColumn} FROM ${checkTable} WHERE ${checkColumn} = :checked_value";
                break;
            case "secondary": 
                //The Query...
                //SELECT secondarycategorydb.name, secondarycategorydb.id, primarycategorydb.name FROM secondarycategorydb 
                //JOIN primarycategorydb ON secondarycategorydb.primaryID = primarycategorydb.id
                //WHERE primarycategorydb.name = 'PrimaryDBTest0'
                //AND secondarycategorydb.name = 'SubCat1';
                
                //OLD//$query = "SELECT secondarycategorydb.name, primarycategorydb.id FROM secondarycategorydb JOIN primarycategorydb ON secondarycategorydb.primaryID = primarycategorydb.id WHERE primarycategorydb.name = :check_pID AND secondarycategorydb.name = :checked_value";
                //NEW//for a subcategory keep track of the secondarycategorydb.primaryID's.
                $query = "SELECT secondarycategorydb.name, secondarycategorydb.id , primarycategorydb.id FROM secondarycategorydb JOIN primarycategorydb ON secondarycategorydb.primaryID = primarycategorydb.id WHERE primarycategorydb.name = :check_pID AND secondarycategorydb.name = :checked_value";
                    echo $query."<br/>";
                    //exit();//show query but do not execute.
                
                break; //add where limits to check the pID, name and primaryID columns for insertion if unique.
            case "topics": 
                break; //add where limits to check the pID and sID for any NEW topics added.
        }
        
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':checked_value', $checkValue);
            if($catLevel == "secondary" && is_string($pname))
            {
                $statement->bindValue(':check_pID', $pname);
            }
            $statement->execute();
            //try to find one.
            $result = $statement->fetch();
            $statement->closeCursor();
            
            if(!empty($result[0])){
                echo "${checkValue} already exists ${result[0]}.<br/>";
                //return false;
                //$GLOBALS['allSIDS'][] = [$checkValue, $result[2]]; 
            }
            else {
                echo "Adding ${checkValue} to the relevant database.<br/>";
                switch($catLevel){
                    case "primary": 
                        submit_primary($checkValue); break;
                        
                    case "secondary": 
                        //set global to include the index of inserted items. 
                        submit_secondary($checkValue, $pname); break; 
                    
                    case "topics": break;//only for content contributers
                    
                    case "modroles": break;//allow administraion to modify user roles, probation, banishment.
                }
                //return true;
            }
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            //return $ex->getMessage();
        }
    }
    
    function AddNewTopic($title, $primID, $secID)
    {
        global $db;
        $query = 'INSERT INTO topicsdb (name,primaryID, secondaryID) VALUES (:u_name, :p_id, :s_id);';
        
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':u_name', $title);
            $statement->bindValue(':p_id', $primID);
            $statement->bindValue(':s_id', $secID);
            $statement->execute();
            $affected = $statement->rowCount();
            $statement->closeCursor();
            
            if($affected == 1)
            {
                echo "success";
            }
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            echo $ex->getMessage();
        }
    }
    
    function RemoveExistingTopic($title, $primID, $secID)
    {
        global $db;
        $query = 'DELETE FROM topicsdb WHERE name=:u_name AND primaryID=:p_id AND secondaryID=:s_id;';
        
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':u_name', $title);
            $statement->bindValue(':p_id', $primID);
            $statement->bindValue(':s_id', $secID);
            $statement->execute();
            $affected = $statement->rowCount();
            $statement->closeCursor();
            
            if($affected == 1)
            {
                echo "success";
            }
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            echo $ex->getMessage();
        }
    }

    function cms_find_all_major_Topics()
    {
        global $db;
        global $jsvarname;
        $showTopicsGeneratedinGui=false;
        $jsvarname = "allTopicsByCat";
        $query = 'SELECT name, primaryID, secondaryID FROM topicsDB';
        
        try {
            $statement = $db->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll();
            $statement->closeCursor();
            
            if(count($results) >= 1)
            {
                //success.
                
                $obj = "";
                
                foreach($results as $value)
                {
                    $uniqueIdentifier = $value[1]."-".$value[2];
                    $tempName = $value[0];
                    $obj .= "if(typeof(${jsvarname}['${uniqueIdentifier}']) === 'undefined'){ ${jsvarname}['${uniqueIdentifier}']=[]; ${jsvarname}['${uniqueIdentifier}'].push('${tempName}'); }else{ ${jsvarname}['${uniqueIdentifier}'].push('${tempName}'); }";
                }
                if($showTopicsGeneratedinGui){echo $obj;}
                return $obj;
            }
            else
            {
                //empty object.
                return $jsvarname." = {};";
            }
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            echo $ex->getMessage();
        }
    }
    
    function UpdateDraftInfo($title, $primID, $secID, $draft)
    {
        global $db;
        $query = 'UPDATE topicsdb SET contents = :u_draft WHERE name=:u_name AND primaryID=:p_id AND secondaryID=:s_id;';
        
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':u_draft', $draft);
            $statement->bindValue(':u_name', $title);
            $statement->bindValue(':p_id', $primID);
            $statement->bindValue(':s_id', $secID);
            $statement->execute();
            $affected = $statement->rowCount();
            $statement->closeCursor();
            
            if(count($affected) > 0)
            {
                echo "success";
            }
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            echo $ex->getMessage();
        }
    }
    
    function ReloadDraftInfo($title, $primID, $secID)
    {
        global $db;
        $query = 'SELECT contents FROM topicsdb WHERE name=:u_name AND primaryID=:p_id AND secondaryID=:s_id;';
        
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':u_name', $title);
            $statement->bindValue(':p_id', $primID);
            $statement->bindValue(':s_id', $secID);
            $statement->execute();
            $affected = $statement->rowCount();
            if(count($affected) > 0)
            {
                //echo "inside delivery of draft contents";
                $r = $statement->fetch();
                echo $r[0];
            }
            $statement->closeCursor();
            
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            echo $ex->getMessage();
        }
    }
    function updateTopicUrl($title, $primID, $secID)
    {
        global $db;
        $url = str_replace(' ', '-', $title);
        $url = "${url}-${primID}-${secID}";
        $query = 'UPDATE topicsdb SET url = :gen_url WHERE name=:u_name AND primaryID=:p_id AND secondaryID=:s_id;';
        
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':gen_url', $url);
            $statement->bindValue(':u_name', $title);
            $statement->bindValue(':p_id', $primID);
            $statement->bindValue(':s_id', $secID);
            $statement->execute();
            
            $statement->closeCursor();
            
            
        } catch (PDOException $ex) {
            //if a string is return some error has occured.
            echo $ex->getMessage();
        }
    }
?>