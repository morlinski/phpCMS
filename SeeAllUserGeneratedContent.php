<!DOCTYPE html>
<html>
    <head>
        <title>Corporate Website</title>
        <style>
            body { font: normal 100%/1.5 "Segoe Media Center","Lucida Sans Unicode","Arial";  }
            a { text-decoration: none; color:black; }
            a:hover { font-weight:bolder; }
        </style>
    </head>
    <body>
        <h1>All CMS Uploads</h1>
        <?php
            $debug = false;
            $path = getcwd();
            if($debug) { echo "<div>$path</div>"; }
            $items = scandir("./content/uploaded");
            $files = array();
            if(count($items)<0)
                { 
                    echo "<em>There are currently no uploaded submissions available.</em>"; 
                    echo "<div><a href='./index.php'>BACK</a></div>";
                }
            foreach($items as $item)
            {
                echo "<a href='./content/uploaded/$item' target='_blank'>$item</a><br/>";
            }
        ?>
    </body>
</html>