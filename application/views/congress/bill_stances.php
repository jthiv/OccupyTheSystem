<?PHP
$bill = $this->objBillInfo;

$stances = $this->objBillStances;
echo "<a href='".URL."congress/bill/".$bill->bill_id."'><--Return to Bill Overview</a>";
echo "<h2>Stances for ".$bill->bill_type_display.$bill->number."</h2>";
echo "<hr>";
echo $bill->official_title;

echo "<div id='bill_stance_moreInfo_wrapper'>";
    echo "<div id='bill_stance'>";
        echo "<h2>Stances in Support</h2><hr>";
		if(empty($stances->support)){
			echo "<em>There are no stances in support of this bill yet!</em>";
		}else{
			foreach($stances->support as $stance)
			{
				echo "<div class='stance'>";
				echo "<span class='supportHeader'>".$stance->user_name." supports ".$bill->bill_type_display.$bill->number."</span>";
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
				echo "<div class='stance'>";
				echo "<span class='opposeHeader'>".$stance->user_name." opposes ".$bill->bill_type_display.$bill->number."</span>";
				echo "<p>\"".$stance->stance_text."\"</p>";
				echo "</div>";
			}
		}
    echo "</div>";
	echo "<div style='clear: both;'></div>";
echo "</div>";
?>