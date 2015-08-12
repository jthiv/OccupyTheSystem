<?PHP
class RollInfo{
    
    public $roll_id;
    public $chamber;
    public $number;
    public $year;
    public $congress;
    public $voted_at;
    public $vote_type;
    public $vote_type_description;
    public $roll_type;
    public $question;
    public $required;
    public $result;
    public $voter_ids;
    public $bill_id;
	public $nomination_id;
	//Nomination info--if present
	public $nomination;
    
    function __construct($new_congress, $new_roll_id){
        $this->congress = $new_congress;
        $this->roll_id = $new_roll_id;
        
        $this->get_roll_info();
    }
    
    private function get_roll_info(){
	$method = "/votes";
		$params = array();
                    $params[0]=array("name" => "congress",
                                     "value" => $this->congress);
                    $params[1]=array("name" => "roll_id",
                                     "value" => $this->roll_id);
		    $params[2]=array("name" => "fields",
				     "value" => "voter_ids,chamber,number,year,voted_at,vote_type,roll_type,question,required,result,bill_id,bill,nomination_id,nomination");
		$objSunlightResp = new Sunlight($method,$params);

		$jsonSunlightResp = $objSunlightResp->getMethodResponse();
		$arraySunlightResp = json_decode($jsonSunlightResp, true);
		
		foreach($arraySunlightResp['results'] as $vote){
			$this->number = $vote["number"];
			$this->year = $vote["year"];
			$this->chamber = $vote["chamber"];
			$this->voted_at = $vote["voted_at"];
			$this->vote_type = $vote["vote_type"];
		    $this->bill_id = isset($vote["bill_id"]) ? $vote["bill_id"] : "";
			
			//Set nomination variables
			
			if(isset($vote["nomination_id"])){
				$this->nomination_id = $vote["nomination_id"];
				$this->nomination = $vote["nomination"];
				$this->nomination["nomination_of"] = "of ".$this->nomination["nominees"][0]["name"]." to be ".$this->nomination["nominees"][0]["position"];
			}else{
				$this->nomination_id = "";
				$this->nomination = "";
			}
			$this->roll_type = $vote["roll_type"];
			$this->question = $vote["question"];
			$this->required = $vote["required"];
			$this->result = $vote["result"];
			$this->voter_ids = $vote["voter_ids"];
			
		    
		    //Take the vote_type and generate a textual description
		    //TODO: These need to be more in depth
		    switch($this->vote_type){
			case 'passage':
			    $this->vote_type_description = "This is a vote on passage of a bill.";
			    break;
			case 'cloture':
				if($this->bill_id!=""){
					$motion_reference = "a bill";
				} elseif ($this->nomination_id!=""){
					$motion_reference = "the nomination ".$this->nomination["nomination_of"];
				} else {
					$motion_reference = "undefined";
				}
			    $this->vote_type_description =  "This is a vote to end debate on ".$motion_reference.". If a cloture motion is agreed to then debate will end, and a vote will be taken.";
			    break;
			case 'nomination':
			    $this->vote_type_description = "A Vote ".$this->question." ".$this->nomination["nomination_of"];
			    break;
			case 'impeachment':
			    $this->vote_type_description =  "This is a vote on impeachment.";
			    break;
			case 'treaty':
			    $this->vote_type_description =  "This is a vote on a treaty.";
			    break;
			case 'recommit':
			    $this->vote_type_description =  "This is a vote on a motion to recommit.";
			    break;
			case 'quorum':
			    $this->vote_type_description =  "This is a vote on quorum.";
			    break;
			case 'leadership':
			    $this->vote_type_description =  "This is a vote on leadership.";
			    break;
			case 'ammendment':
				$this->vote_type_description = "This is a vote on an amendment.";
			default:
			    $this->vote_type_description =  "This was a procedural vote.";
		    }

		}
    }

}