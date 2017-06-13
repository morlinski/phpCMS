<style>
    label { margin:10px;padding:10px; display:block;}
    input { margin-left:12px; }
    body { font: normal 100%/1.5 "Segoe Media Center","Lucida Sans Unicode","Arial";  }
</style>
<h1>Oops</h1>
<p>Having difficulties accessing your account?</p>
<p>Simply provide your username and reset key here, to change your current password.</p>
    <div>
        <form name="resetAccountPassword" method="post" action="resetAccount.php">
            <label>User Name: <input type="text" name="username"/></label>
            <label>Reset Key: <input type="text" name="resetkey"/></label>
        </form>
    </div>
    <p>
        <strong>
        If you think your account has been compromised, it's strongly suggested that you review your activity logs.
        <br/>
        Then send a message to the administrator after regaining access.
        </strong>
    </p>
