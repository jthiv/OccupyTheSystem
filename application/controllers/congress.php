<?PHP
class Congress extends Controller{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function votes($session, $roll_id){
        $congress_model = $this->loadModel("Congress");
        $this->view->objRollInfo = $congress_model->getRollInfo($session, $roll_id);
        if($this->view->objRollInfo=="house"){
            //$this->view->where = "house";
        }else{
            //$this->view->where = "senate";
        }
        $this->view->render('congress/votes');
    }
    
    public function findIssuesByLetter($issueLetter = "a"){
        $congress_model = $this->loadModel("Congress");
        $this->view->issuesList = $congress_model->findIssuesByLetter($issueLetter);
        echo $this->view->issuesList;
        //$this->view->render('congress/findIssuesByLetter');
    }
    public function bill($bill_id="", $page_action="default", $page = 1, $quantity = 20){
        $congress_model = $this->loadModel("Congress");
        
        switch($page_action){
            case 'view':
				$this->view->objBillInfo = $congress_model->getBillInfo($bill_id);
                $this->view->render('congress/bill_viewbill');
                break;
            case 'sponsor':
				$this->view->objBillInfo = $congress_model->getBillInfo($bill_id);
                $this->view->render('congress/bill_viewsponsors');
                break;
			case 'stances':
				$this->view->objBillInfo = $congress_model->getBillInfo($bill_id);
				$this->view->objBillStances = $congress_model->getBillStancesByID($bill_id);
				$this->view->render('congress/bill_stances');
				break;
            default:
				if(!empty($bill_id))
				{
					$this->view->objBillInfo = $congress_model->getBillInfo($bill_id);
					$this->view->intUserSupportCount = $congress_model->getBillStanceCountByID($bill_id, "support");
					$this->view->intUserOpposeCount= $congress_model->getBillStanceCountByID($bill_id, "oppose");
					if (Session::get('user_logged_in') == true)
					{
						$this->view->userHasStance = $congress_model->userHasStance($bill_id, $_SESSION['user_id']);
					}else{
						$this->view->userHasStance = false;
					}
					$community_model = $this->loadModel("Community");
					$this->view->threads = $community_model->getThreadsByBill($bill_id,$page,$quantity);
					$this->view->page = $page;
					$this->view->quantity = $quantity;
					$this->view->render('congress/bill');     
				}else{
					$this->view->objBillStances = $congress_model->getBillStances_TOP();
					$this->view->render('congress/bill_search');
				}
        }
    }
	
	public function _addStance($bill_id){
		Auth::handleLogin();
		if( ( isset($_POST["stanceDefend"])&&!empty($_POST["stanceDefend"]) ) && ( isset($_POST["support"]) || isset($_POST["oppose"]) ) )
		{
			//if stance is in support...save it as so. Otherwise save it as oppose
			if(isset($_POST["support"])){
				//Save Stance: Support
				$congress_model = $this->loadModel("Congress");
				$congress_model->_addStance($bill_id, $_POST["stanceDefend"], "support");
			}elseif(isset($_POST["oppose"])){
				//Save Stance: Oppose
				$congress_model = $this->loadModel("Congress");
				$congress_model->_addStance($bill_id, $_POST["stanceDefend"], "oppose");
			}else{
				$_SESSION["feedback_negative"][] = FEEDBACK_STANCE_CREATION_FAILED_NO_STANCE;
			}
			header('location: ' . URL . 'congress/bill/'.$bill_id.'');
		}else{
			$_SESSION["feedback_negative"][] = FEEDBACK_STANCE_CREATION_FAILED_MISSING_INFO;
			header('location: ' . URL . 'congress/bill/'.$bill_id.'');
			
		}
	}
        public function _addStanceRequest($bill_id){
		Auth::handleLogin();
                
                //Send out stanceRequests
                $congress_model = $this->loadModel("Congress");
                $congress_model->_addStanceRequest($bill_id);
			
		header('location: ' . URL . 'congress/bill/'.$bill_id.'');
	}
	
	public function _removeStance($bill_id)
	{
		Auth::handleLogin();
		$congress_model = $this->loadModel("Congress");
		if($congress_model->_removeStance($bill_id)){
			header('location: ' . URL . 'congress/bill/'.$bill_id.'');
		}else{
			$_SESSION["feedback_negative"][] = FEEDBACK_STANCE_DELETE_FAILED;
			header('location: ' . URL . 'congress/bill/'.$bill_id.'');
		}
		
	}
        
}
?>