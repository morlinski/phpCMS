<?php
/*
 * To Do: retrieve an array of all categories, subcategories.
 * To Do: seperate each major div into it's own php file.
 */
    

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
        //secondaryCategories = [['offlinetestscat1','uncategorized'], ['offlinetestscat2','uncategorized']];
    function changePreview(targeted, newValue){
        $(targeted).text(newValue);
    }
    function removePrimCat(elem, removeEnd){
        var val = $(elem).parent().text();
        val = val.slice(0, (val.length - removeEnd.length));
        //incase the array has been tampered with... check to see if the index exists.
        var index = primaryCategories.indexOf(val);
        alert(val+" -- "+index);

        if(index != -1)
        {  
            primaryCategories.splice(index, 1);
            alert(primaryCategories);
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
    //subcategory Functionality.
    //move removecat.. here?
</script>
<h1>(Administration -- Full Debugging Test Suite)</h1>
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
    include('topicsEditor.php');
?>
<!--temp space-->
<br/>
<hr/>
<br/>
<!--end temp space-->

<?php
    include('manageAllUsers.php');
?>

<input class="CommitAllContent" type="button" value="Done - Upload." onclick='function(){alert("yes!");}'>
<script>
    function generateSiteNavigationMenus()
    {
        alert("not saved!");
        <?php
            
            function writeToFile($file, $data) { file_put_contents($file, $data); }

            writeToFile('roberthalf.txt', 'hello'); 
            
        ?>
        alert("saved!");
    }
</script>
