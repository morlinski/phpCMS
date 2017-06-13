
        $(document).ready(function(){
            initialized = true;
            alert("Let's Begin!");
            if(hasContent){
                //$('#TopicsWrapper').append("<p>has content.</p>");
            }else{ 

            }
            
        });
        
        function addCMSElement(elem, type)
        {
            var basicTest = false;

            switch(type)
            {
                case 0: 
                    if(basicTest){
                        //alert(0); 
                        $(elem).parent().remove(); 
                        $(elem).parent().before("<h1>test0</h1>");
                    }
                    else
                    {
                        $(elem).parent().before(createParagraphElement());
                    }
                    break;
                case 1: 
                    if(basicTest){
                        //alert(1); 
                        $(elem).parent().remove(); 
                        $(elem).parent().before("<h1>test1</h1>");
                    }
                    else
                    {
                        $(elem).parent().before(createImageElement());
                    }
                    break;
                case 2: 
                    if(basicTest){
                        //alert(2); 
                        $(elem).parent().remove(); 
                        $(elem).parent().before("<h1>test2</h1>");
                    }
                    else
                    {
                        $(elem).parent().before(createVideoElement());
                    }
                    break;
                case 3: 
                    if(basicTest){
                        //alert(3); 
                        $(elem).parent().remove(); 
                        $(elem).parent().before("<h1>test3</h1>");
                    }
                    else
                    {
                        $(elem).parent().before(createSubtitleElement());
                    }
                    break;
            }
        }
        function createParagraphElement(provideText = null)
        {
            //provideText = provideText | null;
            if(provideText==null)
            {
              return "<span class='takeAll' onclick='removeCMSElement(this,0)'>X Remove</span><p onclick='EnterEditor(this,0)'>Click On Me To Edit.</p>";
            }
            else
            {
                return "<span class='takeAll' onclick='removeCMSElement(this,0)'>X Remove</span><p onclick='EnterEditor(this,0)'>"+provideText+"</p>";
            }
        }
        function createSubtitleElement(provideText = null)
        {
            //provideText = provideText | null;
            if(provideText==null)
            {
              return "<span class='takeAll' onclick='removeCMSElement(this,3)'>X Remove</span><h3 onclick='EnterEditor(this,3)'>Click Me To Edit Subtitle.</h3>";
            }
            else
            {
                return "<span class='takeAll' onclick='removeCMSElement(this,3)'>X Remove</span><h3 onclick='EnterEditor(this,3)'>"+provideText+"</h3>";
            }
        }
        function createImageElement(sourceURL = null)
        {
            //sourceURL = sourceURL | null;
            //select from a images folder on the server.
            if(sourceURL==null)
            {
              return "<img ondrag='removeCMSElement(this,2)' style='display:inline-block; margin:2px; background-color:lightblue; border-radius:4%;' onclick='EnterEditor(this,1)' src='' alt='Empty No Image' width='100' height='100'/>";
            }
            else
            {
                return "<img ondrag='removeCMSElement(this,2)' style='display:inline-block; margin:2px; background-color:lightblue; border-radius:4%;' onclick='EnterEditor(this,1)' src='"+sourceURL+"' alt='Needs Future Accessibilty Informational Input' width='100' height='100'/>";
            }
        }
        function createVideoElement(provideText=null)
        {
            //provideText = provideText | null;
            if(provideText==null)
            {
              return "<span class='takeAll' onclick='removeCMSElement(this,1)'>X Remove</span><div onclick='EnterEditor(this,2)' style='min-height:4em; margin:4%; background-color:rgba(100,100,100,0.35); width:77%;'>Click To Add Feature Youtube Video.</div>";
            }
            else
            {
                return "<span class='takeAll' onclick='removeCMSElement(this,1)'>X Remove</span><div onclick='EnterEditor(this,2)' style='min-height:4em; margin:4%; background-color:rgba(100,100,100,0.35); width:77%;'>"+provideText+"</div>";
            }
        }
        function EnterEditor(elem, type)
        {
            switch(type)
            {
                case 0:
                    var currentValue = $(elem).text();
                    
                    currentValue = (currentValue=="Click On Me To Edit.")?'':currentValue;
                    
                    console.log($(elem).next()[0].toString()=="[object HTMLTextAreaElement]");
                    if($(elem).next()[0].toString()!="[object HTMLTextAreaElement]") 
                    {
                        $(elem).after("<textarea placeholder='Type To Edit Paragraph, Double-Click to return to the preview.' style='width:85%; height:12rem;' ondblclick='ExitEditor(this,0)'>"+currentValue+"</textarea>")
                    }
                    else 
                    {
                        $(elem).next().show();
                    }
                    $(elem).hide();
                    break;
                    
                case 1:   
                    var currentValue = $(elem).attr("src");
                      //alert($(elem).toArray().toString());
                      //alert($(elem).attr("src"));
                      console.log("http://localhost/PhpProject2B/images/dino.jpg -- want to check me out.");
                    console.log($(elem).next()[0].toString()=="[object HTMLTextAreaElement]");
                    if($(elem).next()[0].toString()!="[object HTMLTextAreaElement]") 
                    {
                        $(elem).after("<textarea placeholder='Copy and paste the url of the desired image here, then double-click to return to the preview.' style='width:85%; height:1.4rem;' ondblclick='ExitEditor(this,1)'>"+currentValue+"</textarea>");
                    }
                    else 
                    {
                        $(elem).next().show();
                    }
                    $(elem).hide();
                    break;
                    
                case 2:
                    var currentValue = $(elem).text();
                    
                    currentValue = (currentValue=="")?'Oops, no content provided.':currentValue;
                    
                    console.log($(elem).next()[0].toString()=="[object HTMLTextAreaElement]");
                    if($(elem).next()[0].toString()!="[object HTMLTextAreaElement]") 
                    {
                        $(elem).after("<textarea placeholder='Insert video from youtube, Double-Click to return to the preview.' style='width:85%; height:12rem;' ondblclick='ExitEditor(this,2)'>"+currentValue+"</textarea>")
                    }
                    else 
                    {
                        $(elem).next().show();
                    }
                    $(elem).hide();
                    break;
                   
                case 3:
                    var currentValue = $(elem).text();
                    
                    currentValue = (currentValue=="Click Me To Edit Subtitle.")?'':currentValue;
                    
                    console.log($(elem).next()[0].toString()=="[object HTMLTextAreaElement]");
                    if($(elem).next()[0].toString()!="[object HTMLTextAreaElement]") 
                    {
                        $(elem).after("<textarea placeholder='Type the desired subtitle, double-click to return to the preview.' style='width:85%; height:1.4rem;' ondblclick='ExitEditor(this,3)'>"+currentValue+"</textarea>")
                    }
                    else 
                    {
                        $(elem).next().show();
                    }
                    $(elem).hide();
                    break;
            }
        }
        function ExitEditor(elem,type)
        {
            switch(type)
            {
                case 0:
                case 2:
                case 3:
                    var currentValue = $(elem).val();
                    
                    currentValue = (currentValue=="" || currentValue==null)? "Oops, please enter some info.":currentValue;
                    
                    if(type!=2){$(elem).prev().text(currentValue);}
                    else { $(elem).prev().html(currentValue); /*alert("Thank You Youtube!");*/ } //creat an embeded youtube video
                    
                    $(elem).prev().show();
                    //$(elem).after(createParagraphElement(currentValue));
                    $(elem).hide();
                    break;
                case 1:
                    var currentValue = $(elem).val();
                    $(elem).prev().attr("src", currentValue);
                    $(elem).prev().show();
                    //$(elem).after(createParagraphElement(currentValue));
                    $(elem).hide();
                    break;
            }
        }
        function removeCMSElement(elem, type)
        {
          switch(type)
          {
              case 1:
                  $(elem).next().remove();
                  $(elem).remove();
                  break;
              case 2:
                  $(elem).next('textarea').remove();
                  break;
              case 0:
              case 3:
                  //alert("yo");
                  $(elem).next('p,h3').remove();
                  $(elem).next('textarea').remove();
                  break;
          }  
          $(elem).remove();
        }
        //<input onclick="reloadRawData()" type="button" value="Reload" class="Xlarge50Right"/>
        //<input onclick="saveRawData()" type="button" value="Save Current Draft" class="large50"/>
        //<input onclick="uploadCleanedHTML()" type="button" value="Upload Changes To Active Page" class="large50"/>
        var debug = true;
        function uploadCleanedHTML()
        {
            //$('#TopicsWrapper').find('*').length;
            
            //var cleanedHTML = $('#TopicsWrapper').find(':not(input, textarea, .AuxilaryControl, .takeAll)');
            //var cleanedHTML = $('#TopicsWrapper').find(':not(input, textarea, button, script, .takeAll, .AuxilaryControl, .AuxilaryControl>*:first-of-type)');
            var cleanedHTML = $('#TopicsWrapper div *:not(input, .titleBox, textarea, button, script, html, head, footer, header, aside, .takeAll, .AuxilaryControl, .AuxilaryControl>*:first-of-type, div:last-of-type)');
            var cleanedHTMLAsString = "";
 
            cleanedHTML.each(function(){
                //var debug = true;
                if(debug)
                {   
                    //uncomment this alert to see a step by step manipultion of the DOM.
                    //highlighting all selected elements.
 
                    //alert($(this).toArray().toString());
                    var color = '6px solid rgb('+(Math.floor(Math.random()*200)+45)+','+(Math.floor(Math.random()*200)+45)+','+0+')';
                    $(this).css('border', color);
                    $(this).css('margin','9px');
                }
                console.log(jQuery(this).prop("tagName").toLowerCase());
                console.log(jQuery(this).prop("attributes"));
                //process each elements tag, innerhtml, and attributes.
                var tagName = (jQuery(this).prop("tagName").toLowerCase());
                var tagAttributes = (jQuery(this).prop("attributes"));

                var processedAttributes = "";
                    for(var i = 0; i < tagAttributes.length; i++)
                    {
                        //alert(tagAttributes[i]);
                        console.info(tagAttributes[i]);
                        console.info(tagAttributes[i].nodeName);
                        //console.info(tagAttributes[i].nodeValue);
                        console.info("Okay now using value:"+tagAttributes[i].value);
                        
                        processedAttributes += tagAttributes[i].nodeName;
                        processedAttributes += ('="'+tagAttributes[i].value+'"');
                    }
                    //alert(tagName);
                    if(tagName != "img")
                    {
                        cleanedHTMLAsString += ("<"+tagName+" "+processedAttributes+">"+jQuery(this).html()+"</"+tagName+">");
                    }
                    else if(tagName == "input"){/*omit the stubborn title input*/} //NEVERMIND, was the double selection of h2 and inner span.
                    else 
                    {
                        cleanedHTMLAsString += ("<"+tagName+" "+processedAttributes+"/>");
                    }
                    });
                    var headContents = "<title>"+head+"</title><link href=\"style.css\" rel=\"stylesheet\"><meta name=\"viewport\" content=\"width = device-width, initial-scale = 1.0\" >";
                    cleanedHTMLAsString = "<!DOCTYPE html><head>"+headContents+"</head><body>" + cleanedHTMLAsString + "</body></html>";
            
            if(debug){
                alert(cleanedHTML.html()); //!!!only retrieves the first matched elements html contents.!!!
                alert(cleanedHTMLAsString);
            }
            saveFinalDraft(cleanedHTMLAsString);
        }
        function saveFinalDraft(cleanedHTML = "")
        {
            //cleanedHTML = cleanedHTML | "";
            $.post(
                    './views/cmsManagement/cmsAJAXRequests.php',
                    {'TITLE':head, 'PRIM':pid, 'SECONDARY':sid, 'saveToURL':"yesPlease", 'cleanHTML':cleanedHTML},
                    function(data)
                    {
                        if(debug){console.log(data);}
                        if(data == "success"){
                            alert("Your content has been uploaded to the server, TODO: update recentnely added entries below.");
                        }
                        else { console.error("Upload Unsuccessfull go to topicEditor.php -- saveFinalDraft."); }
                    }
            );
        }
        function reloadRawData()
        {
            $.post(
                    './views/cmsManagement/cmsAJAXRequests.php',
                    {'reloadDraftRequest':'yes','PRIM':pid, 'SECONDARY':sid, 'TITLE':head},
                    function(data){
                        
 
                        //alert(rootTitleCounter+" Before");
                        $('#TopicsWrapper').html(data);
                        rootTitleCounter = ($('#TopicsWrapper > div').length)-1;
                        for(var i=0; i <= (rootTitleCounter-1); i++){ collectTopicElements[i] = "(reinit)todo:set item later."; }
                        //alert(rootTitleCounter+" After");
                        
                        /*if(data=="success") {
                            alert('saved current draft.');
                        } 
                        else 
                        { alert('oops, we could not save your draft at this time.'); } }*/
            
             });
        }
        function saveRawData()
        {
            var completeData = $('#TopicsWrapper').html();
            console.log(completeData);
            
            //need to save these also//var collectTopicElements = {};
            //and this//var rootTitleCounter = #
            var saveProgress = "<script>rootTitleCounter="+($('#TopicsWrapper h2').length-1)+";<\/script>";
            //alert(saveProgress);
            
            completeData += saveProgress;
            
            //ajax call to store this information in the database.
            $.post(
                    './views/cmsManagement/cmsAJAXRequests.php',
                    {'updateDraftRequest':'yes','PRIM':pid, 'SECONDARY':sid, 'TITLE':head, 'CONTENTS':completeData},
                    function(data){
                        //alert(data);
                        if(data=="success") {
                            alert('saved current draft.');
                        } 
                        else 
                        { alert('oops, we could not save your draft at this time.'); } }
            );
        }
  