<?PHP

//Get Bill info
$bill = $this->objBillInfo;

//sponsor Info
$sponsor_info = new LegislatorInfo($bill->sponsor_id);

echo "<a href='".URL."congress/bill/".$bill->bill_id."'><--Return to Bill Overview</a><br /><br />";
echo "<h2>".$bill->bill_type_display.$bill->number." Sponsors and cosponsors</h2>";
echo "<hr>";
echo "In Congress a bill must have a sponsor. This is a senator or representative who introduces a bill is the chief advocate. A senator or representative may also add his or her name to a bill and become a <em>cosponsor</em>. The sponsors and cosponsors for this bill are as follows:";

echo "<table class='sponsorTable'>";
echo "<tr>";
echo "<td valign=top><strong>Sponsor:</strong><br /></td>";
echo "<td><a href='".URL."legislator/profile/".$sponsor_info->politician_id."'>".$sponsor_info->job_title.". ".$sponsor_info->name_first." ".$sponsor_info->name_last."</a>(".$sponsor_info->state.")<br /><img src='".$sponsor_info->pic_link_small."' /></td>";
echo "</tr>";
echo "</table>";
echo "<table>";
echo "<tr>";
echo "<td valign=top colspan=4><strong>Cosponsors:</td>";
echo "</tr>";
echo "<tr>";
    $count = 0;
    foreach($bill->cosponsor_ids as $cosponsor){
        $cosponsor_info = new LegislatorInfo($cosponsor);
        if(!empty($cosponsor_info->name_first))
        {
            echo "<td style='text-align: center; padding-bottom: 25px;'><a href='".URL."legislator/profile/".$cosponsor_info->politician_id."'>".$cosponsor_info->job_title.". ".$cosponsor_info->name_first." ".$cosponsor_info->name_last."</a>(".$cosponsor_info->state.")<br /><img src='".$cosponsor_info->pic_link_small."' /></td>";
            if($count==3){
                $count=0;
                echo "</tr><tr>";
            }else{
                $count++;
            }
        }
    }
echo "</tr>";
echo "</table>";

?>