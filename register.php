<?php
    
    /*
     * check to see that both passwords match before sending the request to the server
     * check to see that the username is unique.
     * otherwise reply with a reponse to use a different user name.
     * 
     * to do: add pattern matching. (for better security)
     */
?>
<?php
      $hash = null;
      $role = null;
      $name = null;
      if((empty($_POST['uname']) || empty($_POST['pword']) || empty($_POST['pword2']) || empty($_POST['rword']))){
          
      }
      else if(($_POST['pword']) != ($_POST['pword2'])){
          //send back a message that the passwords are not the same.
      }
      else
      {
          $name = filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_SPECIAL_CHARS);
          $pass = filter_input(INPUT_POST, 'pword', FILTER_SANITIZE_SPECIAL_CHARS);
          $pass2 = filter_input(INPUT_POST, 'rword', FILTER_SANITIZE_SPECIAL_CHARS);
          $hash = sha1($name.$pass);
          $hash2 = sha1($pass2.$name);
          //general registration. one of GMEA
          //modify the code here to allow administrators, to add users with any of these roles.
          //content creators can only create mediators.
          //and mediators can only remove/enable privileges for regular G users.
          $role = "A";
          include_once('./utilities/dbAuth.php');
          include_once('./utilities/addUser.php');
          
      }
?>
<style>
    body { font: normal 100%/1.5 "Segoe Media Center","Lucida Sans Unicode","Arial";  }
    .col0 { min-width:130px; display:inline-block; }
    input:first-child { min-width:200px; }
</style>
<h1>Registration</h1>
<p>Not currently a registered user but want to be? Simply enter your information below.</p>

        <form action='register.php' method='post'>
            
            <label>
                <span class="col0">User Name :</span>
            <input type='text' placeholder='username' name='uname'
                <?php if(isset($_POST['uname'])) { echo "value='".filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_SPECIAL_CHARS) ."' "; } ?>
                   required='required' maxlength="32"
            />
            <span><?php  if(empty($_POST['uname'])) { echo "!"; } ?></span>
            </label>
            
            <br/>
            
            <label>
                <span class="col0">Password :</span>
            <input type='password' placeholder='password' name='pword'
                <?php if(isset($_POST['pword'])) { echo "value='".filter_input(INPUT_POST, 'pword', FILTER_SANITIZE_SPECIAL_CHARS)."' "; } ?>
                   required='required'
            />
            <span><?php  if(empty($_POST['pword'])) { echo "!"; } ?></span>
            </label>
            
            <br/>
            
            <label>
                <span class="col0">Verify Password :</span>
            <input type='password' placeholder='password' name='pword2'
                <?php if(isset($_POST['pword2'])) { echo "value='".filter_input(INPUT_POST, 'pword2', FILTER_SANITIZE_SPECIAL_CHARS)."' "; } ?>
                    required='required'
            />
            <span><?php  if(empty($_POST['pword2'])) { echo "!"; } ?></span>
            </label>
            <br/>
            
            <p>Keep the following information in a safe place, should you forget your password you will be asked for this.</p>
            <label>
                <span class="col0">Reset Key :</span>
            <input type='text' placeholder='reset access key' name='rword'
                <?php if(isset($_POST['rword'])) { echo "value='".filter_input(INPUT_POST, 'rword', FILTER_SANITIZE_SPECIAL_CHARS)."' "; } ?>
                   required='required'
            />
            <span><?php  if(empty($_POST['rword'])) { echo "!"; } ?></span>
            </label>
            
            <br/>
            <br/>
            
            <hr/>
            <span class="col0">subscribe:</span>
            <input type='email' placeholder="nomail@gmail.com" name='mail'/>
            <input type='checkbox' name='sendMail'/>
            <hr/>
            
            <br/>
            
            <input type='submit' value="Register" />
        </form>
<a href="privacy.html">privacy policy</a>