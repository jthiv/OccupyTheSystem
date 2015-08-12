<?php
/************************************************************************************
 *File: sunlightAPI_gs.php
 *Created: October 20, 2013
 *Authors: Joey Hinton
 *Purpose: This page hosts a global class for accessing the Sunlight API
 ************************************************************************************/
class Sunlight{
    
    private $API_KEY;
    private $API_URL_BASE;
    private $method;
    private $params;
    
    function __construct($new_method,$params, $new_URL_BASE = "https://congress.api.sunlightfoundation.com", $new_API_KEY = SUNLIGHT_API_KEY){
		try
		{
			$this->API_KEY = $new_API_KEY;
			$this->API_URL_BASE = $new_URL_BASE;
			$this->method = $new_method;
			if(is_array($params))
			{
				$this->params = $params;
			}
			else
			{
				throw new Exception("Invalid Parameter: Expecting array");
			}
		}
		catch(Exception $e)
		{
			echo "Error initializing wrapper. <br />Message:".$e->getMessage();
		}
		
		
    }
	public function getMethodResponse(){
		//Build Service URL with method and API KEY
		$service_url = $this->API_URL_BASE.$this->method."?apikey=".$this->API_KEY;
			//Add parameters to the URL
			foreach($this->params as $singleParam){
				$service_url .= "&".$singleParam["name"]."=".$singleParam["value"];
			}
			//echo $service_url;
		
		try
		{
			$curl = curl_init($service_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$curl_response = curl_exec($curl);
			curl_close($curl);
		}
		catch(Exception $e)
		{
			return false;
		}
		
		return $curl_response;
		
	}
}
/********************************************************
PROOF OF CONCEPT

$method ="/legislators";
$params = array();
	$params[0]=array("name" => "state",
					 "value" => "VA"
					);
	$params[1]=array("name" => "chamber",
					 "value" => "senate"
					);
	$params[2]=array("name" => "in_office",
					 "value" => "true"
					);
$objAPI = new Sunlight($method,$params);
try
{
	if($objAPI)
	{
		$jsonResponse = $objAPI->getMethodResponse();
		$arrResponse = json_decode($jsonResponse,true);
	}
	else
	{
		throw new Exception("API Error: Invalid response.");
	}
}
catch(Exception $e)
{
	echo $e->getMessage();
}
********************************************************/


?>