<?PHP
class CongressModel{
    
	public function __construct(Database $db)
    {
        $this->db = $db;
    }
    public function findIssuesByLetter($letter){
        try
        {
        $sql = "SELECT DISTINCT issueName, ID FROM `issuesList` WHERE issueName LIKE :letter ORDER BY issueName ASC";
        $query = $this->db->prepare($sql);
        $query->execute(array(':letter' => strtolower($letter)."%"));
        $arrIssues = $query->fetchAll();
        }catch(Exception $e){
            echo "Error ".$e.message();
        }
        return json_encode($arrIssues);
    }
    function getFloorUpdates($congress, $chamber=""){
        $method ="/floor_updates";
        $params = array();
                $params[0]=array("name" => "congress",
                                                 "value" => $congress
                                                );
                if(!empty($chamber)){
                $params[1]=array("name" => "chamber",
                                                 "value" => $chamber
                                                );
                }
        $objAPI = new Sunlight($method,$params);
        try
        {
                if($objAPI)
                {
                        $jsonResponse = $objAPI->getMethodResponse();
                        $arrResponse = json_decode($jsonResponse,true);
                        
                        return $arrResponse;
                }
                else
                {
                        throw new Exception("API Error: Invalid response.");
                }
        }
        catch(Exception $e)
        {
                echo $e->getMessage();
                return false;
        }
        
        return false;
    }
    function getRecentBills(){
                $method ="/bills";
        $params = array();
                $params[0]=array("name" => "order",
                                                 "value" => "last_action_at"
                                                );
                $params[1]=array("name" => "fields",
                                                 "value" => "bill_id,bill_type,number,congress,chamber,introduced_on,last_action,last_action_at,last_vote_at,last_version_on,official_title,short_title,urls.congress,sponsor_id,cosponsor_ids,last_version.urls.html,history"
                                                );
        $objAPI = new Sunlight($method,$params);
        try
        {
                if($objAPI)
                {
                        $jsonResponse = $objAPI->getMethodResponse();
                        
                        return $jsonResponse;
                }
                else
                {
                        throw new Exception("API Error: Invalid response.");
                }
        }
        catch(Exception $e)
        {
                echo $e->getMessage();
                return false;
        }
        
        return false;
    }
    function getRollInfo($congress, $roll_id){
        $objRollInfo = new rollInfo($congress,$roll_id);
        
        return $objRollInfo;
    }
    
    function getBillInfo($bill_id){
        $objBillInfo = new Bill($bill_id);
        
        return $objBillInfo;
    }
    function getBills_popular()
    {
	$sql = "SELECT bill_id, 
		count(bill_id) as magnitude 
		FROM `bill_stances` 
		GROUP BY bill_id
		ORDER BY magnitude DESC
		LIMIT 5";
	$query = $this->db->prepare($sql);
        $query->execute();
	return $query->fetchAll();
    }
    function getBillStances_TOP()
    {
		$stance = new StdClass();
		
        $sql = "SELECT stance.stance_value, 
						stance.stance_text, 
						stance.stance_timestamp,
						stance.bill_id,
						u.user_name
                FROM bill_stances AS stance
                JOIN users AS u ON u.user_id = stance.user_id
                WHERE stance.stance_value = 'support'
                ORDER BY stance.stance_timestamp DESC LIMIT 10";
        $query = $this->db->prepare($sql);
        $query->execute();

        // Fetch Support Stances...add to object
        $stance->support = $query->fetchAll();
		
		$sql = "SELECT stance.stance_value, 
						stance.stance_text, 
						stance.stance_timestamp, 
						stance.bill_id,
						u.user_name
                FROM bill_stances AS stance
                JOIN users AS u ON u.user_id = stance.user_id
                WHERE stance.stance_value = 'oppose'
                ORDER BY stance.stance_timestamp DESC LIMIT 10";
        $query = $this->db->prepare($sql);
        $query->execute();
		
		//Fetch oppose stances...add to object
		$stance->oppose = $query->fetchAll();
		
		return $stance;
    }
	
	function getBillStancesByID($bill_id)
    {
		$stance = new StdClass();
		
        $sql = "SELECT stance.stance_value, 
						stance.stance_text, 
						stance.stance_timestamp, 
						u.user_name
                FROM bill_stances AS stance
                JOIN users AS u ON u.user_id = stance.user_id
                WHERE stance.bill_id = :bill_id
                        AND stance.stance_value = 'support'
                ORDER BY stance.stance_timestamp DESC";
        $query = $this->db->prepare($sql);
        $query->execute(array(':bill_id' => $bill_id));

        // Fetch Support Stances...add to object
        $stance->support = $query->fetchAll();
		
		$sql = "SELECT stance.stance_value, 
						stance.stance_text, 
						stance.stance_timestamp, 
						u.user_name
                FROM bill_stances AS stance
                JOIN users AS u ON u.user_id = stance.user_id
                WHERE stance.bill_id = :bill_id
                        AND stance.stance_value = 'oppose'
                ORDER BY stance.stance_timestamp DESC";
        $query = $this->db->prepare($sql);
        $query->execute(array(':bill_id' => $bill_id));
		
		//Fetch oppose stances...add to object
		$stance->oppose = $query->fetchAll();
		
		return $stance;
    }
	
	function getBillStanceCountByID($bill_id, $stance_value)
    {
        $sql = "SELECT count(stance_value) as stance_count
                FROM bill_stances 
                WHERE bill_id = :bill_id
                        AND stance_value = :stance_value";
        $query = $this->db->prepare($sql);
        $query->execute(array(':bill_id' => $bill_id, ':stance_value' => $stance_value));

        // fetch() is the PDO method that gets a single result
        return $query->fetch();
    }
	
	function userHasStance($bill_id, $user_id)
    {
        $sql = "SELECT count(stance_value) as stance_count
                FROM bill_stances 
                WHERE bill_id = :bill_id
                        AND user_id = :user_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':bill_id' => $bill_id, ':user_id' => $user_id));

        // fetch() is the PDO method that gets a single result
        $value = $query->fetch();
		if($value->stance_count > 0){
			return true;
		}else{
			return false;
		}
    }
	
    /**
     *Setter for stance (add)
	 *@param int bill_id id of bill for which stance is issued
     *@param string $stance_defence text of the stance
     *@param string $stance actual stance
     *@return bool feedback (was comment added properly?)
     */
    public function _addStance($bill_id,$stance_defence, $stance_value)
    {
        //Clean the input
        $bill_id = strip_tags($bill_id);
		$stance_defence = strip_tags($stance_defence);
        
        $sql = "INSERT INTO bill_stances (bill_id, user_id, stance_value, stance_text) VALUES (:bill_id, :user_id, :stance_value, :stance_text)";
        $query = $this->db->prepare($sql);
        $query->execute(array(':bill_id' => $bill_id, ':user_id' => $_SESSION['user_id'], ':stance_value' => $stance_value, ':stance_text' => $stance_defence));
        
        $count =  $query->rowCount();
        
        $sql = "DELETE FROM user_stance_requests WHERE recipient_userID = :user_id AND billID = :bill_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':user_id' => $_SESSION['user_id'], ':bill_id' => $bill_id));
        
        if ($count == 1) {
            return true;
        } else {
            $_SESSION["feedback_negative"][] = FEEDBACK_STANCE_CREATION_FAILED;
        }
        // default return
        return false;
    }
    
    /**
     *Setter for stance (add)
	 *@param int bill_id id of bill for which stance is issued
     *@param string $stance_defence text of the stance
     *@param string $stance actual stance
     *@return bool feedback (was comment added properly?)
     */
    public function _addStanceRequest($bill_id)
    {
        //Clean the input
        $bill_id = strip_tags($bill_id);
        
        //Get User Fan List
        $sql = "SELECT userID FROM user_follow WHERE followed_user_ID = :user_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':user_id' => $_SESSION['user_id']));
        
        $ids = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($ids as $id){
            $fanID = $id['userID'];
            //See if fan has taken stance already
            $sql = "SELECT bill_id FROM bill_stances WHERE user_id = :fan_id and bill_id - :bill_id";
            $query = $this->db->prepare($sql);
            $query->execute(array(':fan_id' => $fanID, ':bill_id' => $bill_id));
            
            $stanceCount =  $query->rowCount();
            //See if fan has gotten invited
            if($stanceCount == 0){
                $sql = "SELECT recipient_userID FROM user_stance_requests WHERE recipient_userID = :fan_id AND billID= :bill_id";
                $query = $this->db->prepare($sql);
                $query->execute(array(':fan_id' => $fanID, ':bill_id' => $bill_id));
                
                $inviteCount =  $query->rowCount();
            }else{
                $inviteCount = 1;
            }
            if($stanceCount == 0 && $inviteCount == 0){
                //Add Stance Request for each fan
                $sql = "INSERT INTO user_stance_requests (sender_userID, recipient_userID, billID) VALUES (:user_id, :fan_id, :bill_id);";
                $query = $this->db->prepare($sql);
                $query->execute(array(':user_id' => $_SESSION['user_id'], ':fan_id' => $fanID, ':bill_id' => $bill_id));
            }
            
        }
        
        ////Add Stance Requests to each Fan
        //$sql = "INSERT INTO bill_stances (bill_id, user_id, stance_value, stance_text) VALUES (:bill_id, :user_id, :stance_value, :stance_text)";
        //$query = $this->db->prepare($sql);
        //$query->execute(array(':bill_id' => $bill_id, ':user_id' => $_SESSION['user_id'], ':stance_value' => $stance_value, ':stance_text' => $stance_defence));
        //
        //$count =  $query->rowCount();
        //if ($count == 1) {
        //    return true;
        //} else {
        //    $_SESSION["feedback_negative"][] = FEEDBACK_STANCE_CREATION_FAILED;
        //}
        //// default return
        //return false;
    }
	
	public function _removeStance($bill_id){
		$bill_id = strip_tags($bill_id);
        
        $sql = "DELETE FROM bill_stances WHERE bill_id = :bill_id AND user_id = :user_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':bill_id' => $bill_id, ':user_id' => $_SESSION['user_id']));
        
        $count =  $query->rowCount();
        if ($count == 1) {
            return true;
        } else {
            $_SESSION["feedback_negative"][] = FEEDBACK_STANCE_DELETE_FAILED;
        }
        // default return
        return false;
	}
}
?>