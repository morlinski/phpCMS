<?php
    $debug = false;
    $showPRIMCATSinGUI = false;
    if($showPRIMCATSinGUI){
        echo "Show primary categories for select box from primeEditor.php<br/>";
        print_r($primaryCategoriesFromDB);
        echo "<br/><br/>Show secondary categories that are already included in the db.<br/>";
        print_r($secondaryCategoriesFromDB);
        echo "<br/>";
    }
    //for each value in the array create and appeand to the echoed options string.
    $echoedOptions = "";
    foreach($primaryCategoriesFromDB as $k)
    {
        /*Sample Array ( 
            [0] => Array ( [name] => PrimaryDBTest0 [0] => PrimaryDBTest0 ) 
            [1] => Array ( [name] => PrimaryDBTest3 [0] => PrimaryDBTest3 ) 
            [2] => Array ( [name] => Test2 [0] => Test2 ) 
            [3] => Array ( [name] => Test1 [0] => Test1 )
        )*/
        
          if($debug) echo $k[0]."<br/>"; 
          $echoedOptions .= "<option value='${k[0]}'>${k[0]}</option>";
        
    }
    $UIlistedSubcategories = "";
    foreach($secondaryCategoriesFromDB as $key => $value)
    {
        if($debug){
            
            echo "<br/>key:";
            print_r($key);
            echo " value: ";
            echo "${value[1]} , ${value[0]}";
            echo "<br/>";
            echo "<h3><span style='margin-right:12px;'>in:( ".$value[0]." )</span>".$value[1]."<button onclick='removeSubCat(this, \"X\", \"".$value[0]."\", \"".$value[1]."\")'>X</button></h3>";
           
        }
        //echo "<h3>".$value[0]."<button onclick='removePrimCat(this,\"X\")'>X</button></h3>";//FROM primeEditor sample.
        //Desired Result For subcategories.
        //in:(primaryname) subcategory X
        $UIlistedSubcategories .= ("<h3><span style='margin-right:12px;'>in:( ".$value[0]." )</span>".$value[1]."<button onclick='removeSubCat(this, \"X\", \"".$value[0]."\", \"".$value[1]."\")'>X</button></h3>");
                       
     }
      
     //FULL UI DISPLAY and other MISC
     if($debug){ 
        // echo "<br/>"; echo $UIlistedSubcategories;
        echo PhpArrayToJS2($secondaryCategoriesFromDB, 'secondaryCategories');
     }
     $generateSecondaries = PhpArrayToJS2($secondaryCategoriesFromDB, 'secondaryCategories');
     
    //TODO: change any primary select tags to reflect changes made to the database in/from primeEditor.php.
?>
<script>
    
    $(document).ready(function(){
        <?php
         //populate the js array secondaryCategories.
         echo "eval(\"${generateSecondaries}\");";
         //show the result.
         echo "alert(secondaryCategories);";
        ?>
    });
    
    function AddSubCat(newItem, pID, appendedTo, emptyElemMessage){
        var forPID = $(pID).val();
        var checkedSubCat = $(newItem).val();
        
        //Todo: check for unique categories.
        if(tryAddTempSecondaryToList(secondaryCategories, checkedSubCat, forPID)){}else return;//quit early.
        
        if(checkedSubCat != ""){
            //Enable fadeout when primary categories has been fully tested.
            $(emptyElemMessage).fadeOut('slow');
            $(appendedTo).append("<h3><span style='margin-right:12px;'>in:( "+forPID+" )</span>"+checkedSubCat+"<button onclick='removeSubCat(this, \"X\", \""+forPID+"\", \""+checkedSubCat+"\")'>X</button></h3>");
            //store this value into an array before saving to the DB.
            //on committing these changes modify aside.php accordingling. ?directly modifying the file or dynamic retrieval from the DB.
        }
        
    }
    
    function tryAddTempSecondaryToList(checkArray, currentValue, forPrimary){
        if(currentValue == "" || forPrimary == "uncategorized") return;
        
        var OK = true;
        for(var i=0; i<checkArray.length; i++){
            if(checkArray[i][0] == currentValue && checkArray[i][1] == forPrimary) { OK = false; return; }
        }
        
        if( OK )
        {
            checkArray.push([currentValue,forPrimary]);
        }
        else 
        {
            //Do Nothing.
            //unreachable statement while return is in the for loop above.
            alert("This category already exists.");
        }
        
        <?php if($debug) echo 'alert(checkArray+" ....."+OK);'; ?>
        return OK;
    }
    
    function removeSubCat(elem, removeEnd, inPrime, inSub)
    {
        <?php if($debug) echo 'alert(elem+" --- "+inPrime+" --- "+inSub);'; ?>
        for(var i = 0; i < secondaryCategories.length; i++)
        {
            if(secondaryCategories[i][0] == inSub && secondaryCategories[i][1] == inPrime){ 
                //found the item, now remove the item.
                //from the array.
                secondaryCategories.splice(i,1);
                //from the GUI Editor.
                $(elem).parent().remove();
                <?php if($debug) echo 'alert(secondaryCategories.toString());'; ?>
            }
        }
    }
    
    function updateNamedOnlyPRIMCATLIST_run(){
  
      var selector = "select[name='updateNamedOnlyPRIMCATLIST']";
        console.log("running updateNamedOnlyPRIMCATLIST_run() -- from secEditor.php");
        console.info("Found "+$(selector).toArray()+" length: "+$(selector).toArray().length);
      var selectionList = $(selector);
      //clear options from the select list.
        console.info(selectionList.find('option:not(:first-of-type)').length);
        selectionList.find('option:not(:first-of-type)').remove();
      //update the primary categories to reflect the updated changes.
        for(var i=0; i < primaryCategories.length; i++)
        {
            selectionList.append("<option value='"+primaryCategories[i]+"'>"+primaryCategories[i]+"</option>");
        }
    }
    
     function updateNamedOnlyPRIMCATLIST_runOLD(){
  
      var selector = "select[name='updateNameAndIDPRIMCATLIST']";
        console.log("running updateNamedOnlyPRIMCATLIST_run() -- from secEditor.php");
        console.info("Found "+$(selector).toArray()+" length: "+$(selector).toArray().length);
      var selectionList = $(selector);
      //clear options from the select list.
        //php has not added the items dynamically to the options list.
        //if shown as Select Primary Category.
        //alert(selectionList.find('option').text());
        selectionList.toggle();
      //update the list of options available.
      
        //var myOptions = {
        //val1 : 'text1',
        //val2 : 'text2'
        //};
        //var mySelect = $('#mySelect');
        //$.each(myOptions, function(val, text) {
        //    mySelect.append(
        //        $('<option></option>').val(val).html(text)
        //    );
        //});
        
        

//$('#mySelect')
//    .find('option')
//    .remove()
//    .end()
//    .append('<option value="whatever">text</option>')
//    .val('whatever')
//;


    }
</script>

<!--<div>
    Secondary Categories
    <div class="preview">
        
    </div>
</div>-->

<div>
    <h2>Secondary Categories</h2>
    <p class="intro">
            Select from a list of primary topics to include sub-genres,
            <br/>
            Custom Clothing Designs, Forms & Documents, Bait...
            <br/>
            
    </p>
    <br/>
    <span class="inlineInputs">
        <!--add primary categories here also from above section-->
        <select size="1" class="activePrimCatList" id="coAddPIDCategory" name="updateNamedOnlyPRIMCATLIST">
            <option value="uncategorized" selected="selected">Select A Primary Category</option>
            <?php echo $echoedOptions; ?>
        </select>
        <input type="text" id="coAddSubCategory" placeholder="Products">
        <button onclick="AddSubCat('#coAddSubCategory','#coAddPIDCategory','#coSubList','#noSubCats')">+</button>
    </span><br>
    <br/>
    <div class="preview">
        <p id="testSecondaryFunctionality"></p>
        <p id="noSubCats">
            <?php if(count($primaryCategoriesFromDB)<1) echo "There are currently no sub-categories recorded."; ?>
        </p>
        <div id="coSubList">

                <?php echo $UIlistedSubcategories ?>

        </div>
        <input type="button" value="Update Database" onclick="changeItems('ActiveSecondaryCategories')">
    </div>
</div>