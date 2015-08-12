<?PHP

class Bill{
    
    public $bill_id;
    public $bill_type;
    public $bill_type_display;
    public $number;
    public $congress;
    public $chamber;
    public $introduced_on;
    public $last_action;
    public $last_action_at;
    public $last_vote_at;
    public $last_version_on;
    
    //Titles
    public $official_title;
    public $short_title;
    
    //URLS
    public $url_congress;
    
    //Sponsorships
    public $sponsor_id;
    //Array containing co-sponsor IDs
    public $cosponsor_ids;
    
    //Versions
    public $last_version_url;
	
	//Status Images
	public $history; //This is the history of the bill
	public $status_image1;
	public $status_image2;
	public $status_image3;
	public $status_image4;
	public $status_image5;
    
    function __construct($new_bill_id, $objBill = null, $mini = false){
        $this->bill_id = $new_bill_id;
        if(!$mini)
	    $this->get_bill_info($objBill);
	else
	    $this->get_mini_bill_info($objBill);
    }
    public static function get_bill_display_type($bill_type){
	//Set the bill type for display
	switch($bill_type){
	    case 'hr':
		$type_display = "H.R.";
		break;
	    case 'hres':
		$type_display = "H.Res.";
		break;
	    case 'hjres':
		$type_display = "H.J.Res.";
		break;
	    case 'hconres':
		$type_display = "H.Con.Res";
		break;
	    case 's':
		$type_display = "S.";
		break;
	    case 'sres':
		$type_display = "S.Res.";
		break;
	    case 'sjres':
		$type_display = "S.J.Res.";
		break;
	    case 'sconres':
		$type_display = "S.Con.Res.";
		break;
	    default:
		$type_display = "";
		
	}
	return $type_display;
    }
    
    function get_mini_bill_info($objBill){
	if($objBill)
	{
	    $objAPI = $objBill;
	}
	else
	{
	    $method = "/bills";
	    $params = array();
		    $params[0] = array("name" => "bill_id",
							"value" => $this -> bill_id
				      );
		    $params[1] = array("name" => "fields",
							"value" => "bill_id,bill_type,number,short_title"
			    	      );
		    $objAPI = new Sunlight($method, $params);
	}
	try
        {
                if($objAPI)
                {
                        if($objBill)
                        {
                            $jsonResponse = $objAPI;
                        }
                        else
                        {
                            $jsonResponse = $objAPI->getMethodResponse();
                        }
                        $arrResponse = json_decode($jsonResponse,true);
                        if(!$objBill)
                        {
                            if(count($arrResponse['results']) > 0)
                            {
                            $arrResponse = $arrResponse['results'][0];
                            }
                            else
                            {
                                throw new Exception("API Error: No bill data.");
                            }

                        }
                        $this->bill_type = $arrResponse['bill_type'];
			$this->bill_type_display = $this->get_bill_display_type($this->bill_type);
                        $this->number = $arrResponse['number'];
                        $this->short_title = $arrResponse['short_title'];

		    }
                else
                {
                        throw new Exception("API Error: Invalid response.");
                }
        }
        catch(Exception $e)
        {
                //echo $e->getMessage();
        }
    }
    
    function get_bill_info($objBill){
        if($objBill)
        {
            $objAPI = $objBill;
        }
        else
        {
            $method ="/bills";
            $params = array();
                    $params[0]=array("name" => "bill_id",
                                                     "value" => $this->bill_id
                                                    );
                    $params[1]=array("name" => "fields",
                                                "value" => "bill_id,bill_type,number,congress,chamber,introduced_on,last_action,last_action_at,last_vote_at,last_version_on,official_title,short_title,urls.congress,sponsor_id,cosponsor_ids,last_version.urls.html,history");
            $objAPI = new Sunlight($method,$params);
        }
        try
        {
                if($objAPI)
                {
                        if($objBill)
                        {
                            $jsonResponse = $objAPI;
                        }
                        else
                        {
                            $jsonResponse = $objAPI->getMethodResponse();
                        }
                        $arrResponse = json_decode($jsonResponse,true);
                        if(!$objBill)
                        {
                            if(count($arrResponse['results']) > 0)
                            {
                            $arrResponse = $arrResponse['results'][0];
                            }
                            else
                            {
                                throw new Exception("API Error: No bill data.");
                            }

                        }
                        $this->bill_type = $arrResponse['bill_type'];
			$this->bill_type_display = $this->get_bill_display_type($this->bill_type);
                        $this->number = $arrResponse['number'];
                        $this->congress = $arrResponse['congress'];
                        $this->chamber = $arrResponse['chamber'];
                        $this->introduced_on = $arrResponse['introduced_on'];
                        $this->last_action = $arrResponse["last_action"];
                        $this->last_action_at = $arrResponse['last_action_at'];
                        $this->last_vote_at = $arrResponse['last_vote_at'];
                        if(!empty($arrResponse['last_version_on']))
                        {
                            $this->last_version_on = $arrResponse['last_version_on'];
                        }
                        else
                        {
                            $this->last_version_on = null;
                        }
                        
                        $this->official_title = $arrResponse['official_title'];
                        $this->short_title = $arrResponse['short_title'];
                        $this->url_congress = $arrResponse['urls']['congress'];
                        $this->sponsor_id = $arrResponse['sponsor_id'];
                        $this->cosponsor_ids = $arrResponse['cosponsor_ids'];
                        if(!empty($arrResponse['last_version']['urls']['html']))
                        {
                            $this->last_version_url = $arrResponse['last_version']['urls']['html'];
                        }
                        else
                        {
                            $this->last_version_url = null;
                        }
                        
						$this->history = $arrResponse['history'];
						
						$this->set_status_images();
                }
                else
                {
                        throw new Exception("API Error: Invalid response.");
                }
        }
        catch(Exception $e)
        {
                //echo $e->getMessage();
        }
    }
	
	function set_status_images(){
			$this->status_image1 = URL."public/img/billtrack/bstat_intro1.gif";
			if(isset($this->history["house_passage_result"]) && $this->history["house_passage_result"]=="pass"){
				$house_image_file = "bstat_hpass1.gif";
			}else{
				$house_image_file = "bstat_hpass.gif";
			}
			
			if(isset($this->history["senate_passage_result"])&&$this->history["senate_passage_result"]=="pass"){
				$senate_image_file = "bstat_spass1.gif";
			}else{
				$senate_image_file = "bstat_spass.gif";
			}
			switch($this->chamber){
				case 'house':
					$this->status_image2 = URL."public/img/billtrack/".$house_image_file;
					$this->status_image3 = URL."public/img/billtrack/".$senate_image_file;
					break;
				case 'senate':
					$this->status_image2 = URL."public/img/billtrack/".$senate_image_file;
					$this->status_image3 = URL."public/img/billtrack/".$house_image_file;
					break;
			}
			if($this->history["enacted"]){
				$this->status_image4 = URL."public/img/billtrack/bstat_psign1.gif";
				$this->status_image5 = URL."public/img/billtrack/bstat_law1.gif";
			}else{
				$this->status_image4 = URL."public/img/billtrack/bstat_psign.gif";
				$this->status_image5 = URL."public/img/billtrack/bstat_law.gif";
			}
	}
}

?>