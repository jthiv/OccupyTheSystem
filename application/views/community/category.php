<?PHP
$arr_threads = $this -> threads;
if(count($arr_threads) > $this->quantity)
	$arr_threads = array_slice($arr_threads, 0, $this -> quantity);
?>
<a href="<?PHP echo URL; ?>community"><--Back To Community</a>
<h2><?php echo $this->category_info->category_name; ?></h2>
<hr>
<?PHP
if(isset($this->category_info->category_description)&&!empty($this->category_info->category_description)){
	echo $this->category_info->category_description."<br /><br />";
}
?>
<div id="threads">
    <?PHP
    if (Session::get('user_logged_in') == true)
    {
        switch($this->category_info->category_id)
        {
            case '2':
                echo "To write an Op-Ed about a specific <a href='".URL."legislator'>legislator</a> please do so from their profile.";
                break;
	    case '3':
		echo "To write an Op-Ed about a specific <a href='".URL."congress/bill'>bill</a> please do so from the bill overview page.";
		break;
	    case '5':
	    case '6':
		echo "<div id='addThreadTableLink'>Click Here to add a thread!</div>";
                echo "<form method='post' action='".URL."community/createThread/".$this->category_info->category_id."'>";
                echo "<table id='addThreadTable'>";
                echo "<tr>";
                echo "<td colspan='2' style='text-align: center'>Add a thread:</td>";
                echo "</tr>";
		echo "<tr>";
		echo "<td valign='top'>URL:</td><td><input type='text' id='thread_link' name='thread_link' maxlength='250' /><input type='button' id='loadUrl' name='load' value='Load' class='button' /></td>";
		echo "</tr>";
                echo "<tr>";
                echo "<td>Title:</td><td><input type='text' id='thread_title' name='thread_title' maxlength='250' /></td>";
                echo "</tr>";
				echo "<tr>";
					echo "<td>Text:</td><td><textarea id='thread_text' name='thread_text' placeholder='Please be sure to read the etiquette before posting.'></textarea></td>";
				echo "</tr>";
                echo "<tr>";
                echo "<td colspan='2' style='text-align: center;'><input type='submit' class='button' value='Add Thread' /></td>";
                echo "</tr>";
                echo "</table>";
                echo "</form>";
		break;
            default:
				echo "<div id='addThreadTableLink'>Click Here to add a thread!</div>";
                echo "<form method='post' action='".URL."community/createThread/".$this->category_info->category_id."'>";
                echo "<table id='addThreadTable'>";
                echo "<tr>";
                echo "<td colspan='2' style='text-align: center'>Add a thread:</td>";
                echo "</tr>";
		echo "<tr>";
		echo "<td valign='top'>URL:</td><td><input type='text' id='thread_link' name='thread_link' maxlength='250' /><input type='button' id='loadUrl' name='load' value='Load' class='button' /></td>";
		echo "</tr>";
                echo "<tr>";
                echo "<td>Title:</td><td><input type='text' id='thread_title' name='thread_title' maxlength='250' /></td>";
                echo "</tr>";
				echo "<tr>";
					echo "<td>Text:</td><td><textarea id='thread_text' name='thread_text' placeholder='Please be sure to read the etiquette before posting.'></textarea></td>";
				echo "</tr>";
                echo "<tr>";
                echo "<td colspan='2' style='text-align: center;'><input type='submit' class='button' value='Add Thread' /></td>";
                echo "</tr>";
                echo "</table>";
                echo "</form>";
                
        }
    }else{
        echo "<a href='".URL."login'>Login</a> or <a href='".URL."login/register'>Register</a> to create a thread.<br /><br />";
    }
    if(count($arr_threads)==0){
        echo "There are no threads to show!";
    }else{
        foreach($arr_threads as $thread)
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
    
    echo "<div id = 'paginationButtons'>";
	if($this -> page > 1 && count($arr_threads) > 0)
	{
	    echo "<a href = '" . URL
		. "community/index/"
		. ($this -> page - 1) . "/"
		. ($this -> quantity)
		. "' class = 'button'>Previous</a>";
	    echo "<span> </span>";	
	}
	
	if(count($arr_threads) > 0 && count($this -> threads) > $this -> quantity)
	{
	   echo "<a href = '" . URL
		. "community/index/"
		. ($this -> page + 1) . "/"
		. $this -> quantity
		. "' class = 'button'> Next </a>";
	}
    echo "</div>";
    ?>
</div>

<script type="text/javascript">
    jQuery.ajax=function(e){function o(e){return!r.test(e)&&/:\/\//.test(e)}var t=location.protocol,n=location.hostname,r=RegExp(t+"//"+n),i="http"+(/^https/.test(t)?"s":"")+"://query.yahooapis.com/v1/public/yql?callback=?",s='select * from html where url="{URL}" and xpath="*"';return function(t){var n=t.url;if(/get/i.test(t.type)&&!/json/i.test(t.dataType)&&o(n)){t.url=i;t.dataType="json";t.data={q:s.replace("{URL}",n+(t.data?(/\?/.test(n)?"&":"?")+jQuery.param(t.data):"")),format:"xml"};if(!t.success&&t.complete){t.success=t.complete;delete t.complete}t.success=function(e){return function(t){if(e){e.call(this,{responseText:(t.results[0]||"").replace(/<script[^>]+?\/>|<script(.|\s)*?\/script>/gi,"")},"success")}}}(t.success)}return e.apply(this,arguments)}}(jQuery.ajax);
        $("#loadUrl").click(function() {
            var threadLink = $("#thread_link").val()
            $.ajax({
                url: threadLink,
                type: "GET",
                async: true
            }).done(function (response) {
                var div = document.createElement("div"),
                    responseText = response.results[0],
                    title, metas, meta, name, description, i;
                    console.log(div);
                div.innerHTML = responseText;
                title = div.getElementsByTagName("title");
                title = title.length ? title[0].innerHTML : undefined;
                metas = div.getElementsByTagName("meta");
                for (i = 0; i < metas.length; i++) {
                    name = metas[i].getAttribute("name");
                    if (name === "description") {
                        meta = metas[i];
                        description = meta.getAttribute("content");
                        $("#thread_text").val(description);
                        break;
                    }
                    if (name === "title") {
                        title= metas[i].getAttribute("content");
                        console.log(title);
                    }
                }
                $("#thread_title").val(title);

            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("AJAX ERROR:", textStatus, errorThrown);
            });
            
        });
	$("#addThreadTableLink").click(function() {
		 $(addThreadTable).toggle( "slow");
	});
        var threadText = new nicEditor({buttonList : ['bold','italic','underline','strikeThrough','html','link']}).panelInstance('thread_text');

</script>