<?PHP
class UpcomingBills{
    //Biographical Information
	public $chamber;
	
    
    function __construct($new_chamber){
        $this->chamber = $new_chamber;   
    }
    
    //Retreives biographical information on legislator
    private function get_bills(){
	$method = "/legislators";
		$params = array();
			$params[0]=array("name" => "bioguide_id",
							 "value" => $this->politician_id
							);
		$objRep = new Sunlight($method,$params);

		$jsonRep = $objRep->getMethodResponse();
		$arrayRep = json_decode($jsonRep, true);
		
		foreach($arrayRep['results'] as $rep){
                    $this->name_first = $rep["first_name"];
                    $this->name_middle = $rep["middle_name"];
                    $this->name_last = $rep["last_name"];
		    $this->name_nickname = $rep["nickname"];
		    
		    $this->contact_phone = isset($rep["phone"]) ? $rep["phone"] : "Not Available";
		    $this->contact_website = isset($rep["website"]) ? $rep["website"] : "Not Available";
		    $this->contact_office = isset($rep["office"]) ? $rep["office"] : "Not Available";
		    $this->contact_contact_form = isset($rep["contact_form"]) ? $rep["contact_form"] : "Not Available";
		    $this->contact_fax = isset($rep["fax"]) ? $rep["fax"] : "Not Available";
		    
		    $this->job_title = $rep["title"];
		    if(array_key_exists('district', $rep)){
			$this->job_district = $rep["district"];
		    }else{
			$this->job_district = "";
		    }
		    $this->job_term_start = $rep["term_start"];
		    $this->job_term_end = $rep["term_end"];
		    
		    $this->party = $rep["party"];
		    //This is deprecated...don't use it. Use
		    $this->pic_link = "http://bioguide.congress.gov/bioguide/photo/".$this->politician_id[0]."/".$this->politician_id.".jpg";
		    //These are better links...don't need to resize
		    $this->pic_link_small = "http://theunitedstates.io/images/congress/225x275/".$this->politician_id.".jpg";
		    $this->pic_link_medium = "http://theunitedstates.io/images/congress/450x550/".$this->politician_id.".jpg";
		    $this->pic_link_large = "http://theunitedstates.io/images/congress/original/".$this->politician_id.".jpg";
		    $this->twitter_id = $rep["twitter_id"];
		    $this->govtrack_id = $rep["govtrack_id"];

		}
    }

}
?>