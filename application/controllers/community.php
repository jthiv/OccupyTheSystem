<?PHP
class Community extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This method controls what happens when you move to /note/index in your app.
     * Gets all notes (of the user).
     */
    public function index($page=1, $quantity=20)
    {
        $community_model = $this->loadModel('Community');
        $this->view->general_categories = $community_model->getCategoriesBySection(2);
        $this->view->oped_categories = $community_model->getCategoriesBySection(1);
        $this->view->recentDiscussions = $community_model->getThreads_all($page, $quantity);
	$this->view->page = $page;
	$this->view->quantity = $quantity;
        $this->view->render('community/index');
    }
    
    public function rules($section)
    {
        $community_model = $this->loadModel('Community');
        $this->view->section = $section;
        $this->view->render('community/rules');
    }
    
    public function category($category_id, $page=1, $quantity=20)
    {
        $community_model = $this->loadModel('Community');
        $this->view->category_info = $community_model->getCategoryInfoByID($category_id);
        $this->view->threads = $community_model->getThreadsByCategory($category_id, $page, $quantity);
	$this->view->page = $page;
	$this->view->quantity = $quantity;
        $this->view->render('community/category');
        
    }
    
    public function thread($thread_id)
    {
        $community_model = $this->loadModel('Community');
        $this->view->arr_thread_info = $community_model->getThreadArray($thread_id);
        
        $this->view->render('community/thread');
    }
    public function _addComment($parent_thread_id)
    {
        Auth::handleLogin();
        if (isset($_POST['thread_text']) AND !empty($_POST['thread_text'])) {
            $community_model = $this->loadModel('Community');
            $rootThreadID = $community_model->addComment($_POST['thread_text'],$parent_thread_id);
        }
        header('location: ' . URL . 'community/thread/'.$rootThreadID.'');
        
    }
	public function _editComment($thread_id)
	{
		Auth::handleLogin();
        if (isset($_POST['comment_text']) AND !empty($_POST['comment_text'])) {
            $community_model = $this->loadModel('Community');
            $rootThreadID = $community_model->editComment($thread_id, $_POST["comment_text"]);
        }
        header('location: ' . URL . 'community/thread/'.$rootThreadID.'');
	}
    public function _addVote($thread_id, $vote_value)
    {
        Auth::handleLogin();
        $community_model = $this->loadModel('Community');
        if($vote_value=="up"||$vote_value=="down")
        {
            $community_model->addVote($thread_id,$vote_value);
            $category_id = $community_model->getCategoryByThreadID($thread_id);
            if($category_id->category_id==0||$category_id->category_id==null){
                $rootID = $community_model->getRootThreadID($thread_id);
                header('location: ' . URL . 'community/thread/'.$rootID);
            }else{
                header('location: ' . URL . 'community/category/'.$category_id->category_id);
            }
        }
       
    }
    public function createThread($category_id)
    {
        Auth::handleLogin();
        if (isset($_POST['thread_title']) AND !empty($_POST['thread_title'])) {
            $community_model = $this->loadModel('Community');
            if(isset($_POST['politician_id']) AND !empty($_POST['politician_id'])){
                $community_model->createThread_legislator($_POST['thread_title'],$_POST['thread_text'], $_POST['politician_id'],$category_id);
                header('location: ' . URL . 'legislator/profile/'.$_POST['politician_id']);
            }elseif(isset($_POST['bill_id']) AND !empty($_POST['bill_id'])){
				$community_model->createThread_bill($_POST['thread_title'],$_POST['thread_text'], $_POST['bill_id'],$category_id);
                header('location: ' . URL . 'congress/bill/'.$_POST['bill_id']);
	    }else{
                if(isset($_POST['thread_link']) && !empty($_POST['thread_link'])){
                    $thread_url = $_POST['thread_link'];
                }else{
                    $thread_url = null;
                }
                $community_model->createThread($_POST['thread_title'],$_POST['thread_text'],$category_id, $thread_url);
                header('location: ' . URL . 'community/category/'.$category_id);
            }
            
        }
        
    }
    
    public function deleteThread($thread_id)
    {
        Auth::handleLogin();
        $community_model = $this->loadModel('Community');
        $category_id = $community_model->getCategoryByThreadID($thread_id);
        
        
        if($category_id->category_id==0||$category_id->category_id==null){
            $rootID = $community_model->getRootThreadID($thread_id);
            $community_model->deleteThread($thread_id);
            header('location: ' . URL . 'community/thread/'.$rootID);
        }else{
            $community_model->deleteThread($thread_id);
            header('location: ' . URL . 'community/category/'.$category_id->category_id);
        }
        
    }
}
?>