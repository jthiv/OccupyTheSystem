<h2>Search Bills</h2><hr>
Search through bills by keyword. We will be adding a more in depth search in the future.
<br /><br />
<form method="GET" action="<?PHP echo URL; ?>congress/bill">
Search: <input type="text" name="query" placeholder="" /> <input type="submit" value="Search" />
</form>
<?PHP
if(isset($_GET["query"])){
	$query = $_GET["query"];

	$results = new SearchBill($query);

	echo "Search results for: $query<br /><br />";
	
	foreach($results->results['results'] as $result){
		if(isset($result["short_title"])&&!empty($result["short_title"])){
			$display = "<a href='".URL."congress/bill/".$result["bill_id"]."'>".strtoupper($result["bill_type"]).".".$result["number"]." ".$result["short_title"]."<br/>".$result["official_title"]."</a><br /><br />";
		}else{
			$display = "<a href='".URL."congress/bill/".$result["bill_id"]."'>".strtoupper($result["bill_type"]).".".$result["number"]."<br/>".$result["official_title"]."</a><br /><br />";
		}
		echo $display;
	}
}else{
	echo "<h2>Popular Bills</h2><hr />";
	
	
	$stances = $this->objBillStances;
	echo "<div id='bill_stance_moreInfo_wrapper'>";
	echo "<h2>Recent Stances</h2>";
	echo "<hr>";
	echo "<div>Below are some of the most recent stances taken by users on bills. You can search for bills that you are interested in above, and take a stance yourself!</div>";
	
		echo "<div id='bill_stance'>";
			echo "<h2>Stances in Support</h2><hr>";
			if(empty($stances->support)){
				echo "<em>There are no stances in support of this bill yet!</em>";
			}else{
				
				foreach($stances->support as $stance)
				{
					$billID = substr($stance->bill_id, 0, -4);
					$bill_type = preg_replace('/[0-9]+/', '', $billID);
					$bill_number = preg_replace("/[^0-9,.]/", "", $billID);
					$bill_type = Bill::get_bill_display_type($bill_type);
					echo "<div class='stance'>";
					echo "<span class='supportHeader'>".$stance->user_name." supports <a href='".URL."congress/bill/".$stance->bill_id."'>$bill_type $bill_number</a></span>";
					echo "<p>\"".$stance->stance_text."\"</p>";
					echo "</div>";
				}
			}
		echo "</div>";
		
		echo "<div id='more_info'>";
			echo "<h2>Stances in Opposition</h2><hr>";
			if(empty($stances->oppose)){
				echo "<em>There are no stances in opposition of this bill yet!</em>";
			}else{
				foreach($stances->oppose as $stance)
				{
					$billID = substr($stance->bill_id, 0, -4);
					$bill_type = preg_replace('/[0-9]+/', '', $billID);
					$bill_number = preg_replace("/[^0-9,.]/", "", $billID);
					$bill_type = Bill::get_bill_display_type($bill_type);
					echo "<div class='stance'>";
					echo "<span class='opposeHeader'>".$stance->user_name." opposes <a href='".URL."congress/bill/".$stance->bill_id."'>$bill_type $bill_number</a></span>";
					echo "<p>\"".$stance->stance_text."\"</p>";
					echo "</div>";
				}
			}
		echo "</div>";
		echo "<div style='clear: both;'></div>";
	echo "</div>";
	}
?>
