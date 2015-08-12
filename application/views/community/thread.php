<?PHP
$thread = $this->arr_thread_info;



function build_thread($thread){
    echo "<div class='children'>";
    
    foreach($thread as $child){
        $score = $child['votes_up']-$child['votes_down'];
		
		//Create tag for user level
				$user_level_tag = "<span style='font-size: 10pt; color: red; text-decoration: none;'>";
				switch($child['author_user_level']){
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
		
		$thread_text_formatted = nl2br($child['thread_text']);
        echo "<div id='block_".$child['thread_id']."'>
        <table>
        <tr>";
        switch($child['vote_value'])
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
            echo "<td valign=top><a href='".URL."community/_addVote/".$child['thread_id']."/up'><img src='".URL."public/img/".$up_image.".png' border=0/></a><br /><br /><a href='".URL."community/_addVote/".$child['thread_id']."/down'><img src='".URL."public/img/".$down_image.".png' border=0/></a></td>";
            echo "<td>
        <td>
        <a name='comment_".$child['thread_id']."'>
                <div class='comment'><span class='comment_info'>
                    <a href='../../overview/showuserprofile/".$child['author_user_id']."'>".$child['author_user_name']."</a> ".$user_level_tag."
                    Capital(".$score.")
                    ".humanTiming($child['thread_timestamp'])."
                </span>
				<form method='post' action='".URL."community/_editComment/".$child['thread_id']."'>
                <div class='thread_text_block'>".$thread_text_formatted."</div>
				</form></div>
                <div class='thread_actions'><a href='javascript: void(0)' onclick='commentReply(".$child['thread_id'].")' class='commentReply'>Reply</a> -";
                if(Session::get('user_logged_in') == true && ($child['author_user_id'] == $_SESSION["user_id"] || $_SESSION["user_level"]=='admin'))
                {
					echo " <a href='javaScript:void(0);' class='editLink'>Edit</a>";
                    echo " - <a href='".URL."community/deleteThread/".$child['thread_id']."'>Delete</a>";
                }
                echo "
				<div class='thread_reply''>
				<form method='post' action='".URL."community/_addComment/".$child['thread_id']."'>
				Add Comment:<br />
				<textarea name='thread_text' placeholder='Please be sure to read the etiquette before posting.'></textarea><br />
				<input type='submit' class='button' value='Add Comment' />
				</form>
				</div>
				</div>
                </a>
                </td></tr>
                </table>
                
        </div>";
        build_thread($child['children']);
    }
    
    echo "</div>";
    
}
?>

<a href='<?PHP echo URL; ?>community/category/<?PHP echo $thread['thread_parent_category_id']; ?>'><--Back</a>
<h2><?PHP echo $thread['thread_parent_title']; ?> - <a href="../../overview/showuserprofile/<?PHP echo $thread['thread_parent_user_id']; ?>"><?PHP echo $thread['thread_parent_author']; ?></a> (<?PHP echo humanTiming($thread['thread_parent_timestamp']); ?>)</h2><hr>
<div id='block_<?PHP echo $thread['thread_parent_id'];?>'>
	<form method="post" action="<?PHP echo URL; ?>community/_editComment/<?PHP echo $thread['thread_parent_id'];?>">
	<?php if(!is_null($thread['thread_parent_url'])){
	    echo "<a href='" . $thread['thread_parent_url'] . "'>" . $thread['thread_parent_url'] . "</a><br /><br />";
	} ?>
	<div class='thread_text_block'>
	<?PHP echo nl2br($thread['thread_parent_text']) ?>
	</div>
	</form>
	<div class='thread_actions'>
	<a href='javascript: void(0)' class='commentReply'>Reply</a>
	<?PHP
	if(Session::get('user_logged_in') == true && ($thread['thread_parent_user_id'] == $_SESSION["user_id"] || $_SESSION["user_level"]=='admin'))
                {
					echo " - <a href='javaScript:void(0);' class='editLink'>Edit</a>";
                    echo " - <a href='".URL."community/deleteThread/".$thread['thread_parent_id']."'>Delete</a>";
                }
	?>
		<div class='thread_reply''>
			<form method='post' action='<?PHP echo URL; ?>community/_addComment/<?PHP echo $thread['thread_parent_id']; ?>'>
			Add Comment:<br />
			<textarea name='thread_text' placeholder='Please be sure to read the etiquette before posting.'></textarea><br />
			<input type='submit' class='button' value='Add Comment' />
			</form>
		</div>
	</div>
</div>
<div id="thread_comments_wrapper">
    <?PHP
    if(count($thread['children'])==0){
        echo "<em>There are no replies to this thread!</em>";
    }else{
        build_thread($thread['children']);
    }
    ?>
</div>

<script type="text/javascript">
    
	$(".editLink").click(function(){
		var text_block = $(this).parent().parent().find(".thread_text_block");
		var text_value = $(text_block).text().trim();
		$(this).parent().parent().find(".thread_text_block").html("<textarea name='comment_text' style='width: 500px; height: 100px;'>"+text_value+"</textarea><br /><input type='submit' class='button' value='Save' />");
		nicEditors.allTextAreas({buttonList : ['bold','italic','underline','strikeThrough','html','link']});
	});
	$(".commentReply").click(function(){
		$(this).parent().find(".thread_reply").toggle("slow");
	});
</script>