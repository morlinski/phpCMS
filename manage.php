<?php

 include_once('./utilities/sessionCRUD.php');
 sessionCRUD_startSession();
 
 $TestSuite = -1; 
 // 0 not registered
 // 1 basic user
 // 2 mediator
 // 3 content creator
 // 4 full administrative privileges.
 // 5 full test suite
 
 //manage main user account.
 if( empty($_SESSION['activeAccount']) ) 
        { 
            //Dead Stop.
            exit;
        }
        else
        {        
          //put these into utilities cms cmsManagement.php
          //
          ////////////////////////////////////////////////
          //funtion testSuite()
          if($_SESSION['activeAccount'] == "ActiveUserTest"){
              $TestSuite = 5;
          }
          else if($_SESSION['activeAccount'] == "A"){
              $TestSuite = 4;
          }
          else if($_SESSION['activeAccount'] == "E"){
              $TestSuite = 3;
          }
          else if($_SESSION['activeAccount'] == "M"){
              $TestSuite = 2;
          }
          else if($_SESSION['activeAccount'] == "G"){
              $TestSuite = 1;
          }
          else {
              $TestSuite = 0;
          }
          //test and debug response.
          echo "<p style='visibility:hidden;'>";
          echo $_SESSION['activeAccount'];
          echo $TestSuite;
          echo "</p>";
          ////////////////////////////////////////////////
        }
        
  
         switch($TestSuite){
             case 1:
                 
                 session_write_close();
                 include('./views/cmsManagement/TestSuite1.php');
                 break;
             case 2:
                 include('./views/cmsManagement/TestSuite2.php');
                 break;
             case 3:
                 include('./views/cmsManagement/TestSuite3.php');
                 break;
             case 4: 
                 include('./views/cmsManagement/TestSuite4.php');
                 break;
             case 5: 
                 include('./views/cmsManagement/TestSuite5.php');
                 break;
         
             case 0:
             default: 
                 include('./views/cmsManagement/accessDenied.php');
         }
     
?>