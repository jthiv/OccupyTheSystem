<?PHP
class DistrictInfo{
	public $lat;
	public $long;
	public $state;
	public $district;

    
    function __construct($new_lat, $new_long){
        $this->lat = $new_lat;
	$this->long = $new_long;
	
	$this->get_district_info();
        
    }
    
    //Retreives district information on the lat long
    private function get_district_info(){
	$method ="/districts/locate";
        $params = array();
                $params[0]=array("name" => "latitude",
                                                 "value" => $this->lat
                                                );
                $params[1]=array("name" => "longitude",
                                                 "value" => $this->long
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

		foreach($arrResponse['results'] as $info){
                    $this->state = $info['state'];
                    $this->district = $info['district'];
		}
    }

}

?>