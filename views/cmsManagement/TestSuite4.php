<?php
    include_once('./utilities/cms/management/cmsDatabaseManager.php');
    include_once('./utilities/phpJSConversions.php');
    $GatherTopics = cms_find_all_major_Topics();

    $primaryCategoriesFromDBWithID = cms_find_all_major_withID('primarycategorydb');
    $generatePrimaryWithID = PhpArrayToJS2($primaryCategoriesFromDBWithID, 'primaryCategoriesWithID');
    $secondaryCategoriesFromDB_WITHID = cms_find_all_major_SK_withID();
    $generateSecondariesWithID = PhpyArrayToJS_SCatObject($secondaryCategoriesFromDB_WITHID, 'secondaryCategoriesWithID');
?>

<link href="style.css" rel="stylesheet" type="text/css"/>
<style>body { background-color:white }</style>
<script src="./scripts/jquery-3.1.0.min.js" type="text/javascript"></script>

<!--add to external style sheet and script-->
<style>
    .current { margin-left:4px; }
    .intro { margin-left:8px; }
    .preview { margin-left:8px; border:2px solid black; }
    .hero-content { position:unset; }
    input { width:100%; text-align:center; }
    .CommitAllContent { font-size:1.4em; height:2em; }
    .inlineInputs { margin-left:8px; width:100%; }
    .inlineInputs input[type="checkbox"] { height:18px; width:20px; background-color:black; }
    .inlineInputs input[type="text"] { padding-left:12px; height:3em; width:60%; background-color:lightgray; text-align:left; border-radius:10px; }
     button { font-size:1.1em; }
     #coPrimList { text-align:center; }
</style>
<script>
    var primaryCategories = null;
    var primaryCategoriesWithID = null;
    var secondaryCategories = [];
    var secondaryCategoriesWithID = {};
    var allTopicsByCat = {};
        //secondaryCategories = [['offlinetestscat1','uncategorized'], ['offlinetestscat2','uncategorized']];
    function changePreview(targeted, newValue){
        $(targeted).text(newValue);
    }
    function removePrimCat(elem, removeEnd){
        var val = $(elem).parent().text();
        val = val.slice(0, (val.length - removeEnd.length));
        //incase the array has been tampered with... check to see if the index exists.
        var index = primaryCategories.indexOf(val);
        console.log(val+" -- "+index);

        if(index != -1)
        {  
            primaryCategories.splice(index, 1);
            console.info(primaryCategories);
        }
        
        $(elem).parent().remove();
    }
    function AddPrimCat(newItem, appendedTo, emptyElemMessage){
        var checkedPrimCat = $(newItem).val();
        
        //Todo: check for unique categories.
        if(tryAddTempPrimaryToList(primaryCategories, checkedPrimCat)){}else return;//quit early.
        
        if(checkedPrimCat != ""){
            //Enable fadeout when primary categories has been fully tested.
            $(emptyElemMessage).fadeOut('slow');
            $(appendedTo).append("<h3>"+checkedPrimCat+"<button onclick='removePrimCat(this, \"X\")'>X</button></h3>");
            //store this value into an array before saving to the DB.
            //on committing these changes modify aside.php accordingling. ?directly modifying the file or dynamic retrieval from the DB.
        }
        
    }
    
    //FIXES FOR MISSING FUNCTIONS.
    function updateNameAndID_PRIMCATLIST_run_ajax(){
    console.log("IN : updateNameAndID_PRIMCATLIST_run_ajax");
        $.get("./views/cmsManagement/cmsAJAXRequests.php",{'getPrimNameAndID':'yes'},function(data){
 
            console.info("DONE : !"+data);
            primaryCategoriesWithID = [];
            eval("var tester='show me'");
            //DO NOT USE '"', data , '"' with quotes.
            //it is returned as a string already and will not update the array otherwise.
            eval(data);
            console.log(tester);
            console.log('"'+data+'"');
            console.log(typeof(data));
            //eval("primaryCategoriesWithID=[[ 'PrimaryDBTest0OOO' , '1' ],[ 'PrimaryDBTest3OOO' , '4' ] ];");
            console.info("CHECK RESULT : "+primaryCategoriesWithID);

            //js array -- primaryCategoriesWithID
            //select elem name -- updateNameAndIDPRIMCATLIST

          var selector = "select[name='updateNameAndIDPRIMCATLIST']";
            console.info("Found "+$(selector).toArray()+" length: "+$(selector).toArray().length);
          var selectionList = $(selector);
          //clear options from the select list.
            selectionList.find('option:not(:first-of-type)').remove();
          //update the primary categories to reflect the updated changes.
            for(var i=0; i < primaryCategoriesWithID.length; i++)
            {
                console.info(primaryCategoriesWithID[i][0]+","+primaryCategoriesWithID[i][1]);
                selectionList.append("<option value='"+primaryCategoriesWithID[i][1]+"'>"+primaryCategoriesWithID[i][0]+"</option>");
            }
    });
    }
    function updateNameAndID_SUBCATLIST_run_ajax(){
                //var secondaryCategoriesWithID = {};
                //$secondaryCategoriesFromDB_WITHID = cms_find_all_major_SK_withID();
                //$generateSecondariesWithID = PhpyArrayToJS_SCatObject($secondaryCategoriesFromDB_WITHID, 'secondaryCategoriesWithID');
                //eval("<?php /*echo $generateSecondariesWithID;*/ ?>");
        $.get("./views/cmsManagement/cmsAJAXRequests.php",{'getSubNameAndID':'yes'},function(newdata){
            
            console.log(typeof(newdata));
            console.log("DONE updateNameAndID_SUBCATLIST_run_ajax : !"+newdata);
            
            secondaryCategoriesWithID = {};
            
            console.log("BEFORE UPDATING . : ");
            console.log(secondaryCategoriesWithID);
            eval(newdata);
 
            console.log("AFTER UPDATING . : ");
            console.log(secondaryCategoriesWithID);
            
            console.log("<?php echo $generateSecondariesWithID; ?>");
            
            //eval("primaryCategoriesWithID=[[ 'PrimaryDBTest0OOO' , '1' ],[ 'PrimaryDBTest3OOO' , '4' ] ];");
            
            console.log("CHECK RESULT : "+secondaryCategoriesWithID);

            //js array -- primaryCategoriesWithID
            //select elem name -- updateNameAndIDPRIMCATLIST

          var selector = "select[name='updateNameAndIDPRIMCATLIST']";
            console.info("Found "+$(selector).toArray()+" length: "+$(selector).toArray().length);
          var selectionList = $(selector);
          //clear options from the select list.
            selectionList.find('option:not(:first-of-type)').remove();
          //update the primary categories to reflect the updated changes.
            for(var i=0; i < primaryCategoriesWithID.length; i++)
            {
                console.info(primaryCategoriesWithID[i][0]+","+primaryCategoriesWithID[i][1]);
                selectionList.append("<option value='"+primaryCategoriesWithID[i][1]+"'>"+primaryCategoriesWithID[i][0]+"</option>");
            }
    });
    }
    $(document).ready(function(){ 
        
        //runThis();
        
        eval("<?php echo $GatherTopics; ?>");
        eval("<?php echo $generatePrimaryWithID; ?>");
        //updateNameAndID_PRIMCATLIST_run();

        eval("<?php echo $generateSecondariesWithID; ?>");
        //updateNameAndID_SUBCATLIST_run();
        
        //$('#InputTopicTitle').show();
        //$('#ShowTopicControls').hide();
        
        //Check These for upadating sitemenus.
        console.info("Previewing cms Data:");
        console.info(allTopicsByCat);
        console.info(primaryCategoriesWithID);
        console.info(secondaryCategoriesWithID);
        
    });
    //END OF FIXES FOR MISSING FUNCTIONS.
</script>
<h1>(Administrative Manager)</h1>
<p><em>Welcome, as an administrative user you are allowed to create the necessary categories available to other users, generate an updated navigation menu, and alter the permission of an users.<br/><br/>You are also allowed to change the company's highlight image, brief, and an informative about page as needed.</em><hr/><p>
<?php
    include('heroImageEditor.php');
    include('companyNameEditor.php');
    include('companyBriefEditor.php');
    include('companyProfileEditor.php');
?>
<!--visual spacing here-->
<br/>
<hr/>
<br/>
<!----------------------->
<?php
    include('primeEditor.php');
?>
<!--temp space-->
<br/>
<hr/>
<br/>
<!--end temp space-->
<?php
    include('secEditor.php');
?>
<br/>
<br/>

<?php
    include('manageAllUsers.php');
?>

<input class="CommitAllContent" type="button" value="Done - Upload." onclick='generateSiteNavigationMenus()'>
<?php 
    echo $GatherTopics; 
    echo "<hr/>";
    echo $generatePrimaryWithID; 
    echo "<hr/>";
    echo $generateSecondariesWithID;

?>
<script>
    function generateSiteNavigationMenus()
    {
        console.warn("not saved!");
        var finalAside = "";
        var finalTopMenu = "";
        console.info(allTopicsByCat);
        //console.info(primaryCategoriesWithID);
        //console.info(secondaryCategoriesWithID);
        //
        primaryCategoriesWithID.forEach(function(item, index){
            console.info("generateSiteNavigationMenus item..");
            console.info(item);
            console.info(index);
            console.info("for primary category array.");
            var primTitle = item[0];
            var primID = item[1];
            
             finalAside += ("<ul><li>"+primTitle+"</li>");
            
            var secTitle = null;
            var secID = null;
            var availableSubCategories = secondaryCategoriesWithID[primID];
            if(typeof(availableSubCategories) !== 'undefined'){
                finalAside += ("<ul>");
            for(var i = 0; i < availableSubCategories.length; i++)
            {
                secID = availableSubCategories[i][0];
                secTitle = availableSubCategories[i][1];
                    finalAside += ("<li>"+secTitle+"</li>");
                console.log("Has This subcategory,");
                console.log(secTitle);
                console.log(secID);
                console.log("........................");
                    var combo = primID + "-" + secID;
                    var availableTopics = allTopicsByCat[combo];
                    if(typeof(availableTopics)!=='undefined'){
                        finalAside += "<ul>";
                        for(var j = 0; j < availableTopics.length; j++)
                        {
                            finalAside += ("<li><a href='./content/uploaded/"+(availableTopics[j].replace(/ /g,'-'))+"-"+combo+".html' target='activeContent'>"+availableTopics[j]+"</a></li>");
                        }
                        finalAside += "</ul>";
                    }else { console.warn("no TOPIC content for this combination is present"); }
            }finalAside += ("</ul>");} else { console.warn("no SUBCATEGORY content for this combination is present"); }
            finalAside += "</ul>";
        });
        alert(finalAside);
        var done = 0;
        ////////////////////////////////////////////
        finalTopMenu = ("<nav class='dropDownNavigation'><ul><li>Site Map</li></ul>"+finalAside+"</nav>");
        $.post(
                "./content/uploaded/fileGenerator.php", 
                {'contents':finalAside},
                function(data){
                    if(data.length > 10){console.info(data);}  //show any return error messages.
                    if(data=="success"){
                        console.info("saved!");
                        done++;//alert("saved!");
                    }
                    else{alert("Oops, please try again.");}
            });
        $.post(
                "./content/uploaded/fileGenerator.php", 
                {'content':finalTopMenu},
                function(data){
                    if(data.length > 10){console.info(data);}  //show any return error messages.
                    if(data=="success"){
                        console.info("saved!");
                        done++;
                        if(done == 2){ alert("saved!"); }
                    }
                    else{alert("Oops, please try again.");}
            });
        
    }
</script>
