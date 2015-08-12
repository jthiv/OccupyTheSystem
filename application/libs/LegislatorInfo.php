<?PHP
class LegislatorInfo{
    //Biographical Information
	public $politician_id;
	
	public $name_first;
	public $name_middle;
	public $name_last;
	public $name_nickname;
	
	public $contact_phone;
	public $contact_website;
	public $contact_office;
	public $contact_contact_form;
	public $contact_fax;
	
	public $state;
	
	public $job_title;
	public $job_district;
	public $job_term_start;
	public $job_term_end;
	
	public $party;
	public $pic_link;//This is no longer used. Use the sized images below
	public $pic_link_small;
	public $pic_link_medium;
	public $pic_link_large;
	public $twitter_id;
	public $govtrack_id;
    
    function __construct($new_politician_id){
        $this->politician_id = $new_politician_id;
	
	$this->get_bio_info();
        
    }
    
    //Retreives biographical information on legislator
    private function get_bio_info(){
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
		    
		    $this->state = $rep["state"];
		    
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