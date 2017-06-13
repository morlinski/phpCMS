 <?php
        include_once('./utilities/cms/management/TopicsEditor.php');
        $TempTitle = filter_input(INPUT_GET, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $TempPID = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_NUMBER_INT);
        $TempSID = filter_input(INPUT_GET, 'sid', FILTER_SANITIZE_NUMBER_INT);
        
        $hasContent = "true";
        if(empty($TempPID) || empty($TempSID))
        {
            echo "<h1>Oops, you've reached a dead end.</h1><h3>Contact an administrator for assistance, and supply the error code 9999.</h3><h3><a href='http://localhost/PhpProject2B/index.php'>HOME</a></h3>";
            exit();
        }
        if(empty($TempTitle)){
            $TempTitle = "SAMPLE!";
            $hasContent = "false";
            $Data = new TopicsEditor($TempTitle);
        }
        else 
        {
            $hasContent = "false";
            $Data = new TopicsEditor($TempTitle);
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Topics Website Editor (<?php echo $TempTitle; ?>)</title>
  <link href="style.css" rel="stylesheet">
  <link href="topicEditor.css" rel="stylesheet">
  <meta name="viewport" content="width = device-width, initial-scale = 1.0" >
  <script>
      var initialized = false;
      var collectTopicElements = {};
      var rootTitleCounter = <?php echo $Data->titleCounter; ?>;
  </script>
</head>
<body>
    
    <div class="fixedTopInline">
        <h1><?php echo "Prototype"?></h1>
        <p><?php echo "Your company logo 'and feature quote.'."?></p>
    </div>

    <div id="TopicsMainEditor">
        <hr/>
            <p>
                <input type="checkbox"/> GENERATE TABLE OF CONTENTS
                <span class="rightSidedControl">
                    <label><input type="radio" name="pageOrPostType" value="page"/> Article</label>
                    <label><input type="radio" name="pageOrPostType" value="post"/> Critical Update, News Feed</label>
                </span>
            </p>
        <hr/>
        <div id="TopicsWrapper">
            <?php 
             echo ($Data->isNew())? $Data->printRootControl() : "..";
            ?>
        </div>
    </div>
    
    <div id="topicStatusMessage">
        <?php echo $Data->getMessage(); ?>
        <input onclick="reloadRawData()" type="button" value="Reload" class="Xlarge50Right"/>
        <input onclick="saveRawData()" type="button" value="Save Current Draft" class="large50"/>
        <input onclick="uploadCleanedHTML()" type="button" value="Upload Changes To Active Page" class="large50"/>     
    </div>
    
    <script src="scripts/jquery-3.1.0.min.js" type="text/javascript"></script>
    <script src="scripts/scripts.js" type="text/javascript"></script>
    <script src="scripts/topicEditor.js" type="text/javascript"></script>
    <script>
        var hasContent = <?php echo $hasContent?>;
        var head = "<?php echo $TempTitle; ?>";
        var pid = "<?php echo $TempPID; ?>";
        var sid = "<?php echo $TempSID; ?>";
        
        function submitAndPrintRootChildControls(elem)
        { 
            var debug = false;
            //update the GUI.
            var editedTitle = $(elem).parent().find('input[type=text]').val();
            $(elem).parent().find("h2 span").text(editedTitle);
            //submit changes.
            var checkID = $(elem).parent().attr('id');
                if(debug) alert(checkID); //should be TP###.  
            checkID = checkID.substr(2);
                if(debug) alert(checkID);
                if(debug) alert(collectTopicElements[checkID]);
             if(collectTopicElements[checkID])
             {
                 
             }
             else
             {
                 collectTopicElements[checkID] = "todo:set item later.";
                 var root = $(elem).parent();
                 
                root.find('div:first-of-type').css('display', 'block');   
                rootTitleCounter += 1;
                    //$(elem).parent().attr('id', ("TP"+rootTitleCounter));
                 root.after("<?php $Data->printRootControl(); ?>");
                 root.next().attr('id', ("TP"+rootTitleCounter));
                    
             }
            
        };
        
    </script>
    <footer>
        <hr/>
        most recent Critical Update, News Feeds by category listed here
    </footer>
    <style>
        
    </style>
</body>
</html>
