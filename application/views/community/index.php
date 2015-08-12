<?PHP
$general_categories = $this->general_categories;
$oped_categories = $this->oped_categories;

$arrRecentDiscussions = $this -> recentDiscussions;
if(count($arrRecentDiscussions) > $this -> quantity)
    $arrRecentDiscussions = array_slice($arrRecentDiscussions, 0, $this -> quantity);

    

?>
<h2>Water Cooler</h2>
<hr>
    <p>The Water Cooler is a place for casual conversation. It is a good place to have debates and share interesting things with other users.</p>
    <div class="yourPoliticiansBox">
    <?PHP
        $counter=0;
        foreach($general_categories as $category)
        {
            if($counter>0)
            {
                echo " - ";
            }
            echo "<a href='".URL."community/category/".$category->category_id."'>".$category->category_name."</a>";
            $counter++;
        }
    ?>
    </div>

<h2>Top Discussions</h2>
<hr>
    <p>These are some of the top discussions going on around the site.</p>
    <div id="threads">
    <?PHP
    //BEGIN THREAD DISPLAY
    if(count($arrRecentDiscussions)==0){
        echo "There are no threads to show!";
    }else{
        foreach($arrRecentDiscussions as $thread)
        {
			//Get Tag info
			if((isset($thread->thread_politician_id)&&!empty($thread->thread_politician_id)) || (isset($thread->thread_bill_id) &&!empty($thread->thread_bill_id))){
				$taggedInfo = "<span style='background-color: #efefef; font-size: 10pt; padding: 2px; margin: 5px;'>";
				if(!empty($thread->thread_politician_id)){
					$tagged_politician_info = new LegislatorInfo($thread->thread_politician_id);
					$taggedInfo .= $tagged_politician_info->name_first." ".$tagged_politician_info->name_last;
				}elseif(!empty($thread->thread_bill_id)){
					$tagged_bill_info = new Bill($thread->thread_bill_id);
					$taggedInfo .= $tagged_bill_info->bill_type_display;
					if(isset($tagged_bill_info->short_title)&&!empty($tagged_bill_info->short_title)){
						$taggedInfo .= " ".$tagged_bill_info->short_title;
					}
				}
				$taggedInfo .="</span>";
			}else{
				$taggedInfo="";
			}
			
            $score = $thread->votes_up - $thread->votes_down;
			
			//Create tag for user level
				$user_level_tag = "<span style='font-size: 10pt; color: red;'>";
				switch($thread->user_level){
					case 'admin':
						$user_level_tag .= "[admin]";
						break;
					case 'mod':
						$user_level_tag = "[mod]";
						break;
					default:
						$user_level_tag = "";
				}
				$user_level_tag .= "</span>";
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
            echo $taggedInfo."<a href='".URL."community/thread/".$thread->thread_id."' class='threadLink'>".$thread->thread_title."</a>";
            echo "<br />";
            echo "<span class='post_info'>Posted by ".$user_level_tag."<a href='../../overview/showuserprofile/".$thread->user_id."' class='userLink'>".$thread->user_name."</a> Capital(".$score.") ".humanTiming($thread->thread_timestamp);
            if(Session::get('user_logged_in') == true && ($thread->thread_author_user_id == $_SESSION["user_id"] || $_SESSION["user_level"]=='admin'))
            {
                echo "<br /><a href='".URL."community/deleteThread/".$thread->thread_id."'>Delete</a>";
            }
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "</div>";
        }
    }
    
    echo "</br>";
    // We are on a page that has posts, and is not the first page
    echo "<div id = 'paginationButtons'>";
	if($this -> page > 1 && count($arrRecentDiscussions) > 0)
	{
	    echo "<a href = '" . URL
		. "community/index/"
		. ($this -> page - 1) . "/"
		. ($this -> quantity)
		. "' class = 'button'>Previous</a>";
	    echo "<span> </span>";	
	}
	
	if(count($arrRecentDiscussions) > 0 && count($this -> recentDiscussions) > $this -> quantity)
	{
	   echo "<a href = '" . URL
		. "community/index/"
		. ($this -> page + 1) . "/"
		. $this -> quantity
		. "' class = 'button'> Next </a>";
	}
    echo "</div>";
    
    //END THREAD DISPLAY
 ?>
    </div>