<?PHP

//Get Bill info
$bill = $this->objBillInfo;
$arr_threads = $this -> threads;
if(count($arr_threads) > $this -> quantity)
    $arr_threads = array_slice($arr_threads, 0, $this -> quantity);

//sponsor Info
$sponsor_info = new LegislatorInfo($bill->sponsor_id);
$this->renderFeedbackMessages();
echo "<div class='billStatusBox'>";
    echo "<table>";
        echo "<tr>";
        echo "<th colspan=2><h2>Important Information</h2></th>";
        echo "</tr>";
        echo "<tr>";
            echo "<td>";
				echo "<strong>Introduced:</strong><br />".$bill->introduced_on;
			echo "</td>";
            echo "<td rowspan=2><strong>Status:</strong><br /><img src='".$bill->status_image1."' /><img src='".$bill->status_image2."' /><img src='".$bill->status_image3."' /><img src='".$bill->status_image4."' /><img src='".$bill->status_image5."' /></td>";
        echo "</tr>";
		echo "<tr>";
		echo "<td><strong>Users in Support:</strong> ".$this->intUserSupportCount->stance_count."<br /><strong>Users Opposed:</strong> ".$this->intUserOpposeCount->stance_count."</td>";
		echo "</tr>";
    echo "</table>";
echo "</div>";

echo "<h2>".$bill->bill_type_display.$bill->number."</h2>";
echo "<hr>";
echo $bill->official_title;

echo "<div id='bill_stance_moreInfo_wrapper'>";
    echo "<div id='bill_stance'>";
        echo "<h2>Take a Stand</h2><hr>";
        echo "<span class='helpText'>Below you may view stances users have taken on this bill. You may add your support to a stance or create your own.</span>";
		if (Session::get('user_logged_in') == true)
		{
			if(!$this->userHasStance)
			{
			echo "<form method='post' action='".URL."congress/_addStance/".$bill->bill_id."'>";
			echo "<textarea name='stanceDefend' id='stanceDefend' style='width: 440px; height: 50px;' placeholder='Defend your position then click Support or Oppose'></textarea>";
			echo "<button type='submit' style='border: 0; background: transparent;' name='support' class='stanceButtons'><img src='".URL."public/img/bill_support.png' /></button>";
			echo "<button type='submit' style='border: 0; background: transparent;' name='oppose' class = 'stanceButtons'><img src='".URL."public/img/bill_against.png' /></button>";
			echo "</form>";
			}else{
				echo "<center>You have already taken a stance! <br /><br /><a href='".URL."congress/_addStanceRequest/".$bill->bill_id."' onclick=\"return confirm('Are you sure? When you click OK anyone following you will be asked to take a stance.')\">Invite your fans to join you.</a><br />-OR-<br /><a href='".URL."congress/_removeStance/".$bill->bill_id."' onclick=\"return confirm('Are you sure?')\">Reset Stance</a></center>";
			}
		}else{
			echo "<em><a href='".URL."login/index'>Login</a> or <a href='".URL."login/register'>register</a> to take a stance on this bill.</em>";
		}
    echo "</div>";
    
    echo "<div id='more_info'>";
        echo "<h2>More Information</h2><hr>";
        echo "<a href='".URL."congress/bill/".$bill->bill_id."/view'>View Bill Text</a><br /><br />";
        echo "<a href='".URL."congress/bill/".$bill->bill_id."/sponsor'>View Bill Sponsors</a><br /><br />";
		echo "<a href='".URL."congress/bill/".$bill->bill_id."/stances'>View User Stances</a><br /><br />";
    echo "</div>";
	echo "<div style='clear: both;'></div>";
echo "</div>";

echo "<h2>Community</h2><hr>";
if (Session::get('user_logged_in') == true)
    {
		echo "<div id='addThreadTableLink'>Click Here to add a thread!</div>";
        echo "<form method='post' action='".URL."community/createThread/3'><input type='hidden' name='bill_id' value='".$bill->bill_id."' />";
        echo "<table id='addThreadTable'>";
        echo "<tr>";
		echo "<td colspan='2' style='text-align: center'>Add a thread:</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Title:</td><td><input type='text' name='thread_title' /></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>Text:</td><td><textarea name='thread_text' id='thread_text' placeholder='Please be sure to read the etiquette before posting.'></textarea></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td colspan='2' style='text-align: center;'><input type='submit' class='button' value='Add Thread' /></td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
    }else{
        echo "<a href='".URL."login'>Login</a> or <a href='".URL."login/register'>Register</a> to create a thread.<br /><br />";
    }
    if(count($arr_threads)==0){
        echo "There are no threads to show!";
    }else{
        foreach($arr_threads as $thread)
        {
            $score = $thread->votes_up - $thread->votes_down;
            echo "<div class='thread'>";
            echo "<table>";
            echo "<tr>";
            switch($thread->vote_value)
            {
                case 'up':
                    $up_image="up_voted";
                    $down_image = "down_vote";
                    break;
                case 'down':
                    $up_image="up_vote";
                    $down_image="down_voted";
                    break;
                default:
                    $up_image="up_vote";
                    $down_image="down_vote";
            }
            echo "<td><a href='".URL."community/_addVote/".$thread->thread_id."/up'><img src='".URL."public/img/".$up_image.".png' border=0/></a><br /><br /><a href='".URL."community/_addVote/".$thread->thread_id."/down'><img src='".URL."public/img/".$down_image.".png' border=0/></a></td>";
            echo "<td>";
            echo "<a href='".URL."community/thread/".$thread->thread_id."' class='threadLink'>".$thread->thread_title."</a>";
            echo "<br />";
            echo "<span class='post_info'>Posted by <a href='#' class='userLink'>".$thread->user_name."</a> Capital(".$score.") ".humanTiming($thread->thread_timestamp);
            if(Session::get('user_logged_in') == true && ($thread->thread_author_user_id == $_SESSION["user_id"] || $_SESSION["user_level"]=='admin'))
            {
                echo "<br /><a href='".URL."community/deleteThread/".$thread->thread_id."'>Delete</a>";
            }
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "</div>";
        
	echo "<div id = 'paginationButtons'>";
	if($this -> page > 1 && count($arr_threads) > 0)
	{
	    echo "<a href = '" . URL
		. "congress/bill/"
		. $bill -> bill_id . "/"
		. ($this -> page - 1) . "/"
		. ($this -> quantity)
		. "' class = 'button'>Previous</a>";
	    echo "<span> </span>";	
	}
	
	if(count($arr_threads) > 0 && count($this -> threads) > $this -> quantity)
	{
	   echo "<a href = '" . URL
		. "congress/bill/"
		. $bill -> bill_id . "/"
		. ($this -> page + 1) . "/"
		. $this -> quantity
		. "' class = 'button'> Next </a>";
	}
    echo "</div>";
	}
    } 

?>
<script>
$( document ).ready(function() {
  $(".stanceButtons").attr('disabled','disabled').css('opacity',0.5);
  $("#stanceDefend").keyup(function(){
	$(".stanceButtons").removeAttr('disabled').css('opacity',1);
  });

	$("#addThreadTableLink").click(function() {
		 $(addThreadTable).toggle("slow");
                 threadText = new nicEditor({buttonList : ['bold','italic','underline','strikeThrough','html','link']}).panelInstance('thread_text');
	});
});
</script>