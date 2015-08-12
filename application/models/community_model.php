<?php
class CommunityModel
{
    /**
     * Constructor, expects a Database connection
     * @param Database $db The Database object
     */
	 
	public $tagExceptions;
    public function __construct(Database $db)
    {
        $this->db = $db;
		if (Session::get('user_logged_in') == true)
		{
			$this->user_id = $_SESSION["user_id"];
		}else{
			$this->user_id = 0;
		}
		$this->tagExceptions = "<b><a><u><i><p><br>";
    }

    /**
     * Getter for categories to display by section
     * @param int id of specific section
     * @return array an array with several objects (the results)
     */
    public function getCategoriesBySection($sectionID)
    {
        $sql = "SELECT category_id,category_name FROM community_categories WHERE section_id = :section_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':section_id' => $sectionID));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }
    
    /**
     * Getter for categories to display by category ID
     * @param int id of specific section
     * @return array an array with one object (the results)
     */
    public function getCategoryInfoByID($category_id)
    {
        $sql = "SELECT category_id,category_name,category_description FROM community_categories WHERE category_id = :category_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':category_id' => $category_id));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetch();
    }
    public function getThreads_all($page=1, $quantity=20)
    {
        $sql = "SELECT th.thread_id, 
                        th.thread_title,
                        th.thread_text,
						th.thread_politician_id,
						th.thread_bill_id,
                        th.thread_author_user_id,
                        th.thread_timestamp,
						u.user_id,
                        u.user_name,
						u.user_level,
                        v.vote_value,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up') as votes_up,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='down') as votes_down,
                        
			(UNIX_TIMESTAMP(th.thread_timestamp)
			+ 143507.5 *(log10((SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up')+1)-log10((SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='down')+1))
			+ 11958.9583 *(log10((SELECT count(*) FROM community_threads WHERE thread_id = th.thread_parent_id)+1))
			) as Hotness
                FROM community_threads AS th
                JOIN users AS u ON u.user_id = th.thread_author_user_id
                LEFT JOIN community_thread_votes AS v ON v.thread_id = th.thread_id
                                            AND v.user_id= :user_id
                WHERE (th.thread_parent_id = 0 || th.thread_parent_id IS null)
                ORDER BY Hotness DESC LIMIT :starting_post, :quantity";
        
	
	/*if($limit!=0)
        {
            $sql .= " LIMIT $limit";
        }*/
	
	// Starting point should begin the posts at the start of the page passed in.
	$starting_point = (($page-1) * $quantity);
	
	// We want to grab one extra row to see if there is anything after this page
       $quantity++;
	
	$query = $this->db->prepare($sql);
	$query->bindParam(":user_id", $this -> user_id, PDO::PARAM_STR);
	$query->bindParam(":starting_post",$starting_point, PDO::PARAM_INT);
	$query->bindParam(":quantity",$quantity,PDO::PARAM_INT);
        $query->execute();
	//$query->execute(array(':user_id' => $this->user_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetchAll();
    }
    /**
     * Getter for threads in a category
     * @param int $category_id id of specific category
     * @return array with several objects (the result)
     */
    public function getThreadsByUserID($user_id)
    {
        $sql = "SELECT th.thread_id,
                        th.thread_title,
                        th.thread_text,
                        th.thread_politician_id,
                        th.thread_bill_id,
                        th.thread_author_user_id,
                        th.thread_timestamp,
                        th.thread_parent_id,
                        (SELECT thread_title FROM community_threads WHERE thread_id = th.thread_parent_id) as parent_thread_title,
			u.user_id,
                        u.user_name,
			u.user_level,
                        v.vote_value,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up') as votes_up,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='down') as votes_down,
                        
			(UNIX_TIMESTAMP(th.thread_timestamp)
			+ 143507.5 *(log10((SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up')+1)-log10((SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='down')+1))
			+ 11958.9583 *(log10((SELECT count(*) FROM community_threads WHERE thread_id = th.thread_parent_id)+1))
			) as Hotness
                FROM community_threads AS th
                JOIN users AS u ON u.user_id = th.thread_author_user_id
                LEFT JOIN community_thread_votes AS v ON v.thread_id = th.thread_id
                                            AND v.user_id= :user_id
                WHERE u.user_id = :user_id
                ORDER BY Hotness DESC";
        $query = $this->db->prepare($sql);
        $query->execute(array(':user_id' => $user_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetchAll();
    }
    
    public function getThreadsByCategory($category_id, $page=1, $quantity = 10)
    {
        $sql = "SELECT th.thread_id, 
                        th.thread_title,
                        th.thread_text,
						th.thread_politician_id,
						th.thread_bill_id,
                        th.thread_author_user_id,
                        th.thread_timestamp,
						u.user_id,
                        u.user_name,
						u.user_level,
                        v.vote_value,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up') as votes_up,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='down') as votes_down,
                        
			(UNIX_TIMESTAMP(th.thread_timestamp)
			+ 143507.5 *(log10((SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up')+1)-log10((SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='down')+1))
			+ 11958.9583 *(log10((SELECT count(*) FROM community_threads WHERE thread_id = th.thread_parent_id)+1))
			) as Hotness
                FROM community_threads AS th
                JOIN users AS u ON u.user_id = th.thread_author_user_id
                LEFT JOIN community_thread_votes AS v ON v.thread_id = th.thread_id
                                            AND v.user_id= :user_id
                WHERE th.category_id = :category_id
                        AND (th.thread_parent_id = 0 || th.thread_parent_id IS null)
                ORDER BY Hotness DESC LIMIT :starting_point, :quantity";
        $query = $this->db->prepare($sql);
	
	// Starting point should begin the posts at the start of the page passed in.
	$starting_point = (($page-1) * $quantity);
	
	// Note the change to bindValue instead of using an execute(array) method.
	// This is due to the parameters that are being sent to the starting and
	// ending limit needing to be integers. They have to be forced so they aren't
	// escaped. It's a known bug (since 08...) detailed here: https://bugs.php.net/bug.php?id=44639
	// If you have a more elegant fix for this please let me know! I don't like how inelegant this is.
	$query->bindValue(':category_id', $category_id, PDO::PARAM_STR);
	$query->bindValue(':user_id', $this->user_id, PDO::PARAM_STR);
	$query->bindValue(':starting_point', (int)$starting_point, PDO::PARAM_INT);
	$query->bindValue(':quantity', (int)$quantity, PDO::PARAM_INT);
        $query->execute();
	
	
	//$query->execute(array(':category_id' => $category_id, ':user_id' => $this->user_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetchAll();
    }
    
	/**
     * Getter for threads in pertaining to a bill
     * @param int $bill_id id of specific bill
     * @return array with several objects (the result)
     */
    public function getThreadsByBill($bill_id, $page = 0, $quantity = 10)
    {
        $sql = "SELECT th.thread_id, 
                        th.thread_title,
                        th.thread_text,
						th.thread_politician_id,
						th.thread_bill_id,
                        th.thread_author_user_id,
                        th.thread_timestamp,
						u.user_id,
                        u.user_name,
						u.user_level,
                        v.vote_value,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up') as votes_up,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='down') as votes_down,
                        (UNIX_TIMESTAMP(th.thread_timestamp)
			+ 143507.5 *(log10((SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up')+1)-log10((SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='down')+1))
			+ 11958.9583 *(log10((SELECT count(*) FROM community_threads WHERE thread_id = th.thread_parent_id)+1))
			) as Hotness
                FROM community_threads AS th
                JOIN users AS u ON u.user_id = th.thread_author_user_id
                LEFT JOIN community_thread_votes AS v ON v.thread_id = th.thread_id
                                            AND v.user_id= th.thread_author_user_id
                WHERE th.thread_bill_id = :bill_id
                        AND (th.thread_parent_id = 0 || th.thread_parent_id IS null)
                ORDER BY Hotness DESC LIMIT :starting_limit, :quantity";
       
       
       	$starting_point = (($page-1) * $quantity);

       
        $query = $this->db->prepare($sql);
	$query -> bindValue(':bill_id', $bill_id, PDO::PARAM_STR);
	$query -> bindValue(':starting_limit', $starting_point, PDO::PARAM_INT);
	$query -> bindValue(':quantity', $quantity, PDO::PARAM_INT);
	$query -> execute();
        
	//$query->execute(array(':bill_id' => $bill_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetchAll();
    }
	
    /**
     * Getter for threads in pertaining to a politician
     * @param int $politician_id id of specific politician
     * @return array with several objects (the result)
     */
    public function getThreadsByPolitician($politician_id,  $page = 1, $quantity = 10)
    {
        $sql = "SELECT th.thread_id, 
                        th.thread_title,
                        th.thread_text,
						th.thread_politician_id,
						th.thread_bill_id,
                        th.thread_author_user_id,
                        th.thread_timestamp,
						u.user_id,
                        u.user_name,
						u.user_level,
                        v.vote_value,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up') as votes_up,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='down') as votes_down,
                        (UNIX_TIMESTAMP(th.thread_timestamp)
			+ 143507.5 *(log10((SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up')+1)-log10((SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='down')+1))
			+ 11958.9583 *(log10((SELECT count(*) FROM community_threads WHERE thread_id = th.thread_parent_id)+1))
			) as Hotness
                FROM community_threads AS th
                JOIN users AS u ON u.user_id = th.thread_author_user_id
                LEFT JOIN community_thread_votes AS v ON v.thread_id = th.thread_id
                                            AND v.user_id= th.thread_author_user_id
                WHERE th.thread_politician_id = :politician_id
                        AND (th.thread_parent_id = 0 || th.thread_parent_id IS null)
                ORDER BY Hotness DESC LIMIT :starting_point, :quantity";
		
	$starting_point = (($page-1) * $quantity);
		
        $query = $this->db->prepare($sql);
	$query->bindValue(':politician_id', $politician_id, PDO::PARAM_STR);
	$query->bindValue(':starting_point', $starting_point, PDO::PARAM_INT);
	$query->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $query->execute();
	
	//$query->execute(array(':politician_id' => $politician_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetchAll();
    }
    
    /**
     * Getter for threads in a thread_id
     * @param int $thread_id id of specific thread
     * @return array with one objects (the result)
     */
    public function getThreadByID($thread_id, $starting_limit = 0, $quantity = 10)
    {
        $sql = "SELECT th.thread_id, 
                        th.thread_title,
                        th.thread_text,
						th.thread_politician_id,
						th.thread_bill_id,
                        th.thread_author_user_id,
                        th.thread_timestamp,
			th.thread_url,
                        th.category_id,
						u.user_id,
                        u.user_name,
						u.user_level,
                        v.vote_value,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up') as votes_up,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='down') as votes_down,
                        (UNIX_TIMESTAMP(th.thread_timestamp)
			+ 143507.5 *(log10((SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up')+1)-log10((SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='down')+1))
			+ 11958.9583 *(log10((SELECT count(*) FROM community_threads WHERE thread_id = th.thread_parent_id)+1))
			) as Hotness
                FROM community_threads AS th
                JOIN users AS u ON u.user_id = th.thread_author_user_id
                LEFT JOIN community_thread_votes AS v ON v.thread_id = th.thread_id
                                            AND v.user_id= th.thread_author_user_id
                WHERE th.thread_id = :thread_id
                ORDER BY Hotness DESC LIMIT :starting_limit, :quantity";
        $query = $this->db->prepare($sql);
	$query->bindValue(':thread_id', $thread_id, PDO::PARAM_STR);
	$query->bindValue(':starting_limit',$starting_limit, PDO::PARAM_INT);
	$query->bindValue(':quantity', $quantity, PDO::PARAM_INT);
	$query->execute();
        
	//$query->execute(array(':thread_id' => $thread_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetch();
    }
    
    /**
     * Getter for thread array object
     * @param int $thread_id id of specific thread
     * @return array object with several objects (the result)
     */
    public function getThreadArray($thread_id)
    {
        $threadInfo = $this->getThreadByID($thread_id);

        $arr_thread_obj = array('thread_parent_id' => $threadInfo->thread_id,
                                'thread_parent_category_id' =>$threadInfo->category_id,
                                'thread_parent_title' => $threadInfo->thread_title,
				'thread_parent_url' => $threadInfo->thread_url,
                                'thread_parent_text' => $threadInfo->thread_text,
                                'thread_parent_author' => $threadInfo->user_name,
								'thread_parent_user_id' => $threadInfo->user_id,
								'thread_parent_author_user_level' => $threadInfo->user_level,
                                'thread_parent_timestamp' => $threadInfo->thread_timestamp,
                                'vote_value' => $threadInfo->vote_value,
                                'votes_up' => $threadInfo->votes_up,
                                'votes_down' => $threadInfo->votes_down,
                                'children' =>$this->buildChildrenArray($thread_id));
        
        return $arr_thread_obj;
    }
    private function buildChildrenArray($parent_id)
    {
        //This is an object that only holds the children of a parent thread
        $objChildren = $this->getThreadsByParent($parent_id);
        
        //This is an array we are going to recursively turn into a multi dimensional array
        //it will store all of the thread info and thread paths
        //Children->children->children....
        $arrChildren = array();
        
        $counter = 0;
        foreach($objChildren as $child){
            $arrChildren[$counter] = array('thread_id' => $child->thread_id,
                                           'thread_text' => $child->thread_text,
										   'author_user_id' => $child->user_id,
                                           'author_user_name' => $child->user_name,
										   'author_user_level' => $child->user_level,
                                           'author_user_id' => $child->thread_author_user_id,
                                           'thread_timestamp' => $child->thread_timestamp,
                                           'vote_value' => $child->vote_value,
                                           'votes_up' => $child->votes_up,
                                           'votes_down' => $child->votes_down,
                                           'children' => $this->buildChildrenArray($child->thread_id));
            $counter++;
            
        }
        return $arrChildren;
    }
    
    /**
     * Getter for a threads children
     * @param int $category_id id of specific category
     * @return array with several objects (the result)
     */
    public function getThreadsByParent($parent_id)
    {
        $sql = "SELECT th.thread_id, 
                        th.thread_title,
                        th.thread_text,
                        th.thread_author_user_id,
                        th.thread_timestamp,
                        th.category_id,
						u.user_id,
                        u.user_name,
						u.user_level,
                        v.vote_value,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up') as votes_up,
                        (SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='down') as votes_down,
                        (LOG10((SELECT count(*) FROM community_thread_votes WHERE thread_id = th.thread_id AND vote_value='up') + 1) * 287015 + UNIX_TIMESTAMP(th.thread_timestamp)) AS Hotness
                        
                FROM community_threads AS th
                JOIN users AS u ON u.user_id = th.thread_author_user_id
                LEFT JOIN community_thread_votes AS v ON v.thread_id = th.thread_id
                                            AND v.user_id= th.thread_author_user_id
                WHERE th.thread_parent_id = :parent_id
                ORDER BY Hotness DESC";
        $query = $this->db->prepare($sql);
        $query->execute(array(':parent_id' => $parent_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetchAll();
    }
    
    /**
     * Getter for category id by thread id
     * @param int thread_id id of specific thread
     * @return array with one object (the result)
     */
    public function getCategoryByThreadID($thread_id)
    {
        $sql = "SELECT category_id FROM community_threads WHERE thread_id = :thread_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':thread_id' => $thread_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetch();
    }
    
    /**
     *Setter for comment (add)
     *@param string $comment_text text of the comment
     *@param int $parent_thread_id id of the parent thread
     *@return bool feedback (was comment added properly?)
     */
    public function addComment($thread_text, $thread_parent_id)
    {
        //Clean the input
        $thread_text = strip_tags($thread_text, $this->tagExceptions);
        
        $sql = "INSERT INTO community_threads (thread_text, thread_parent_id, thread_author_user_id) VALUES (:thread_text, :thread_parent_id, :user_id)";
        $query = $this->db->prepare($sql);
        $query->execute(array(':thread_text' => $thread_text, ':thread_parent_id' => $thread_parent_id, ':user_id' => $_SESSION['user_id']));
        
        $count =  $query->rowCount();
        if ($count == 1) {
            $rootThreadID = $this->getRootThreadID($thread_parent_id);
            return $rootThreadID;
        } else {
            $_SESSION["feedback_negative"][] = FEEDBACK_NOTE_CREATION_FAILED;
        }
        // default return
        return false;
    }
    
    public function addVote($thread_id, $vote_value)
    {
        $sql_checkVote = "SELECT thread_id FROM community_thread_votes WHERE thread_id = :thread_id AND user_id = :user_id";
        $query_checkVote = $this->db->prepare($sql_checkVote);
        $query_checkVote->execute(array(':thread_id' => $thread_id, ':user_id' => $_SESSION['user_id']));
        $rows = count((array)$query_checkVote->fetchAll());
        if ($rows>0){
            $sql_delVote = "DELETE FROM community_thread_votes WHERE thread_id = :thread_id AND user_id = :user_id";
            $query_delVote = $this->db->prepare($sql_delVote);
            $query_delVote->execute(array(':thread_id' => $thread_id, ':user_id' => $_SESSION['user_id']));
            $count =  $query_delVote->rowCount();
            if ($count == 1) {
                return true;
            } else {
                $_SESSION["feedback_negative"][] = FEEDBACK_NOTE_CREATION_FAILED;
            }
            // default return
            return false;
        }else{        
            $sql = "INSERT INTO community_thread_votes (thread_id, vote_value, user_id) VALUES (:thread_id, :vote_value, :user_id)";
            $query = $this->db->prepare($sql);
            $query->execute(array(':thread_id' => $thread_id, ':vote_value' => $vote_value, ':user_id' => $_SESSION['user_id']));
            
            $count =  $query->rowCount();
            if ($count == 1) {
                return true;
            } else {
                $_SESSION["feedback_negative"][] = FEEDBACK_NOTE_CREATION_FAILED;
            }
            // default return
            return false;
        }

    }
    /**
     * Setter for a thread (create)
     * @param string $note_text note text that will be created
     * @return bool feedback (was the note created properly ?)
     */
    public function createThread($thread_title, $thread_text, $category_id, $thread_link = null)
    {
        // clean the input to prevent for example javascript within the notes.
        $thread_title = strip_tags($thread_title);
        $thread_text = strip_tags($thread_text, $this->tagExceptions);

        $sql = "INSERT INTO community_threads (thread_title, thread_text,category_id, thread_url, thread_author_user_id) VALUES (:thread_title, :thread_text, :category_id, :thread_link, :user_id)";
        $query = $this->db->prepare($sql);
        $query->execute(array(':thread_title' => $thread_title, ':thread_text' => $thread_text, ':category_id' => $category_id, ':thread_link' => $thread_link, ':user_id' => $_SESSION['user_id']));

        $count =  $query->rowCount();
        if ($count == 1) {
            return true;
        } else {
            $_SESSION["feedback_negative"][] = FEEDBACK_NOTE_CREATION_FAILED;
        }
        // default return
        return false;
    }
    
	/**
     * Setter for a thread for legislator (create)
     *
     * @return bool feedback (was the note created properly ?)
     */
    public function createThread_bill($thread_title, $thread_text, $bill_id, $category_id)
    {
        // clean the input to prevent for example javascript within the notes.
        $thread_title = strip_tags($thread_title);
        $thread_text = strip_tags($thread_text, $this->tagExceptions);
        //TODO: Check to make sure $politician_id exists
        $sql = "INSERT INTO community_threads (thread_title, thread_text, thread_bill_id, category_id, thread_author_user_id) VALUES (:thread_title, :thread_text, :bill_id, :category_id, :user_id)";
        $query = $this->db->prepare($sql);
        $query->execute(array(':thread_title' => $thread_title, ':thread_text' => $thread_text, ':bill_id' => $bill_id, ':category_id' => $category_id, ':user_id' => $_SESSION['user_id']));
        $count =  $query->rowCount();
        if ($count == 1) {
            return true;
        } else {
            $_SESSION["feedback_negative"][] = FEEDBACK_NOTE_CREATION_FAILED;
        }
        // default return
        return false;
    }
	
    /**
     * Setter for a thread for legislator (create)
     *
     * @return bool feedback (was the note created properly ?)
     */
    public function createThread_legislator($thread_title, $thread_text, $politician_id, $category_id)
    {
        // clean the input to prevent for example javascript within the notes.
        $thread_title = strip_tags($thread_title);
        $thread_text = strip_tags($thread_text, $this->tagExceptions);
        //TODO: Check to make sure $politician_id exists
        $sql = "INSERT INTO community_threads (thread_title, thread_text, thread_politician_id, category_id, thread_author_user_id) VALUES (:thread_title, :thread_text, :politician_id, :category_id, :user_id)";
        $query = $this->db->prepare($sql);
        $query->execute(array(':thread_title' => $thread_title, ':thread_text' => $thread_text, ':politician_id' => $politician_id, ':category_id' => $category_id, ':user_id' => $_SESSION['user_id']));
        $count =  $query->rowCount();
        if ($count == 1) {
            return true;
        } else {
            $_SESSION["feedback_negative"][] = FEEDBACK_NOTE_CREATION_FAILED;
        }
        // default return
        return false;
    }

    /**
     * Setter for a note (update)
     * @param int $note_id id of the specific note
     * @param string $note_text new text of the specific note
     * @return bool feedback (was the update successful ?)
     */
    public function editComment($thread_id, $comment_text)
    {
        // clean the input to prevent for example javascript within the notes.
        $thread_text = strip_tags($comment_text, $this->tagExceptions);

        $sql = "UPDATE community_threads SET thread_text = :thread_text WHERE thread_id = :thread_id AND thread_author_user_id = :user_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':thread_id' => $thread_id, ':thread_text' => $thread_text, ':user_id' => $_SESSION['user_id']));

        $count =  $query->rowCount();
        if ($count == 1) {
			$rootThreadID = $this->getRootThreadID($thread_id);
            return $rootThreadID;
        } else {
            $_SESSION["feedback_negative"][] = FEEDBACK_THREAD_EDITING_FAILED;
        }
        // default return
        return false;
    }

    /**
     * Deletes a specific thread
     * @param int $thread_id id of the thread
     * @return bool feedback (was the note deleted properly ?)
     */
    public function deleteThread($thread_id)
    {
        if($_SESSION['user_level']=="mod" || $_SESSION['user_level']=="admin")
        {
            $sql = "DELETE FROM community_threads WHERE thread_id = :thread_id";
            $query = $this->db->prepare($sql);
            $query->execute(array(':thread_id' => $thread_id));
        }
        else
        {
            $sql = "DELETE FROM community_threads WHERE thread_id = :thread_id AND thread_author_user_id = :user_id";
            $query = $this->db->prepare($sql);
            $query->execute(array(':thread_id' => $thread_id, ':user_id' => $_SESSION['user_id']));
        }

        $count =  $query->rowCount();

        if ($count == 1) {
            return true;
        } else {
            $_SESSION["feedback_negative"][] = FEEDBACK_NOTE_DELETION_FAILED;
        }
        // default return
        return false;
    }
    
    /**
     *Returns the ID of the root thread (int)
     */
    public function getRootThreadID($child_id)
    {
        $sql = "SELECT thread_id, thread_parent_id FROM community_threads WHERE thread_id = :thread_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':thread_id' => $child_id));

        // fetch() is the PDO method that gets a single result
         $result = $query->fetch();
         if($result->thread_parent_id == 0 || $result->thread_parent_id == NULL)
         {
            return $result->thread_id;
         }else{
            return $this->getRootThreadID($result->thread_parent_id);
         }
    }
}
