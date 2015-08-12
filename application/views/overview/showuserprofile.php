<div class="content">
    <?php $this->renderFeedbackMessages(); ?>
    <?php
    $arr_threads = $this->userDiscussion;
    if (!$this->user) {
        echo "<h2>Error</h2><hr>User not found.";
    }else{
        echo "<h2>".$this->user->user_name."'s Profile</h2>";
        echo "<hr>";
        
        //If user is logged in...and this isn't their profile: Give them friend options
        if(Session::get('user_logged_in') == true && ($this->user->user_id != $_SESSION["user_id"]))
        {
            if(!$this->user->user_is_followed)
            {
                echo "<input type='button' id='followButton' onclick=\"followUser(".$this->user->user_id.",'".$this->user->user_name."')\" class='button' value='Follow ".$this->user->user_name."' />";
            }
            else
            {
                echo "<input type='button' id='followButton' onclick=\"unfollowUser(".$this->user->user_id.",'".$this->user->user_name."')\" class='button' value='Unfollow ".$this->user->user_name."' />";
            }
        }
        
        
    }
    echo "<div id='threads'>";
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
            echo "<td valign='top'><a href='".URL."community/_addVote/".$thread->thread_id."/up'><img src='".URL."public/img/".$up_image.".png' border=0/></a><br /><br /><a href='".URL."community/_addVote/".$thread->thread_id."/down'><img src='".URL."public/img/".$down_image.".png' border=0/></a></td>";
            echo "<td>";
            if($thread->thread_parent_id != NULL)
            {
                echo "Commented in <a href='".URL."community/thread/".$thread->thread_parent_id."' class='threadLink'>".$thread->parent_thread_title."</a>";
            }
            else
            {
                echo "<a href='".URL."community/thread/".$thread->thread_id."' class='threadLink'>".$thread->thread_title."</a>";
            }
            echo "<br />";
            if($thread->thread_parent_id != NULL)
            {
                echo "<div style='margin-bottom: 2px; margin-left: 8px; background-color: #cee4ea;'><em>\"".$thread->thread_text ."\"</em></div>";
            }
            echo "<span class='post_info'>Posted by <a href='#' class='userLink'>".$thread->user_name."</a> Capital(".$score.") ".humanTiming($thread->thread_timestamp);
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
    ?>
</div>
</div>
<script>
    
    function followUser(userID, username) {
        var url = "../../login/_addUserToFollow/"+userID;
            try{
            $.getJSON(url)
            .done(function(data) {
                data = JSON.parse(data);
                if (data['success']) {
                    $("#followButton").attr('value', 'Unfollow '+username).attr('onclick', 'unfollowUser('+userID+',\''+username+'\')');
                }else{
                    alert("Error following user.");
                }
            })
            .fail(function() {alert("Error");});
            }catch(e){
                console.log(e);
            }
    }
    
    function unfollowUser(userID, username) {
        var url = "../../login/_addUserToFollow/"+userID+"/true";
            try{
            $.getJSON(url)
            .done(function(data) {
                data = JSON.parse(data);
                if (data['success']) {
                    $("#followButton").attr('value', 'Follow '+username).attr('onclick', 'followUser('+userID+',\''+username+'\')');
                }else{
                    alert("Error following user.");
                }
            })
            .fail(function() {alert("Error");});
            }catch(e){
                console.log(e);
            }
    }
</script>