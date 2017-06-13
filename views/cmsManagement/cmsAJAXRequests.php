<?php
    ///echoed statements that will cause issues when updating arrays in ajax requests.
    
    //if for some reason inclusions are not working use...
        ///echo getcwd();
        ///echo "<br/>";
        ///include_once('../../utilities/cms/management/testInclusionPath.php');
    //THE ABOVE THREE LINES OF CODE>
    //use new relation below.
    //include_once('./utilities/cms/management/cmsDatabaseManager.php');
    include_once('../../utilities/cms/management/cmsDatabaseManager.php');
    
    include_once('../../utilities/phpJsConversions.php');
    
    $shouldUploadToServer = filter_input(INPUT_POST, 'saveToURL');
    if(!empty($shouldUploadToServer) && $shouldUploadToServer=="yesPlease")
    {
        $TempTitle = filter_input(INPUT_POST,'TITLE', FILTER_SANITIZE_SPECIAL_CHARS);
        $pid = filter_input(INPUT_POST,'PRIM', FILTER_SANITIZE_NUMBER_INT);
        $sid = filter_input(INPUT_POST,'SECONDARY', FILTER_SANITIZE_NUMBER_INT);
        $contents = filter_input(INPUT_POST,'cleanHTML');
        
        if(empty($TempTitle) || empty($pid) || empty($sid) || empty($contents))
        {
            echo "failed to retrieve the necessary arguments.";
            exit();
        }
        else
        {
            //upload contents into the content/uploaded folder.
            $fileLocation = '../../content/uploaded/';
            
            $fileName = $fileLocation.str_replace(' ', '-', $TempTitle)."-".$pid."-".$sid.".html";
            //$bytes = file_put_contents('../../content/uploaded/test.txt', 'hello plenty of bytes to send.');
            $bytes = file_put_contents($fileName, $contents);
            //echo $bytes." Bytes sent to test.txt --";
            //record the location in the database.
            if($bytes>0){ updateTopicUrl($TempTitle, $pid, $sid); echo "success"; }else{ echo "Failed to upload."; }
        }
        exit(); //reached the end of this segment successfully upon entry, no need to continue.
    }
    
    $shouldReloadDraftInfo = filter_input(INPUT_POST,'reloadDraftRequest');
    if(!empty($shouldReloadDraftInfo))
    {
        $TempTitle = filter_input(INPUT_POST,'TITLE', FILTER_SANITIZE_SPECIAL_CHARS);
        $pid = filter_input(INPUT_POST,'PRIM', FILTER_SANITIZE_NUMBER_INT);
        $sid = filter_input(INPUT_POST,'SECONDARY', FILTER_SANITIZE_NUMBER_INT);
        
        if((empty($TempTitle)) || (empty($TempTitle)) || (empty($TempTitle)))
        {
            
        }
        else
        {
            ReloadDraftInfo($TempTitle, $pid, $sid);
        }
        
        exit();
    }
    
    $shouldUpdateDraftInfo = filter_input(INPUT_POST,'updateDraftRequest');
    if(!empty($shouldUpdateDraftInfo))
    {
        $TempTitle = filter_input(INPUT_POST,'TITLE', FILTER_SANITIZE_SPECIAL_CHARS);
        $drafted = filter_input(INPUT_POST,'CONTENTS');
        $pid = filter_input(INPUT_POST,'PRIM', FILTER_SANITIZE_NUMBER_INT);
        $sid = filter_input(INPUT_POST,'SECONDARY', FILTER_SANITIZE_NUMBER_INT);
        
        if((empty($TempTitle)) || (empty($TempTitle)) || (empty($TempTitle)) || (empty($drafted)))
        {
            echo "failed";
        }
        else
        {
            UpdateDraftInfo($TempTitle, $pid, $sid, $drafted);
        }
        
        exit();
    }
    
    $shouldIAddNewTopic = filter_input(INPUT_GET,'processNewTopic', FILTER_SANITIZE_SPECIAL_CHARS);
    if(!(empty($shouldIAddNewTopic)) && $shouldIAddNewTopic=="yes")
    {
        $TempTitle = filter_input(INPUT_GET,'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $pid = filter_input(INPUT_GET,'pid', FILTER_SANITIZE_NUMBER_INT);
        $sid = filter_input(INPUT_GET,'sid', FILTER_SANITIZE_NUMBER_INT);
        
        if((empty($TempTitle)) || (empty($TempTitle)) || (empty($TempTitle)))
        {
            echo "failed";
        }
        else
        {
            AddNewTopic($TempTitle, $pid, $sid);
        }
        
        exit();
    }
    if(!(empty($shouldIAddNewTopic)) && $shouldIAddNewTopic=="no"){ echo "success"; }
    
    $shouldIRemoveThisTopic = filter_input(INPUT_GET,'processRemovedTopic', FILTER_SANITIZE_SPECIAL_CHARS);
    if(!(empty($shouldIRemoveThisTopic)))
    {
        $TempTitle = filter_input(INPUT_GET,'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $pid = filter_input(INPUT_GET,'pid', FILTER_SANITIZE_NUMBER_INT);
        $sid = filter_input(INPUT_GET,'sid', FILTER_SANITIZE_NUMBER_INT);
        
        if((empty($TempTitle)) || (empty($TempTitle)) || (empty($TempTitle)))
        {
            echo "failed";
        }
        else
        {
            RemoveExistingTopic($TempTitle, $pid, $sid);
        }
        
        exit();
    }
    
    $updatePWID = filter_input(INPUT_GET, 'getPrimNameAndID', FILTER_SANITIZE_SPECIAL_CHARS);
    if(!empty($updatePWID)){
        ///echo "In:";
        
        $primaryCategoriesFromDBWithID = cms_find_all_major_withID('primarycategorydb');
        $generatePrimaryWithID = PhpArrayToJS2($primaryCategoriesFromDBWithID, 'primaryCategoriesWithID');
        echo $generatePrimaryWithID;
        
        exit();
    }
    
    $updateSWID = filter_input(INPUT_GET, 'getSubNameAndID', FILTER_SANITIZE_SPECIAL_CHARS);
    if(!empty($updateSWID)){
        ///echo "In:";
        
        $secondaryCategoriesFromDB_WITHID = cms_find_all_major_SK_withID();
        $rowCount = count($secondaryCategoriesFromDB_WITHID);
        ///echo ("alert('count $rowCount .'); ");
        $generateSecondariesWithID = PhpyArrayToJS_SCatObject($secondaryCategoriesFromDB_WITHID, 'secondaryCategoriesWithID');
        
        //fix: changed to return... as
        //echo.. will cause two sets of the same item to be displayed when updating the topics Editor GUI.
        return $generateSecondariesWithID;
        
        exit();
    }
    
    //trigger ajax request here.
    if(isset($_GET['pk'])){
       echo "Starting Attempt.";
       
       //echo "<br/>------------------------------------<br/>";
       //echo $_GET['pk'];
       //echo "<br/>------------------------------------<br/>";
       
       if(is_string($_GET['pk']))
       {
           $pk = filter_input(INPUT_GET, 'pk', FILTER_SANITIZE_SPECIAL_CHARS);
           echo "<br/>------------------------------------<br/>";
           echo $pk." is being checked now.";
           echo "<br/>------------------------------------<br/>";
           only_add_unique_values('primarycategorydb','name', $pk, 'primary');
           echo "Attempted TO Update The Database.";
       }
       if(is_array($_GET['pk']))
       {
           echo "<br/>------------------------------------<br/>";
           $notInListed = PhpArrayToNotIn(array_values($_GET['pk']));
           echo $notInListed;
           cms_remove_deleted('primarycategorydb',$notInListed);
           echo "<br/>------------------------------------<br/>";
           echo "Removing Left-Over topics now.";
       }
       if(empty($_GET['pk']))
       { 
       $notAlive = "array is unitialize?";      
       }
    }
    //end of ajax logic.
    //end of primary ajax sample.
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    //for secondary categories
    if(isset($_GET['sk'])){
       echo "Starting Attempt.";
       
       //echo "<br/>------------------------------------<br/>";
       //echo $_GET['pk'];
       //echo "<br/>------------------------------------<br/>";
       
       if(is_array($_GET['sk']))
       {
           $uniqueRun = filter_input(INPUT_GET, 'addunique', FILTER_SANITIZE_NUMBER_INT);
           $sk = filter_input(INPUT_GET, 'sk', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
           echo "<br/>------------------------------------<br/>";
           //echo print_r($_GET['sk']); //unsafe
           print_r($sk); //safe
           echo count($sk);
           echo " is being checked now";
           echo "<br/>------------------------------------<br/>";
           if($uniqueRun == 1){
               print_r($sk[0]);
               $scat = $sk[0];
               echo $scat;
               echo "<----key value---->";
               print_r($sk[1]);
               $sprim = $sk[1];
               echo $sprim;
               echo "<br/>";

               only_add_unique_values('secondarycategorydb','name', $scat, 'secondary', $sprim);
           }
           echo "Attempted TO Update The Database.";
           if($uniqueRun == 0)
               {
                        
                    echo "<br/>";
                    echo "<br/>------------------------------------<br/>";
                    //select secondarycatagorydb.id FROM sdb JOIN pdb where...? use a foreach for array?
                    $notInListed = cms_find_all_IDS_SK($_GET['sk']);
                    $notInListed = PhpArrayToNotInSK($notInListed);
                    echo $notInListed;
                    cms_remove_deleted_SK('secondarycategorydb',$notInListed);
                    echo "<br/>------------------------------------<br/>";
                    echo "Removing Left-Over topics now.";
               }
       }
    }
    //for topic creation
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
 ?>