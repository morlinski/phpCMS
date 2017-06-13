<?php 
    include_once('./utilities/cms/management/cmsDatabaseManager.php');
    include_once('./utilities/phpJSConversions.php');
    $GatherTopics = cms_find_all_major_Topics();

    $primaryCategoriesFromDBWithID = cms_find_all_major_withID('primarycategorydb');
    $generatePrimaryWithID = PhpArrayToJS2($primaryCategoriesFromDBWithID, 'primaryCategoriesWithID');
    $generateSecondariesWithID = PhpyArrayToJS_SCatObject($secondaryCategoriesFromDB_WITHID, 'secondaryCategoriesWithID');
?>
<script>
    var allTopicsByCat = {};
    function runThis(){
        console.warn("run all topics generated from the db on initialization.");
       <?php echo $GatherTopics; ?>
    }
    $(document).ready(function(){ 
        var debug=false;
        //var allTopicsByCat = null;
        //var gatheredTopics = '<?php echo $GatherTopics; ?>';
        //eval(gatheredTopics);
        runThis();
        if(debug)alert("ALL TOPICS--"+allTopicsByCat);
        console.info("are you ready for this");
        console.info(allTopicsByCat);
        console.info("................................");
        
        eval("<?php echo $generatePrimaryWithID; ?>");
        updateNameAndID_PRIMCATLIST_run();
        if(debug)alert("TOPICS EDITOR ON READY--->"+"<?php echo $generateSecondariesWithID; ?>");
        if(debug)alert("DOES secondaryCategoriesWithID exist? "+secondaryCategoriesWithID);
        //eval("?php echo $generateSecondariesWithID; ?");
        console.log(secondaryCategoriesWithID);
        updateNameAndID_SUBCATLIST_run();
        
        $('#InputTopicTitle').show();
        $('#ShowTopicControls').hide();
        
    });
    function updateNameAndID_PRIMCATLIST_run(){
        var debug=false;
        if(debug)alert("TopicsEditor updateNameAndID_PRIMCATLIST_run");
        //return;
        
        //js array -- primaryCategoriesWithID
        //select elem name -- updateNameAndIDPRIMCATLIST
        
      var selector = "select[name='updateNameAndIDPRIMCATLIST']";
        if(debug)alert("running updateNameAndIDPRIMCATLIST_run() -- from topicsEditor.php");
        if(debug)alert("Found "+$(selector).toArray()+" length: "+$(selector).toArray().length);
      var selectionList = $(selector);
      //clear options from the select list.
        if(debug)alert(selectionList.find('option:not(:first-of-type)').length);
        selectionList.find('option:not(:first-of-type)').remove();
      //update the primary categories to reflect the updated changes.
        for(var i=0; i < primaryCategoriesWithID.length; i++)
        {
            if(debug)alert(primaryCategoriesWithID[i][0]+","+primaryCategoriesWithID[i][1]);
            selectionList.append("<option value='"+primaryCategoriesWithID[i][1]+"'>"+primaryCategoriesWithID[i][0]+"</option>");
        }
    }
    function updateNameAndID_PRIMCATLIST_run_ajax(){
    console.log("IN : updateNameAndID_PRIMCATLIST_run_ajax");
    var debug = false;
        $.get("./views/cmsManagement/cmsAJAXRequests.php",{'getPrimNameAndID':'yes'},function(data){
 
            if(debug)alert("DONE : !"+data);
            primaryCategoriesWithID = [];
            eval("var tester='show me'");
            //DO NOT USE '"', data , '"' with quotes.
            //it is returned as a string already and will not update the array otherwise.
            eval(data);
            console.log(tester);
            console.log('"'+data+'"');
            console.log(typeof(data));
            //eval("primaryCategoriesWithID=[[ 'PrimaryDBTest0OOO' , '1' ],[ 'PrimaryDBTest3OOO' , '4' ] ];");
            if(debug)alert("CHECK RESULT : "+primaryCategoriesWithID);

            //js array -- primaryCategoriesWithID
            //select elem name -- updateNameAndIDPRIMCATLIST

          var selector = "select[name='updateNameAndIDPRIMCATLIST']";
            if(debug)alert("Found "+$(selector).toArray()+" length: "+$(selector).toArray().length);
          var selectionList = $(selector);
          //clear options from the select list.
            selectionList.find('option:not(:first-of-type)').remove();
          //update the primary categories to reflect the updated changes.
            for(var i=0; i < primaryCategoriesWithID.length; i++)
            {
                if(debug)alert(primaryCategoriesWithID[i][0]+","+primaryCategoriesWithID[i][1]);
                selectionList.append("<option value='"+primaryCategoriesWithID[i][1]+"'>"+primaryCategoriesWithID[i][0]+"</option>");
            }
    });
    }
    function updateNameAndID_SUBCATLIST_run(){
  
        alert("TopicsEditor updateNameAndID_SUBCATLIST_run");
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
    function loadRelevantSubjects(elem){
        var debug = false;
        //and the select list to update based on this change.
        var selectionList = $("[name='updateNameAndIDSUBCATLIST']");
        
        if(debug)alert($(elem).find(":selected").val());
        var primaryIndex = $(elem).find(":selected").val();
        
        $("[name='updateNameAndIDSUBCATLIST']").find('option:not(:first-of-type)').remove();
        if(typeof secondaryCategoriesWithID[primaryIndex] === 'undefined')
        {
            //do not continue to process an array if an array cannot be found
            //within the object.
            return;
        }
        var subjectsForThisPID = secondaryCategoriesWithID[primaryIndex];
        
        console.log(typeof(subjectsForThisPID));
        console.log(subjectsForThisPID);
        
        
        for(var i=0; i < subjectsForThisPID.length; i++)
        {
            //alert(subjectsForThisPID.length);
            if(debug)alert(subjectsForThisPID[i][0]+","+subjectsForThisPID[i][1]);
            selectionList.append("<option value='"+subjectsForThisPID[i][0]+"'>"+subjectsForThisPID[i][1]+"</option>");
        }
    }
    function UpdateTopicsUI(elem){
        console.warn("updating topics editor.");
        var selection = $(elem).find(':selected').val();
        if(selection=="NEWTOPIC")
        {
            $('#InputTopicTitle').show();
            $('#ShowTopicControls').hide();
        }
        else 
        {
            $('#InputTopicTitle').hide();
            $('#ShowTopicControls').show();
        }
    }
</script>
<div>
    <h2>Topics</h2>
    <p class="intro">
            Create drafts and upload content for the selected items,
            
    </p>
    <div class="preview">
        <!--Repeat the above for topics with primary and secondary category selectors.
        Edit/Remove Topic GUI then provided in the form of opening in a new window. (With Save Draft, vs upload buttons).
        -->
        <select id="P" name="updateNameAndIDPRIMCATLIST" onchange="loadRelevantSubjects(this)">
            <option value="">select primary category</option>
        </select>
        <script>
            function loadRelevantSubTopics(){
                var debug = false;
                var tmpPID = $("#P").find(":selected").val();
                var tmpSID = $("#S").find(":selected").val();            
                
                if(tmpPID != "" || tmpPID != null || tmpSID != "" || tmpSID != null)
                {
                    $("#T").find('option:not(:first-of-type)').remove();
                    var selectionList = $("#T");
                    
                    var uniqueID = tmpPID+"-"+tmpSID;
                    if(debug)alert(uniqueID);
                    var tmpItems = allTopicsByCat[uniqueID];
                    if(debug)alert(tmpItems);
                    if(typeof(tmpItems)!=='undefined')
                    {
                        for(var i = 0; i < tmpItems.length; i++)
                        {
                            console.info("appending "+tmpItems[i]+" to topics list.");
                            selectionList.append("<option value='"+tmpItems[i]+"'>"+tmpItems[i]+"</option>");
                        }
                    }
                    else { alert("There are no topics currently in these combined categories."); }
                }
            }
        </script>
        <select id="S" name="updateNameAndIDSUBCATLIST" onchange="loadRelevantSubTopics()">
            <option value="">select secondary category</option>
        </select>
        <select id="T" onchange="UpdateTopicsUI(this)">
            <option value="NEWTOPIC">create new topic</option>
            <option value="Sample">Sample</option>
        </select>
        <div id="InputTopicTitle">
            <input type="text" name="topicTitle" placeholder="Your Topic Title"/>
            <hr/>
            <input type="button" value="Submit" onclick="startTopicEditor()"/>
        </div>
        <script>
            function removeTopicNow()
            {
                var titleName = $("#T").find(":selected").val();
                var primaryCat = $("#P").find(":selected").val();
                var secondaryCat = $("#S").find(":selected").val();
                
                if(primaryCat=="" || secondaryCat=="" || primaryCat==null || secondaryCat==null)
                {
                    return;
                }
                
                $.get("./views/cmsManagement/cmsAJAXRequests.php",
                        {'processRemovedTopic':'yes', 'title':titleName, 'pid':primaryCat, 'sid':secondaryCat},
                        function(newdata){
                            if(newdata == "success")
                            {
                                var index = allTopicsByCat[(primaryCat+"-"+secondaryCat)].indexOf(titleName);
                                if(index > -1){ allTopicsByCat[(primaryCat+"-"+secondaryCat)].splice(index,1); }
                                
                                $("#T").find("option[value='"+titleName+"']").remove();
                                $('#InputTopicTitle').show();
                                $('#ShowTopicControls').hide();
                                
                                console.warn("All topics in regards to "+titleName+" for the specified categories have been completely removed from the database, thankyou.");
                            }
                            else
                            { 
                                alert("An error has occurred, sorry.");
                                console.error("Could not remove topic entry , please contact the adminstrator with error code 8899."); 
                            }
                        });
            }
            function startTopicEditor(forNewTopic=true)
            {
                openTopicEditor(forNewTopic);
            }
            function addNewDBTopic(titleName, pIndex, sIndex, initialize)
            {
                var debug = false;
                console.log(initialize + " check for topic db creation...requirements ");
                $.get("./views/cmsManagement/cmsAJAXRequests.php",
                        {'processNewTopic':initialize, 'title':titleName, 'pid':pIndex, 'sid':sIndex},
                        function(newdata){
                            if(debug)alert(newdata);
                            if(newdata == "success")
                            {
                                //needed to prevent and undefined error with this particular unique identifier.
                                if(typeof(allTopicsByCat[(pIndex+"-"+sIndex)])==='undefined')
                                { allTopicsByCat[(pIndex+"-"+sIndex)] = []; }
                                
                                allTopicsByCat[(pIndex+"-"+sIndex)].push(titleName);
                                $("#T").append("<option value='"+titleName+"'>"+titleName+"</option>");
                                
                                var win = window.open(('topicEditor.php?title='+titleName+'&pid='+pIndex+'&sid='+sIndex),'_blank');
                                win.focus();
                            }
                            else
                            { 
                                if(debug)alert(newdata);
                                if(initialize=="yes"){console.error("Could not submit topic entry , please contact the adminstrator with error code 8888."); }
                            }
                        });
            }
            function openTopicEditor(forNewTopic)
            {
                var needsInit;
                var title
                        if(forNewTopic)
                        {title = $("#InputTopicTitle").find('input:first-of-type').val();needsInit="yes";}
                        else
                        { title=$("#T").find(":selected").val(); needsInit="no";}
                var primaryCat = $("#P").find(":selected").val();
                var secondaryCat = $("#S").find(":selected").val();
                
                if(primaryCat=="" || secondaryCat=="" || primaryCat==null || secondaryCat==null)
                {
                    alert("Could not continue with your request, a valid primary AND secondary category needs to be chosen.");
                    return;
                }
                alert(title+" -- "+primaryCat+" -- "+secondaryCat+" --- "+needsInit+" .");
                
                addNewDBTopic(title, primaryCat, secondaryCat, needsInit);
                
            }
        </script>
        <div id="ShowTopicControls">
            <hr/>
            <input type="button" value="Edit" onclick="startTopicEditor(false)"/>
            <input type="button" value="Delete" onclick="removeTopicNow()"/>
        </div>
        <hr/>
        <!--<input type="button" value="Refresh"/>-->
    </div>
</div>