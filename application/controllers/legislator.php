<?php
/**
 * Class Legislator
 * This control handles pages about legislators specifically searching and viewing profiles
 */
class Legislator extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    function __construct()
    {
        parent::__construct();

    }

    /**
     * This method controls what happens when you move to /legislator/index in your app.
     */
    function index($state="0")
    {
        $legislator_model = $this->loadModel("Legislator");
        if(isset($state) && $state!="0"){
            $this->view->state = $state;
            $this->view->displayPoliticians=true;
            $this->view->arr_rep_data = $legislator_model->get_reps_by_state($state);
            $this->view->arr_sen_data = $legislator_model->get_senators_by_state($state);
        }else{
            $this->view->displayPoliticians=false;
        }
        $this->view->render('legislator/index');
    }
    function profile($politician_id, $page = 1, $quantity = 20){
        if(!isset($politician_id)){
            $this->view->displayPage = false;
        }else{
            $this->view->displayPage = true;
            $legislator_model = $this->loadModel('Legislator');
            $community_model = $this->loadModel('Community');
            $this->view->threads = $community_model->getThreadsByPolitician($politician_id, $page, $quantity);
            $this->view->page = $page;
            $this->view->quantity = $quantity;
            $this->view->politician_id = $politician_id;
            $this->view->obj_politician_data = $legislator_model->get_politician_data($politician_id);
            $this->view->term_completion_bar = $legislator_model -> get_term_comepletion_bar($this -> view -> obj_politician_data);
            $this->view->arr_recent_voting_history = $legislator_model->get_politician_vote_history($politician_id, 5);
        }
        $this->view->render('legislator/profile');
    }
    
    public function _findPoliticians($query)
    {
        $legislator_model = $this->loadModel("Legislator");
        $this->view->legislatorList = $legislator_model->findPoliticians($query);
        echo $this->view->legislatorList;
    }
    
}
