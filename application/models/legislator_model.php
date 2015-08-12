<?PHP

class LegislatorModel{
    function __construct(){
    }
    function findPoliticians($new_query){
        $method = "/legislators";
	$params = array();
		$params[0]=array("name" => "query",
						 "value" => $new_query
						);
	try{
	    $obj_sunlight = new Sunlight($method,$params);
	}catch(Exception $e){
	    die("Error getting data!");
	}

	$json_sunlight_response = $obj_sunlight->getMethodResponse();
        
        return $json_sunlight_response;
    }
    function get_politician_data($new_politician_id){
        $obj_politician_data = new LegislatorInfo($new_politician_id);
        
        return $obj_politician_data;
    }
    function get_politician_vote_history($new_politician_id, $new_vote_history_limit=0){
        $obj_vote_history = new LegislatorVotingHistory($new_politician_id, $new_vote_history_limit);
        $arr_vote_history = $obj_vote_history->arr_vote_history;
        
        return $arr_vote_history;
    }
    
    function get_reps_by_state($new_state){
        $leaders = new Leaders($new_state);
        $arr_reps_raw = $leaders->display_representatives_state();
	// Sorts by Job District automatically. Other sorts available. See class.
        $arr_reps_sorted = Sorter::jobDistrictSort($arr_reps_raw);
        return $arr_reps_sorted;
    }
    function get_senators_by_state($new_state){
        $leaders = new Leaders($new_state);
        $arr_reps = $leaders->display_senators_state();
        return $arr_reps;
    }
    
    function get_term_comepletion_bar($obj_politican_data)   // New function
    {
	$completion_bar = new LoadingBar($obj_politican_data -> job_term_start, $obj_politican_data -> job_term_end);
	
	return $completion_bar;
    }

}
?>
