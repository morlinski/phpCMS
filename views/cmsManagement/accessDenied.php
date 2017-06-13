<?php

   //Access To Restricted Information is deanied.
   //Send users actions to log...?
   echo "Suspicious activiity has been detected.";
   //Destroy...
   sessionCRUD_destroyALLSessionData();
   
   
?>