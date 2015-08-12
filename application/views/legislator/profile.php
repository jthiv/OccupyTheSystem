<?PHP

if($this->displayPage==false){
    echo "<h2>No Politician Selected</h2><hr>This profile cannot be loaded because you have not selected a politician!";
}else{
    //Shorten control variable names
    $obj_politician_data = $this->obj_politician_data;
    $arr_recent_vote_history = $this->arr_recent_voting_history;
    
    
    $arr_threads = $this -> threads;
    if(count($arr_threads) > $this -> quantity)
    $arr_threads = array_slice($arr_threads, 0, $this -> quantity);
    
    echo "<h2>".$obj_politician_data->job_title.". ".$obj_politician_data->name_first." ".$obj_politician_data->name_last."</h2>";
    echo "<hr>";
    
    // Below is the old date management
    //echo "Term Began: ".$obj_politician_data->job_term_start." <span style='float: right;'>Term Ends: ".$obj_politician_data->job_term_end."</span><br /><br />";
    echo "<div id = 'completionBarContainer'>";
    echo "<div id = 'termTitleBar'><span id = 'completionTitle'> Term Completion </span></div>";
    echo "<div id = 'termCompletionBar'>";
    echo "<div id = 'completedFill' style = 'width:" . $this -> term_completion_bar -> percentComplete . "%;'></div>";       
    echo "</div>";
    echo "<div id = 'labels'>";
    echo "<span id = 'leftLabel'>" . $this  -> term_completion_bar -> startDateStr . "</span>";
    echo "<span id = 'rightLabel'>" . $this  -> term_completion_bar -> endDateStr . "</span>";
    echo "</div>";
    echo "</div>";
    
    
    
    
    echo "<div id='ContactVoteWrapper'>";
    
    echo "<div id='politicianContact'>";
        echo "<img src='".$obj_politician_data->pic_link."' style='float: left; width: 175px; padding-right: 5px;' />";
        echo "<h3>Contact Information:</h3>";
        echo "<strong>Phone:</strong> ".$obj_politician_data->contact_phone."<br />";
        echo "<strong>Website:</strong> ".$obj_politician_data->contact_website."<br />";
        echo "<strong>Office:</strong> ".$obj_politician_data->contact_office."<br />";
        echo "<strong>Contact Form:</strong> ".$obj_politician_data->contact_contact_form."<br />";
        echo "<strong>Fax:</strong> ".$obj_politician_data->contact_fax."<br />";
    echo "</div>";
    
    echo "<div id='recentVoting'>";
        echo "<h2>Recent Votes</h2>";
        echo "<hr>";
        echo "<table class='recentVotesTable'>";
        foreach($arr_recent_vote_history as $vote){
            echo "<tr>";
            echo "<td><a href='".URL."congress/votes/".$vote['congress']."/".$vote['roll_id']."'><strong>Voted:</strong> ".$vote['roll_vote']."<br /><em>".$vote['roll_question']."</em></a></td>";
            echo "</tr>";
        }
        echo "</table>";
    echo "</div>";
    
    echo "<div style='clear: left;'></div>";
    echo "</div>";
    
    echo "<h2>Community</h2>";
    echo "<hr>";
    if (Session::get('user_logged_in') == true)
    {
		echo "<div id='addThreadTableLink'>Click Here to add a thread!</div>";
        echo "<form method='post' action='".URL."community/createThread/2'><input type='hidden' name='politician_id' value='".$obj_politician_data->politician_id."' />";
        echo "<table id='addThreadTable'>";
        echo "<tr>";
		echo "<td colspan='2' style='text-align: center'>Add a thread:</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Title:</td><td><input type='text' name='thread_title' /></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>Text:</td><td><textarea name='thread_text' placeholder='Please be sure to read the etiquette before posting.'></textarea></td>";
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
		. "legislator/profile/"
		. $this -> politician_id . "/"
		. ($this -> page - 1) . "/"
		. ($this -> quantity)
		. "' class = 'button'>Previous</a>";
	    echo "<span> </span>";	
	}
	
	if(count($arr_threads) > 0 && count($this -> threads) > $this -> quantity)
	{
	   echo "<a href = '" . URL
		. "legislator/profile/"
		. $this -> politician_id . "/"
		. ($this -> page + 1) . "/"
		. $this -> quantity
		. "' class = 'button'> Next </a>";
	}
	echo "</div>";
        }
    }  
    
}
?>
<script>
$("#addThreadTableLink").click(function() {
		 $(addThreadTable).toggle( "slow");
	});
</script>