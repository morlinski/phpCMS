  <footer>
    <!--theme 1 prototype-->
    <!--include copyright and department newsletters here-->
    
    <!--temporary solution-->
    <div><script>document.write("&copy; "+new Date().getFullYear());</script></div>
  </footer>
    <script src="scripts/jquery-3.1.0.min.js" type="text/javascript"></script>
    <script src="scripts/scripts.js" type="text/javascript"></script>
    <script>
                
                $(document).ready( function () {
                $("#googleSearch").on('keyup', function (e) {
                    if (e.keyCode == 13) {
                        var url = "https://www.google.ca/#q=site:www.google.ca "+$(this).val();
                        url.replace(" ","+");
                        
                        //reset.
                        $(this).val('');
                        
                        var win = window.open(url, "_blank");
                        win.focus();
                    }
                });
                }
                );

            </script>
</body>
</html>