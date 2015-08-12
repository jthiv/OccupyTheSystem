<?PHP
class News extends Controller
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
    public function index()
    {
        //$community_model = $this->loadModel('Community');
        //$this->view->general_categories = $community_model->getCategoriesBySection(2);
        //$this->view->oped_categories = $community_model->getCategoriesBySection(1);
        $this->view->render('news/index');
    }
    
    public function add()
    {
        $this->view->render('news/add');
    }
}
?>