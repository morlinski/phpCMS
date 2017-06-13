<?php 
    include_once('./utilities/sessionCRUD.php');
    sessionCRUD_startSession();
    
    $loggedIn = false;
    
    if( empty($_SESSION['activeAccount']) ) 
    { 

    }
    else
    {
        $loggedIn = true;
        //check for admin, content creators, mediators, and registered user.
        if( empty($_SESSION['detectChanges']) ) 
        { 
            //$_SESSION['detectChanged'] = array();
        }
    }
    
    if($loggedIn)
    {
        $logginMessage = "<a href=\"logout.php\" id=\"hero-login\">Logout</a>";
    }
    else
    {
        $logginMessage = "<div id=\"hero-login\"><form action='login.php' method='post'><input type='text' placeholder='username' name='username'/><input type='password' placeholder='password' name='password'/><input type='submit' value=\"Sign In\" /><br/><a href=\"register.php\" id=\"register\" target=\"activeContent\">Register</a><a href=\"forgotten.php\" id=\"forgotPassword\" target=\"activeContent\">Forgot password?</a></form></div>";
        //"<a href=\"login.php\" id=\"hero-login\" target=\"activeContent\">login</a>";
    }
    $asideLogin = ($loggedIn)?"<a href=\"logout.php\">logout</a>":"<a href=\"#\">login</a>";
    $manageAccount = ($loggedIn)?"<li><a href=\"manage.php\" target=\"activeContent\">manage account</a></li>":"";
    $heroManageAcount = ($loggedIn)?"<a href=\"manage.php\" id=\"hero-login-gear\" target=\"activeContent\">Manage Account</a>":"";
    
    session_write_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Corporate Website</title>
  <link href="style.css" rel="stylesheet">

  <meta name="viewport" content="width = device-width, initial-scale = 1.0" >
  <!--add a scroll to content capability to make this transition less sudden-->
  <!--reduce font size for hero on small devices-->
</head>

<body>
  <header>
  <div class="hero">
    <!--<a href="#" id="hero-login">gearIcon login/logout</a>-->
    
    <!--<div id="hero-login">
        <form action='login.php' method='post'>
            <input type='text' placeholder='username'/>
            <input type='password' placeholder='password'/>
            <input type='submit' value="Sign In" />
            <br/>
            <a href="#" id="forgotPassword">Forgot password?</a>
        </form>
    </div>-->
    
    <?php echo $heroManageAcount; echo $logginMessage; ?>
    
    <img src="images/BannerImage2.png" alt="" />
    <div class="hero-content">
      <h1>Prototype</h1>
      <p>Your company logo <q>and feature quote.</q>.</p>
      <a href="#content">down</a>
    </div>
  </div>
  </header>