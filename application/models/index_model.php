<?PHP
class IndexModel{
	public function __construct(Database $db){
		$this->db = $db;
	}
	function getBillStances_Random()
    {
		$stance = new StdClass();
		
        $sql = "SELECT stance.stance_value, 
						stance.stance_text, 
						stance.stance_timestamp,
						stance.bill_id,
						u.user_name
                FROM bill_stances AS stance
                JOIN users AS u ON u.user_id = stance.user_id
                WHERE stance.stance_value = 'support'
                ORDER BY RAND() LIMIT 0,1";
        $query = $this->db->prepare($sql);
        $query->execute();

        // Fetch Support Stances...add to object
        $stance->support = $query->fetchAll();
		
		$sql = "SELECT stance.stance_value, 
						stance.stance_text, 
						stance.stance_timestamp, 
						stance.bill_id,
						u.user_name
                FROM bill_stances AS stance
                JOIN users AS u ON u.user_id = stance.user_id
                WHERE stance.stance_value = 'oppose'
                ORDER BY RAND() LIMIT 0,1";
        $query = $this->db->prepare($sql);
        $query->execute();
		
		//Fetch oppose stances...add to object
		$stance->oppose = $query->fetchAll();
		
		return $stance;
    }
}

?>