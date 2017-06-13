<?php

    include_once('./utilities/sessionCRUD.php');
    sessionCRUD_startSession();
    sessionCRUD_destroyALLSessionData();
    
    
    //redirect back to the main page.
    header('Location: ./index.php');
    exit;
?>

