<?php
/******************************************************************************
 *File: Leader.php
 *Created: February 23, 2011
 *Authors: Joey Hinton, ~~Keitherton was here~~
 *Purpose: This page hosts php scripts to be run on leaders.php
 *
 *
 *To do: 
 *	-Replace display governor with API call
 ******************************************************************************/

class Leaders{
    
    private $state;
    private $district;
    
    function __construct($new_state,$new_district=""){
        $this->state = $new_state;
        $this->district = $new_district;
    }
    
    //Gets an array of senator IDs
    function get_senator_ids(){
	$method = "/legislators";
	$params = array();
		$params[0]=array("name" => "state",
						 "value" => $this->state
						);
		$params[1]=array("name" => "chamber",
						 "value" => "senate"
						);
		$params[2]=array("name" => "in_office",
						 "value" => "true"
						);
		$params[3]=array("name" => "fields",
						 "value" => "bioguide_id"
						);
	try{
	    $obj_sunlight = new Sunlight($method,$params);
	}catch(Exception $e){
	    die("Error getting senator data.");
	}

	$json_sunlight_response = $obj_sunlight->getMethodResponse();
	$array_sunlight_response = json_decode($json_sunlight_response, true);
	
	return $array_sunlight_response;
    }
    //Gets an array of senator IDs
    function get_representative_id(){
	$method = "/legislators";
	$params = array();
		$params[0]=array("name" => "state",
						 "value" => $this->state
						);
		$params[1]=array("name" => "chamber",
						 "value" => "house"
						);
		$params[2]=array("name" => "district",
						 "value" => $this->district
				);
		$params[3]=array("name" => "in_office",
						 "value" => "true"
						);
		$params[4]=array("name" => "fields",
						 "value" => "bioguide_id"
						);
	try{
	    $obj_sunlight = new Sunlight($method,$params);
	}catch(Exception $e){
	    die("Error getting representative data.");
	}

	$json_sunlight_response = $obj_sunlight->getMethodResponse();
	$array_sunlight_response = json_decode($json_sunlight_response, true);
	
	return $array_sunlight_response;
    }
    /*
     Displays information on Senators
     'senCode' returns state and district number, i.e. VA
     'senDesc' returns description, i.e. Virginia Senator
     'senState' returns state, i.e. VA
    */
    /*function display_senators($picSize="medium"){
	$method = "/legislators";
	$params = array();
		$params[0]=array("name" => "state",
						 "value" => $this->state
						);
		$params[1]=array("name" => "chamber",
						 "value" => "senate"
						);
		$params[2]=array("name" => "in_office",
						 "value" => "true"
						);
	$objSenators = new Sunlight($method,$params);

	$jsonSenators = $objSenators->getMethodResponse();
	$arraySenators = json_decode($jsonSenators, true);
	
	$senators=array();
	$senatorCounter=0;
	foreach($arraySenators['results'] as $senator){
		$senators[$senatorCounter] = array("pNameFirst" => $senator["first_name"],
					  "pNameLast" => $senator["last_name"],
					  "pNameMiddle" => $senator["middle_name"],
					  "pNamePreferred" => $senator["nickname"],
					  "jobTitle" => $senator["title"],
					  "picLink" => "none",
					  "pID" => $senator["bioguide_id"]
					  );
		$senatorCounter++;
	}
        return $senators;
        
    }
    
    function display_representative($picSize="medium"){
	$method = "/legislators";
	$params = array();
		$params[0]=array("name" => "state",
						 "value" => $this->state
						);
		$params[1]=array("name" => "chamber",
						 "value" => "house"
						);
		$params[2]=array("name" => "district",
						 "value" => $this->district
						);
		$params[3]=array("name" => "in_office",
						 "value" => "true"
						);
	$objReps = new Sunlight($method,$params);

	$jsonReps = $objReps->getMethodResponse();
	$arrayReps = json_decode($jsonReps, true);
	
	foreach($arrayReps['results'] as $rep){
		$repReturn = array("pNameFirst" => $rep["first_name"],
					  "pNameLast" => $rep["last_name"],
					  "pNameMiddle" => $rep["middle_name"],
					  "pNamePreferred" => $rep["nickname"],
					  "jobTitle" => $rep["title"],
					  "picLink" => "none",
					  "pID" => $rep["bioguide_id"]
					  );
	}
        return $repReturn;
    }*/
    
    /*
     Sets a multidimensional array of all house reps for which ever state is supplied for $this->state
    */
    function display_representatives_state(){
        $method = "/legislators";
	$pageNumber = 1;
	$perPage = 50;
		$params = array();
			$params[0]=array("name" => "state",
							 "value" => $this->state
							);
			$params[1]=array("name" => "chamber",
							 "value" => "house"
							);
			$params[2]=array("name" => "district",
							 "value" => $this->district
							);
			$params[3]=array("name" => "in_office",
							 "value" => "true"
							);
			$params[4]=array("name" => "per_page",
							 "value" => $perPage
							);
			$params[5]=array("name" => "page",
							 "value" => &$pageNumber
							);
		$objReps = new Sunlight($method,$params);
		$jsonReps = $objReps->getMethodResponse();
		$arrayReps = json_decode($jsonReps, true);
		
		while(($arrayReps["count"] - ($perPage * $pageNumber) > 0))
		{
		    $pageNumber++;
		    $jsonReps = $objReps->getMethodResponse();
		    $arrayReps["results"] = array_merge($arrayReps["results"], json_decode($jsonReps, true)["results"]);
		}
		
		$reps=array();
		$repCounter=0;
		foreach($arrayReps['results'] as $rep){
			$reps[$repCounter] = array("pNameFirst" => $rep["first_name"],
						  "pNameLast" => $rep["last_name"],
						  "pNameMiddle" => $rep["middle_name"],
						  "pNamePreferred" => $rep["nickname"],
						  "jobTitle" => $rep["title"],
						  "picLink" => "none",
						  "jobDistrict" => $rep["district"],
						  "pID" => $rep["bioguide_id"]
						  );
			$repCounter++;
		}
		
        return $reps;
        
    }
    
    /*
     Sets a multidimensional array of all senators for which ever state is supplied for $this->state
    */
    function display_senators_state(){
        $method = "/legislators";
		$params = array();
			$params[0]=array("name" => "state",
							 "value" => $this->state
							);
			$params[1]=array("name" => "chamber",
							 "value" => "senate"
							);
			$params[2]=array("name" => "in_office",
							 "value" => "true"
							);
		$objReps = new Sunlight($method,$params);

		$jsonReps = $objReps->getMethodResponse();
		$arrayReps = json_decode($jsonReps, true);
		
		$reps=array();
		$repCounter=0;
		foreach($arrayReps['results'] as $rep){
			$reps[$repCounter] = array("pNameFirst" => $rep["first_name"],
						  "pNameLast" => $rep["last_name"],
						  "pNameMiddle" => $rep["middle_name"],
						  "pNamePreferred" => $rep["nickname"],
						  "jobTitle" => $rep["title"],
						  "picLink" => "none",
						  "pID" => $rep["bioguide_id"]
						  );
			$repCounter++;
		}
        return $reps;
        
    }
    
}
?>