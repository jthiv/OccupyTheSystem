<?PHP
class LegislatorVotingHistory{
    
    public $arr_vote_history;
    
    function __construct($new_politician_id, $new_history_limit=0){
        $this->politician_id = $new_politician_id;
	
	$this->arr_vote_history = $this->get_voting_history($new_history_limit);
        
    }
    
    /*
     Returns a multi-dimensional array of roll IDs for a politician
     To return last 'n' votes supply 'n' as parameter:
     Last five votes -- getVoteHistory(5);
    */
    private function get_voting_history($getTop=0){
        $method ="/votes";
        $params = array();
                $params[0] = array("name" => "voter_ids.".$this->politician_id."__exists",
                                                 "value" => "true"
                                                );
		$params[1] = array("name" => "vote_type",
                                                 "value" => "passage"
                                                );
                $params[2] = array("name" => "fields",
                                                 "value" => "title,question,number,year,voted_at,roll_id,roll_type,voter_ids.".$this->politician_id.",bill.bill_id,bill.official_title,chamber,congress"
                                                );
                if($getTop>0)
                {
                        $params[3] = array("name" => "per_page",
                                                         "value" => $getTop
                                                        );
                }

        $objAPI = new Sunlight($method,$params);
        try
        {
                if($objAPI)
                {
                        $jsonResp = $objAPI->getMethodResponse();	//Get jSON response from API
                        $arrResp = json_decode($jsonResp,true);	//Turn jSON into ARRAY
                        
                        //Iterate Through response array and build a more useful one.
                        $respCounter=0;
                        $voteInfo=array();
                        foreach($arrResp['results'] as $response){
                                $voteInfo[$respCounter] = array("roll_id" => $response["roll_id"],
								"roll_number" => $response["number"],
                                                                "roll_year" => $response["year"],
                                                                "vote_date" => $response["voted_at"],
                                                                "roll_type" => $response["roll_type"],
                                                                "roll_question" => $response["question"],
                                                                "roll_vote" => $response["voter_ids"][$this->politician_id],
                                                                "bill_id" => isset($response["bill"]["bill_id"]) ? $response["bill"]["bill_id"] : null,
                                                                "bill_official_title" => isset($response["bill"]["official_title"]) ? $response["bill"]["official_title"] : null,
                                                                "chamber" => $response["chamber"],
                                                                "congress" => $response["congress"]);
                                $respCounter++;
                                                                
                        }
                        
                        return $voteInfo;
                        
                }
                else
                {
                        throw new Exception("API Error: Invalid response.");
                }
        }
        catch(Exception $e)
        {
                return false;
        }
    }

}
?>
