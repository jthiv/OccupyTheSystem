<?PHP

//Get Bill info
$bill = $this->objBillInfo;

$bill_contents = file_get_contents($bill->last_version_url);
echo "<a href='".URL."congress/bill/".$bill->bill_id."'><--Return to Bill Overview</a>";
echo $bill_contents;
