<?php

/**
 * Class Index
 * The index controller
 */
class Index extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    function __construct()
    {
            parent::__construct();
    }

    /**
     * Handles what happens when user moves to URL/index/index, which is the same like URL/index or in this
     * case even URL (without any controller/action) as this is the default controller-action when user gives no input.
     */
    function index()
    {
			$index_model = $this->loadModel("Index");
			$this->view->objBillStances = $index_model->getBillStances_Random();
            $this->view->render('index/index');
    }
	function contact()
	{
		$this->view->render('index/contact');
	}
	function policy()
	{
		$this->view->render('index/policy');
	}
}
