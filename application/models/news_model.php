<?php
class NewsModel
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
}
