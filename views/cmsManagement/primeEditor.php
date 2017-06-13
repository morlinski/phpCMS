<?php
    
    include_once('./utilities/cms/management/cmsDatabaseManager.php');
    include_once('./utilities/phpJSConversions.php');
    
    //populate some dummy information here.
    //only_add_unique_values('primarycategorydb','name', 'PrimaryDBTest0', 'primary');
    //only_add_unique_values('primarycategorydb','name', 'PrimaryDBTest1', 'primary');
    //only_add_unique_values('primarycategorydb','name', 'PrimaryDBTest2', 'primary');
    
    //find and list all primary topics from the database.
    $primaryCategoriesFromDB = cms_find_all_major('primarycategorydb','name');
    $secondaryCategoriesFromDB = cms_find_all_major_SK('secondarycategorydb','name');
    $secondaryCategoriesFromDB_WITHID = cms_find_all_major_SK_withID();
    
    
    //test the array.
    $debug = false;
    
    if($debug){ 
        echo ("DEBUGGIN primeEditor.php <br/>");
        //print_r($primaryCategoriesFromDB);
        echo "Number of PrimCats : ";
        echo count($primaryCategoriesFromDB);
        echo "<br/>";
        echo "Number of SecCats : ";
        echo count($secondaryCategoriesFromDB);
        echo "<br/>pcat results->";
        foreach($primaryCategoriesFromDB as $key => $value){
            print_r($value); //Array ( [name] => PrimaryDBTest0 [0] => PrimaryDBTest0 )
            echo $value[0]; //PrimaryDBTest0
        }
        echo "<br/>";
        echo PhpArrayToJS($primaryCategoriesFromDB, 'primaryCategories');
    }
    $generatePrimary = PhpArrayToJS($primaryCategoriesFromDB, 'primaryCategories');
    
    
?>

<!--Important Notes-->
<!--
    When updating the database use jQuery AJAX post methods.
-->

<script>
    $(document).ready(function(){
        //place variable primaryCategories in TestSuiteN.php to prevent scoping issues.
        //not defined <-- issues fix.
            //var primaryCategories = null;
            console.log("wow from PrimeEditor.php");
        //eval("var t = [10,11,12];");
        eval("<?php echo $generatePrimary; ?>");
        
        console.error(primaryCategories);
    });
    function tryAddTempPrimaryToList(checkArray, currentValue){
        if(currentValue == "") return;
        //initial test.
        //var currentValue = $('#coAddPrimaryCategory').val();
        
        var OK = true;
        for(var i=0; i<checkArray.length; i++){
            if(checkArray[i] == currentValue) { OK = false; return; }
        }
        
        if( OK )
        {
            checkArray.push(currentValue);
        }
        else 
        {
            //Do Nothing.
            //unreachable statement while return is in the for loop above.
            alert("This category already exists.");
        }
        
        console.log(checkArray+" "+OK);
        return OK;
    }
    function tryAddTempToList(){}
    
    //move this to a more generalized location.
    function changeItems(targetDb){
        //ajax call to cms database here.
        //select sql statements where name == the array items to find those that already exist.
        //place these in an nochanges array.
        //select sql statement where names != items in the array.
        //place these in an array for removal later on since they should not exist.
        //
        //for each item in the main array only keep track if it is not already in the nochanges array.
        //uses with only_add_unique_values('primarycategorydb','name', 'PrimaryDBTest2', 'primary');
        
        //or run the only_add_unique_values('primarycategorydb','name', 'PrimaryDBTest2', 'primary'); with the array
        //then run
        //remove items from table where name is not in this full list.
        //DELETE FROM TABLENAME WHERE NAME NOT IN (VL1, VL2);
        
        //ajax.
        switch(targetDb){
            case "ActivePrimaryCategories": 

                console.error("checking primary categories from changeItems in primeEditor.php");
                console.error(primaryCategories);
                for(var i=0; i<primaryCategories.length; i++){
                    //Adding unique names to the database here.
                    //alert(primaryCategories[i]);
                    var data = {"pk":primaryCategories[i]}; 
                    
                    //shows the values in an alert box before continuing
                    //allows you to see any debugging information above the UI.
                    console.info(data['pk']);
                    
                    //./utilities/cms/management/cmsDatabaseManager.php was previously in.
                    //is currently in relation to index.php
                    $.get("./views/cmsManagement/cmsAJAXRequests.php",data,
                        function(output){
                            <?php if($debug) echo "$('#testPrimaryFunctionality').html(output);" ?>
                            //alert("success");
                        
                    });
                }
                //call to remove name not included in this list.
                //data = {"pk":primaryCategories}; 
                //alert(primaryCategories);
                if(primaryCategories.length < 1){ primaryCategories[0] = "Empty"; alert("Empty arrays will cause problems!"); }
                $.get("./views/cmsManagement/cmsAJAXRequests.php",{"pk":primaryCategories},
                        function(output){
                            alert("Removing Items Now see console?");
                            console.error("Removing Items Now?");
                            console.error(primaryCategories);
                            <?php if($debug) echo "$('#testPrimaryFunctionality').html(output);" ?>
                            <?php 
                               //Find all primary categories and their accompying ids.
                               $primaryCategoriesFromDBWithID = cms_find_all_major_withID('primarycategorydb');
                               //Since it contains two items in each row reuse this conversion method.
                               $generatePrimaryWithID = PhpArrayToJS2($primaryCategoriesFromDBWithID, 'primaryCategoriesWithID');
                                 //echo "alert(\"TESTING PID WITH NAME:".$generatePrimaryWithID."\");";
                                 echo ('eval("'.$generatePrimaryWithID.'");');
                                 echo 'alert("TESTING PID WITH NAME:"+primaryCategoriesWithID);';
                      
                            ?>
                            
                            updateNameAndID_PRIMCATLIST_run_ajax();
                            //updateNameAndID_SUBCATLIST_run();
                            
                            //now find all updateNameAndIDPRIMCATLIST elements in the DOM
                            //empty and replace the options with the items in the array.
                            //FOUND IN secEditor.php
                            updateNamedOnlyPRIMCATLIST_run();
                            
                            alert("Success, your database is now up to date.");
                            
                        
                        }//,//datatype.
                        );
                        if(primaryCategories[0] == "Empty"){ primaryCategories = []; }
                
                break;
            case "ActiveSecondaryCategories": 
                
                for(var i=0; i<secondaryCategories.length; i++){
                    //Adding unique names to the database here.
                    //alert(primaryCategories[i]);
                    var data = {"sk":secondaryCategories[i],"addunique":1}; 
                    
                    //shows the values in an alert box before continuing
                    //allows you to see any debugging information above the UI.
                    console.info(data['sk']);
                   
                    
                    //./utilities/cms/management/cmsDatabaseManager.php was previously in.
                    //is currently in relation to index.php
                    $.get("./views/cmsManagement/cmsAJAXRequests.php",data,
                        function(output){
                            <?php if($debug) echo "$('#testSecondaryFunctionality').html(output);" ?>
                            //alert("success");
                        
                    });
                }
                //call to remove name not included in this list.
                if(secondaryCategories.length < 1){ secondaryCategories[0]=["Empty", "0"]; alert("Empty arrays will cause problems!"); }
                console.error("Checking secondary category array.");
                console.error(secondaryCategories);
                data = {"sk":secondaryCategories,"addunique":0}; 
                $.get("./views/cmsManagement/cmsAJAXRequests.php",data,
                        function(output){
                            <?php if($debug) echo "$('#testSecondaryFunctionality').html(output);" ?>
                              
                            updateNameAndID_SUBCATLIST_run_ajax();
                              
                            alert("Success, your database is now up to date.");
                            
                            
                    
                        }//,//datatype.
                        );
                        if(secondCategories[0][0] == "Empty"){ screenCategories = []; }
                
                break;
            case "ActiveTopics": 
                break;
            default:
                break;
        }
    }
</script>

<div>
    <h2>Primary Categories</h2>
    <p class="intro">
            Include a variety of generalized topics,
            <br/>
            Products & Services, Accounting, Finance, Sports, Fishing...
            <br/>
            
                
    </p>
    <br/>
    <span class="inlineInputs"><input type="text" id="coAddPrimaryCategory" placeholder="Products"><button onclick="AddPrimCat('#coAddPrimaryCategory','#coPrimList','#noPrimCats')">+</button></span><br>
    <br/>
    <div class="preview">
        <p id="testPrimaryFunctionality"></p>
        <p id="noPrimCats">
            <?php
                if(count($primaryCategoriesFromDB)<1) echo "There are currently no primary categories recorded.";
            ?>
        </p>
        <div id="coPrimList">
            <?php
                foreach($primaryCategoriesFromDB as $key => $value){
                    //echo "<h3>".$value[0]."<button onclick='removePrimCat(this)'>X</button></h3>";//OLD
                    echo "<h3>".$value[0]."<button onclick='removePrimCat(this,\"X\")'>X</button></h3>";//NEW
                    //echo $value[0]; //PrimaryDBTest0
                }
            ?>
        </div>
        <input type="button" value="Update Database" onclick="changeItems('ActivePrimaryCategories')">
    </div>
</div>