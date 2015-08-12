<?PHP
$roll = $this->objRollInfo;

//Get Politician IDs pertaining to user to display how their politicians voted
    if (Session::get('user_logged_in') == true)
    {
    $user_politician_obj = new Leaders($_SESSION["user_state"], $_SESSION["user_district"]);
    
    //Find which chamber to determine which politician_ids to search for
    switch($roll->chamber){
            case 'senate':
                $user_politician_ids = $user_politician_obj->get_senator_ids();
                break;
            case 'house':
                $user_politician_ids = $user_politician_obj->get_representative_id();
                break;    
        }
    }
echo "<h2>".ucfirst($roll->chamber)." Vote ".$roll->roll_type."</h2>";
echo "<hr>";
echo $roll->vote_type_description;

//If this vote is associated with a bill display the bill
if(!empty($roll->bill_id)){
    $assoc_bill_info = new Bill($roll->bill_id);
    echo "<div class='associatedBillBox'>";
    echo "<h2>Associated Bill</h2>";
    echo "<span class='helpText'>This vote is associated with the following bill:</span><br />";
    echo "<a href='".URL."congress/bill/".$assoc_bill_info->bill_id."'>".$assoc_bill_info->bill_type_display.$assoc_bill_info->number." ".$assoc_bill_info->short_title."</a>";;
    echo "</div>";
}


echo "<div id='rollVote_info_myPoliticians_wrapper'>";
    echo "<div id='rollVote_info'>";
    echo "<h2>Important Information</h2><hr>";
    echo "<strong>Result:</strong>". $roll->result."<br /><br />";
    echo "<strong>Type of Vote:</strong> ".$roll->roll_type."<br /><br />";
    echo "<strong>Vote Took Place:</strong>  ".$roll->voted_at."<br /><br />";
    echo "<strong>Votes Required to Pass:</strong>  ".$roll->required."<br />";
    echo "</div>";
    
    echo "<div id='rollVote_myPoliticians'>";
    echo "<h2>My Politicians</h2><hr>";
    if (Session::get('user_logged_in') == true)
    {
    echo "Below is a breakdown of how your politicians voted.<br /><br />";
    //Loop through politicians and display how they voted
    echo "<table style='width: 100%; text-align: center;'>";
    echo "<tr>";
        foreach($user_politician_ids['results'] as $politician){
            $politician = new LegislatorInfo($politician['bioguide_id']);
            echo "<td valign=top>";
            echo "<a href='".URL."legislator/profile/".$politician->politician_id."'>".$politician->name_first. " ".$politician->name_last."</a>";
            echo "<br /><img src='".$politician->pic_link_small."' style='height: 50%; width: 50%;'/>";
            echo "<br />Voted: ".$roll->voter_ids[$politician->politician_id];
            echo "</td>";
        }
    echo "</tr>";
    echo "</table>";
    }
    else
    {
        echo "<a href='".URL."login'>Login</a> or <a href='".URL."login/register'>Register</a> to see this information.<br /><br />";
    }
    echo "</div>";
    
    echo "<div style='clear: both;'>";
echo "</div>";

?>