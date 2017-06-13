<?php
    function PhpArrayToJS($a, $arrayName){
        //[name, ..]
        $debug = false;
        //add var when providing the argument to create a variable.
        //($myarray, 'var myname');
        //$completion = "var ${arrayName}=[";
        
        $completion = "${arrayName}=[";
        if(is_array($a) && count($a)>0){
            $innerParts = "";
            foreach($a as $key => $value){
                if($debug) echo $value[0];
                if($debug) echo "<br/>";
                $innerParts .= ("'".$value[0]."',");
            }
            $innerParts[strlen($innerParts)-1]=" ";
            $completion .= $innerParts;
        }
        return $completion .= "];";
    }
    
    function PhpArrayToJS2($a, $arrayName){
        //[[name,name], ..]
        $debug = false;
        //add var when providing the argument to create a variable.
        //($myarray, 'var myname');
        //$completion = "var ${arrayName}=[";
        $completion = "${arrayName}=[";
        if(is_array($a) && count($a)>0){
            $innerParts = "";
            foreach($a as $key => $value){

                $innerParts .= ("[ '".$value[1]."' , '".$value[0]."' ],");
            }
            $innerParts[strlen($innerParts)-1]=" ";
            $completion .= $innerParts;
        }
        return $completion .= "];";
    }
    
    function PhpArrayToNotIn($a){
        $completion = "(";
        $innerParts = "";
        foreach($a as $key => $value){
            echo $value;
            echo "<br/>";
            $innerParts .= ("'".$value."',");
        }
        $innerParts[strlen($innerParts)-1]=" ";
        $completion .= $innerParts;
        return $completion .= ")";
    }
    
    function PhpArrayToNotInSK($a){
     
        //cms_find_all_IDS_SK($arr) in cmsDatabaseManager.php.
        //
        //SELECT id FROM secondarycategorydb WHERE 
        //((secondarycategorydb.name = 'SubCat1') AND secondarycategorydb.primaryID = (select id from primarycategorydb where name = 'PrimaryDBTest0'))
        //OR
        //((secondarycategorydb.name = 'SubCat1') AND secondarycategorydb.primaryID = (select id from primarycategorydb where name = 'PrimaryDBTest0'))
        //;
        //exit();//Edit On.
        $completion = "(";
        $innerParts = "";
        foreach($a as $key => $value){
            //id is a number so no quotes are needed here.
            $innerParts .= ("".$value[0].",");
        }
        $innerParts[strlen($innerParts)-1]=" ";
        $completion .= $innerParts;
        return $completion .= ")";
    }
    
    function PhpyArrayToJS_SCatObject($arr, $jsvarname){
        $debug = false;
        $obj = "";
        //var secondaryCategoriesWithID = {'Pid1':[['skName','sid']..],'Pid2':[]...};
        ////var test = {"id":[[1,2],[1,2]],"name":[1,2,3,4]};
        //id,name,primaryID FROM secondarycategorydb

            foreach($arr as $k=>$v)
            {
                $tempID = $v[0];
                $tempName = $v[1];
                $tempPID = $v[2];
                
                $obj .= "if(typeof ${jsvarname}['${tempPID}'] === 'undefined'){ ${jsvarname}['${tempPID}']=[]; ${jsvarname}['${tempPID}'].push(['${tempID}','${tempName}']); }else{ ${jsvarname}['${tempPID}'].push(['${tempID}','${tempName}']); }";
            }
        
        if($debug) echo $obj;
        return $obj;
    }
?>