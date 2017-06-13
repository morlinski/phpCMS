<div>
    <h2>Manage All Users</h2>
</div>
<div>
    Content Development
    <div class="preview">
        
    </div>
</div>
<div>
    Mediation
    <div class="preview">
        
    </div>
</div>
<div>
    Registered Users
    <div class="preview">
        
    </div>
</div>
<div>
    See Activity Logs
    <div class="preview">
        
    </div>
</div>
<div>
<?php
    echo getcwd();
    include('./utilities/dbAuth.php');
    global $db;
    $query = "SELECT uname, role, probation, banned FROM authorizedusers";
    $statement = $db->prepare($query);
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor();

 ?>
    <script>
        $(document).ready(function(){ alert('jQuery!--from manageAllUsers.php'); });
        function editThisUser(elem){
            var args = $(elem).parent().parent();
            //find the values for uname, urole, uprob, and uban for this object.
                alert(args);
                var uname = args.find('p[name="uname"]').text();
                var urole = args.find('input[name="urole"]').val();
                var uprob = args.find('input[name="uprob"]').is(':checked');
                var uban = args.find('input[name="uban"]').is(':checked');
                var submitData = { 'editname':uname, 'editrole':urole, 'editprobation':uprob, 'editban':uban };
                alert(uname+", "+urole+", "+uprob+", "+uban+"----from manageAllUsers.php editThisUser()!");
            //send relevant data as the 2nd paramater {'k':'v',...}
            $.get( './utilities/adminManageUsers.php',submitData ,function(data){alert(data);} );
        }
        function removeThisUser(elem){
            var args = $(elem).parent().parent();
            var uname = args.find('p[name="uname"]').text();
            var submitData = { 'editname':uname };
            $.get('./utilities/adminManageUsers.php',submitData,function(data){alert(data);});
            $(elem).parent().parent().remove();
        }
        function createNewUser(elem){
            var args = $(elem).parent().parent();
            //find the values for uname, urole, uprob, and uban for this object.
                var uname = args.find('input[name="uname"]').val();
                var urole = args.find('select[name="urole"]').find(':selected').val();
               
                var uprob = args.find('input[name="uprob"]').is(':checked');
                var uban = args.find('input[name="uban"]').is(':checked');
                alert(uname+", "+urole+", "+uprob+", "+uban+"----from manageAllUsers.php editThisUser()!");
            //send relevant data as the 2nd paramater {'k':'v',...}
            var submitData = { 'create':'+++', 'editname':uname, 'editrole':urole, 'editprobation':uprob, 'editban':uban };
            $.get( './utilities/adminManageUsers.php',submitData ,
                function(data){ 
                    alert(data);
                    
                    uprob = (uprob)?" checked ":"";
                    uban = (uban)?" checked ":"";
                    
                    var addUserToGUI = '<tr><td><p name="uname">'+uname+'</p></td><td><input name="urole" type="text" placeholder="" maxlength="1" value="'+urole+'"/></td><td><input name="uprob" type="checkbox" '+uprob+'/></td><td><input name="uban" type="checkbox" '+uban+'/></td><td><button onclick="editThisUser(this)">Edit</button></td><td><button onclick="removeThisUser(this)">X</button></td></tr>';
                    
                    $(addUserToGUI).insertBefore('#CreateNewUserGUI');
            } );
        }
        function clearFields(elem){
            //alert("clearFields for: "+$(elem).parent().parent().toArray().toString());
            var args = $(elem).parent().parent();
                var uname = args.find('input[name="uname"]').val('');
                var urole = args.find('select[name="urole"]').find(':selected').val();
               
                args.find('input[name="uprob"]').prop('checked',false);
                args.find('input[name="uban"]').prop('checked',false);
                //alert(uname+", "+urole+", "+uprob+", "+uban+"----from manageAllUsers.php editThisUser()!");
        }
    </script>
    <h3>Change Permissions.</h3>
    <div class="preview">
        <!--foreach user in the database but not this user.-->
        <table>
            <thead><tr><td>USERNAME</td><td>ROLE</td><td>PROBATION</td><td>BANNED</td> <td></td><td> </td></tr></thead>
            <tbody>
            <?php foreach($users as $user) :?>
                <tr>
                    <td><p name="uname"><?php echo $user[0]; ?></p></td>
                    <td><input name="urole" type="text" placeholder="" maxlength="1" value="<?php echo $user[1]; ?>"/></td>
                    <td><input name="uprob" type="checkbox" <?php if($user[2]>0){echo "checked";} ?>/></td>
                    <td><input name="uban" type="checkbox" <?php if($user[3]>0){echo "checked";} ?>/></td>
                    <td><button onclick="editThisUser(this)">Edit</button></td>
                    <td><button onclick="removeThisUser(this)">X</button></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr id="CreateNewUserGUI">
                    <td><input name="uname" type="text" placeholder="Username" maxlength="32"/></td>
                    <td>
                        <select name="urole">
                            <option value="G">General User(G)</option>
                            <option value="M">Content Mediator(M)</option>
                            <option value="E">Content Creator/Editor(E)</option>
                            <option value="A">Administrator(A)</option>
                        </select>
                    </td>
                    <td><input name="uprob" type="checkbox"/></td>
                    <td><input name="uban" type="checkbox"/></td>
                    <td><button onclick="createNewUser(this)">&nbsp;Add&nbsp;</button></td>
                    <td><button onclick="clearFields(this)">Reset</button></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>