<?php

/**
 * Class Dashboard
 * This is a demo controller that simply shows an area that is only visible for the logged in user
 * because of Auth::handleLogin(); in line 19.
 */
class Dashboard extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    function __construct()
    {
        parent::__construct();

        // this controller should only be visible/usable by logged in users, so we put login-check here
        Auth::handleLogin();
    }
    
    function inbox()
    {
        $dashboard_model = $this->loadModel('Dashboard');
        $this->view->stanceRequests = $dashboard_model->get_stanceRequestsByUserID();
        $this->view->render('dashboard/inbox');  
    }
    /**
     * This method controls what happens when you move to /dashboard/index in your app.
     */
    function index()
    {
        $congress_model = $this->loadModel('Congress');
        $community_model = $this->loadModel('Community');
        
        $this->view->recentDiscussions = $community_model->getThreads_all(1, 4);	// Fetchs the first five
        $this->view->recentBillActivity = $congress_model->getRecentBills();
        
        $this->view->render('dashboard/index');
    }
    
    function leaders()
    {
	//Representatives
        $dashboard_model = $this->loadModel('Dashboard');
        $this->view->userRepresentative = $dashboard_model->get_userRepresentative();
        $this->view->userSenators = $dashboard_model->get_userSenators();
	
	//Feeds
	$congress_model = $this->loadModel('Congress');
	$this->view->houseFeed = $congress_model->getFloorUpdates('113','house');
	$this->view->senateFeed = $congress_model->getFloorUpdates('113','senate');
	
	//Render
        $this->view->render('dashboard/leaders');
    }
    
    function _getNotificationNumber()
    {
        $dashboard_model = $this->loadModel('Dashboard');
        
        echo $dashboard_model->get_userNoficationNumber();
    }
    
    function _ASYNC_Bill_Load()
    {
	$dashboard_model = $this -> loadModel('Dashboard');
	
	$bill_ids = json_decode($_GET["data"]);
	$json = json_encode($dashboard_model -> get_bills($bill_ids));
	echo preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', $json);
    }
}
