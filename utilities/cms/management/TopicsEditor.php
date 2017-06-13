<?php
    //echo getcwd();
    //exit;
    //C:\Program Files (x86)\EasyPHP-DevServer-14.1VC9\data\localweb\PhpProject2
    include_once('./utilities/dbAuth.php');

    class TopicsEditor
    {
        
        private $newTopic = true; //the constructor should change this to false if the topic does not exist in the db.
        private $topicID;
        private $title;
        private $pid;
        private $sid;
        private $topicType; //page or post.
        private $draftString;
        private $draftArray;
        private $uploadURL;
        private $message;
        private $cwd;
        public $titleCounter;
        
        public function getMessage(){
            return $this->message;
        }
        
        public function isNew(){
            return $this->newTopic;
        }
        
        public function __construct($title, $pid=NULL, $sid=NULL){
            $this->title = $title;
            $this->cwd = getcwd();
            if(empty($pid) || empty($sid)){
                //exit(); //do not uncomment.
                
                $this->titleCounter = 0;
                $this->message = "<ul><li><h2>Tips and Tricks to starting a new topic,</h2></li><em><li>Use the controls above to create your content.</li><li>Click on your created sections to edit content.</li><li>Double-click while in editor-mode to save any changes and return to the preview.</li></li><li>When you are done or want to save a draft or your work press the corresponding buttons.</li></em><li><strong>To remove an image, drag the item while in preview mode.</strong><li><li><strong>To continue working from a saved draft press reload.</strong></li></ul>";
            }
            else{
                $this->newTopic = false;
                
                //set this objects primary and secondary id's
                $this->pid = $pid;
                $this->sid = $sid;
                $this->message = $this->RetrieveTopic();
            }
        }
        
        public function RetrieveTopic(){
            global $db;
            //retrieve any existing drafts and/or upload location.
            $query = 'SELECT id, name, primaryID, secondaryID, type, url, contents FROM topicsdb WHERE name = :t_name AND primaryID = :t_pid AND secondaryID = :t_sid;';
            try 
            {
                $statement = $db->prepare($query);
                $statement->bindValue(':t_name', $this->$title);
                $statement->bindValue(':t_pid', $this->$pid);
                $statement->bindValue(':t_sid', $this->$sid);
                $statement->execute();
                    
                if($statement->rowCount() == 1)
                {   
                    //if there is a result.
                    $result = $statement->fetch();               
                    $this->topicID = $result[0];
                    $this->newTopic = true;
                    $this->uploadURL = $result[5];
                    $this->draftString = $result[6];  
                    return ""; //good to go.
                } 
                else
                {
                    //if it no longer exists.
                    $this->newTopic = false;
                    return "Oops! This item no longer exists!";
                }
                $statement->closeCursor();
            }
            catch (PDOException $ex) { return $ex->getMessage(); }
        }
        
        public function submitDraft()
        {
            
        }
        
        public  function printRootControl()
        {
            $subControls = "<div style='display:none;'><p class='AuxilaryControl' onclick='addCMSElement(this,0)'>+ <span name='paragraph'>Add Paragraph</span></p><p class='AuxilaryControl' onclick='addCMSElement(this,1)'>+ <span>Add Image</span></p><p class='AuxilaryControl' onclick='addCMSElement(this,2)'>+ <span>Add Video</span></p><p class='AuxilaryControl' onclick='addCMSElement(this,3)'>+ <span>Sub Title</span></p></div>";
            echo "<div id='TP".$this->titleCounter."'><h2>+<span class='titleBox'>Title</span></h2><input type='text'/><button onclick='submitAndPrintRootChildControls(this)'>Add/Update</button>".$subControls."</div>";
        }
        public  function printRootChildrenControls()
        {
            echo "<p><em>Test</em></p>";
            //echo "<div id='TP".$this->titleCounter."'><h2>+<span>Sub Title</span></h2><input type='text'/><button onclick='submitAndPrintRootChildControls(this)'>Add/Change</button></div>";
            //echo '<div><p>+ <span name="paragraph">Add Paragraph</span></p><p>+ <span>Add Image</span></p><p>+ <span>Add Video</span></p><p>+ <span>Sub Title</span></p></div>';
        }
    }
?>