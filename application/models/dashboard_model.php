<?PHP

class dashboardModel{
    
    public $userState;
    public $userDistrict;
    
    public $obj_Leaders;
    public $userRepresentative;
    public $userSenators;


    function __construct(Database $db){
        $this->db = $db;
        $this->userState=$_SESSION['user_state'];
        $this->userDistrict=$_SESSION['user_district'];
        
        $this->obj_Leaders= new Leaders($this->userState,$this->userDistrict);
        
        $this->set_userRepresentative();
        $this->set_userSenators();
    }
    
    function get_userRepresentative(){
        return $this->userRepresentative;
    }
    
    function set_userRepresentative(){
        $user_representative_id = $this->obj_Leaders->get_representative_id();
        $arr_userRepresentative = array();
        
        $count=0;
        foreach($user_representative_id['results'] as $representative){
            $arr_userRepresentative[$count] = new LegislatorInfo($representative['bioguide_id']);
            $count++;
        }
        
        $this->userRepresentative = $arr_userRepresentative;
    }
    
    function get_userSenators(){
        return $this->userSenators;
    }
    
    function set_userSenators(){
        //$this->userSenators = $this->obj_Leaders->display_senators();
        $userSenator_ids = $this->obj_Leaders->get_senator_ids();
        $arr_userSenator = array();
        
        $count=0;
        foreach($userSenator_ids['results'] as $senator){
            $arr_userSenator[$count] = new LegislatorInfo($senator['bioguide_id']);
            $count++;
        }
        $this->userSenators = $arr_userSenator;
    }
    /**************************************************************************************
     *INBOX
     **************************************************************************************/
    
    function get_stanceRequestsByUserID()
    {
        //Get Stance Requests and add to $iNotifications
            $sql = "SELECT req.*, sender.user_name FROM user_stance_requests AS req JOIN users as sender ON sender.user_id=req.sender_userID  WHERE recipient_userID = :user_id";
            $query = $this->db->prepare($sql);
            $query->execute(array(':user_id' => $_SESSION['user_id']));
            
            return $query->fetchAll();
    }
    function get_userNoficationNumber()
    {
        $iNotifications = 0;
        
        //Get Stance Requests and add to $iNotifications
            $sql = "SELECT recipient_userID FROM user_stance_requests WHERE recipient_userID = :user_id";
            $query = $this->db->prepare($sql);
            $query->execute(array(':user_id' => $_SESSION['user_id']));
            
            $iNotifications =  $iNotifications+$query->rowCount();
        //Get unopened mail and add to $iNotifications
        
        $arrNotificationsInfo = null;
        
        if($iNotifications==0){
            $arrNotificationsInfo = array('notify' => "false",
                                          'number' => $iNotifications);
        }else{
            $arrNotificationsInfo = array('notify' => "true",
                                          'number' => $iNotifications);
        }
        
        return json_encode($arrNotificationsInfo);
    }
    
    function get_bills($bill_ids)
    {
        if(!isset($bill_ids) || $bill_ids == null)
            return null;
        
        $BillArray = Array();
        
        
        foreach($bill_ids as $uselessIndex => $bill_id)
        {
            if(!isset($BillArray[$bill_id]))    // Don't add lots of duplicate bills
            {
                $BillArray[$bill_id] = new Bill($bill_id, null, true);
            
                if($BillArray[$bill_id] -> bill_type_display === NULL)
                    unset ($BillArray[$bill_id]);
                
                
            }
        }
                
        return $BillArray;
    }
    
}

?>