<?PHP
$objRecentBillActivity = json_decode($this->recentBillActivity);
$arrRecentDiscussions = $this->recentDiscussions;

echo "<h2>Dashboard</h2>";
echo "<hr>";
echo "Welcome to your dashboard. Here you will find relevant material to check out around the site. The content of this page is currently made of recent legislative data and site discussions. Moving forward we will work to make this page as customizable as possible.<br /><br />
<div class='yourPoliticiansBox'><h3>Getting started:</h3><em> This page is currently set to display generic content. The most popular posts, discussions, and bills will appear here. By using the tools in the links below we can start building more customized views for users moving forward.<br /><br />-<a href='../login/editinterests'>Add Interests</a></em></div>";
echo "<div id='dash_wrapper'>";

echo "<div id='dash_interests' class='dash'>";
    echo "<span class='title'><p>Recent Activity</p></span>";
    echo "<div id='dash_interests_contents'>";
    if($objRecentBillActivity){
        $lastDate = null;
        foreach($objRecentBillActivity->results as $action){
            $objBillInfo = new Bill($action->bill_id,json_encode($action));
            $actionDate = new DateTime($objBillInfo->last_action_at);
            $currentDate = $actionDate->format("M d, Y");
            $timestamp = $actionDate->format("g:i:s a");
            if($currentDate != $lastDate){
                echo "<h3>$currentDate</h3>";
            }
            $lastDate = $currentDate;
            echo "<div class='feedItem'>";
            echo "<span class='actionInfo'><a href='".URL."congress/bill/".$objBillInfo->bill_id."'>".$objBillInfo->bill_type_display.$objBillInfo->number." ".$objBillInfo->short_title."</a></span>";
            echo "<span class='billInfo'><p class='header'>Action in Congress:</p> ".$objBillInfo->last_action["text"]."</span>";
            echo "</div>";
        }

    }else{
        echo "<p>No recent legislative activity</p>";
    }
    echo "</div>";
    
echo "</div>";
echo "<div id='dash_discussions' class='dash'>";
    echo "<span class='title'><p>Discussions</p></span>";
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
            echo "<td valign='top'><a href='".URL."community/_addVote/".$thread->thread_id."/up'><img src='".URL."public/img/".$up_image.".png' border=0/></a><br /><br /><a href='".URL."community/_addVote/".$thread->thread_id."/down'><img src='".URL."public/img/".$down_image.".png' border=0/></a></td>";
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
    //END THREAD DISPLAY
echo "</div>";


echo "<div style='clear: both;'></div>";
/*echo "<div id='dash_friends' class='dash'>";
    echo "<span class='title'><p>Friends</p></span>";
     echo "<center><em>-There are no updates to show-</em></center>";
echo "</div>";*/

echo "</div>";
?>
