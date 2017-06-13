<div class="asideS">
    <!--test-->
    <div class="Categories">
        <a href="home.html" target="activeContent">Home</a>
        <?php
            if(is_file('./content/uploaded/topNavigation.txt')) { $topNav = file('./content/uploaded/topNavigation.txt'); } else { $topNav = []; }
            if(count($topNav) > 0){
            foreach($topNav as $nav){
                echo $nav;
            }}
            else
            {
                echo "<span>Site Navigation</span>";
            }
        ?>
        <a href="seeAllUserGeneratedContent.php" target="activeContent">CMS Uploads</a>
        <!--could also be products or services for the primary topic-->
        <!--<span>About</span>-->
        <a href="about.html" target="activeContent">About</a>
    </div>
  </div>
  <div id="aside" class="asideML">
    <ul>
        <!--<li>search bar</li>-->
        <li>
            <label><input type="text" id="googleSearch" placeholder="SEARCH"/><img src="./images/searchicon.png" width="20" height="20"></label>
            <!--<script>
                
                $(document).ready( function () {
                $("#googleSearch").on('keyup', function (e) {
                    if (e.keyCode == 13) {
                        var url = "https://www.google.ca/#q=site:www.google.ca"+$(this).val();
                        url.replace(" ","+");
                        var win = window.open(url, "_blank");
                        win.focus();
                    }
                });
                }
                );

            </script>-->
        </li>
        <li><a href="home.html" target="activeContent">Home</a></li>
        
        <ul><em>
                <li><?php echo $asideLogin; ?></li>
                <?php echo $manageAccount; ?>
            </em></ul>
                <li><a href="seeAllUserGeneratedContent.php" target="activeContent">CMS Uploads</a></li>
                <li><a href="about.html" target="activeContent">About</a></li>

        <!--generated navigation menu here-->
    </ul>
    <hr/>
      <?php
      if(is_file('./content/uploaded/rightNavigation.txt')){
            $topNav = file('./content/uploaded/rightNavigation.txt');
      }else { $topNav = []; }
            if(count($topNav) > 0){
            foreach($topNav as $nav){
                echo $nav;
            }}
            else
            {
                echo "<span>Site Navigation</span>";
            }
        ?>
    <hr/>
  </div>