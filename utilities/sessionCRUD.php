<?php

    function sessionCRUD_startSession(){
        //Start session management with a persistent cookie, 5 days.
        $lifetime = 60 * 60 * 24 * 5;
        session_set_cookie_params($lifetime, '/');
        session_start();
    }
    
    function sessionCRUD_destroyALLSessionData(){
        //stop the session.
        $_SESSION = array();
        session_destroy();
        //clear the cookie on the browser.
        $params = session_get_cookie_params();
        setcookie(session_name(), '', strtotime('-1 year'), $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    
    //create session cookie.
    function sessionCRUD_create($sessionKey, $val){
        $_SESSION[$sessionKey] = $val;
        //session_write_close();
    }
    //delete session cookie.
?>