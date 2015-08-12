<?PHP

class SearchBill{
	public $query;
	public $results;
	
	function __construct($new_query){
		$this->query = $new_query;
		$this->results = $this->get_results();
	}
	
	function get_results(){
		$method ="/bills/search";
		$params = array();
			$params[0]=array("name" => "query",
							 "value" => urlencode($this->query)
							);
			$params[1]=array("name" => "fields",
							 "value" => "bill_id,bill_type,number,congress,official_title,short_title"
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
		return $arrResponse;
	}
}

?>