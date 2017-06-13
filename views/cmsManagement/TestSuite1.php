<?php
    include_once('./utilities/sessionCRUD.php');
    sessionCRUD_startSession();
    
                    //set fron login.php.
                    //sessionCRUD_create('probationAccount', $results[1]);
                    //sessionCRUD_create('bannedAccount', $results[2]);

    $OnProbation = $_SESSION['probationAccount'];
    $IsBanned = $_SESSION['bannedAccount'];
    session_write_close();
    
    $debug = false;
    if($debug) { debug_print_backtrace(); }
    
    if($OnProbation == "1")
    {

    }
    if($IsBanned == "1")
    {

    }
    
?>

<?php if($OnProbation == "1") : ?>
    <h1>Welcome Back.</h1>
    <h2>Important! one or more actions have caused your account to be put on probation.</h2>
    <p><em>Contact {this mediator link} to resolve any issues.</em></p>
<?php endif; ?>
<?php if($IsBanned == "1") : ?>
    <h1>Critical Status</h1>
    <h3>Your account has been banned.</h3>
<?php endif; ?>
<?php if($OnProbation == "0" && $IsBanned == "0") : ?>
    <h1>Welcome Back</h1>
    <p>Not much to do right now.</p>
<?php endif; ?>



