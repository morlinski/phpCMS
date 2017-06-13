<?php
            //reset
            $asideNav = null;
            $topNav = null;
            $file = "roberthalf.txt";
            //retrieve
            $asideNav = filter_input(INPUT_POST, 'contents'); // aside nav
            $topNav = filter_input(INPUT_POST, 'content'); //top nav 
            //the action.
            function writeToFile($file, $data) { 
                $bytes = file_put_contents($file, $data);
                if($bytes > 0)
                {
                 echo "success";   
                }
                else { echo "failure"; }
            }
            
            if($asideNav){ $file="rightNavigation.txt"; writeToFile($file, $asideNav ); exit(); }
            if($topNav){ $file="topNavigation.txt"; writeToFile($file, $topNav ); exit(); }
            
            Echo "<h1>You've wonderered enough past the beaten path, it's time to go back now.</h1>";
?>