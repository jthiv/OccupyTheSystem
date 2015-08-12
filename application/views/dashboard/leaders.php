<?php

function displayFeed($feed_array){

	global $averageTime, $count1;

	$legislativeDay = "";
	//$feed_array = array_reverse($feed_array);
	
	$count= "0";
	echo "<div class='congressFeed'>";

	foreach($feed_array as $feedItem)
	{
		if($count == 5)
		{
			echo "<span class='moreInfo'>";
		}
		$count++;
		if($feedItem['legislative_day']!=$legislativeDay)
		{
			echo "<h3>".$feedItem['legislative_day']."</h3>";
			$legislativeDay = $feedItem['legislative_day'];
		}
		$timestamp = date("g:i:s a", strtotime($feedItem['timestamp']));
		echo "<span class='feedItem'>";
		echo "<p class='timestamp'>@".$timestamp."</p>";
		echo " - \"".$feedItem['update']."\"";
		//If there are related bills...display them
		if(count($feedItem['bill_ids']) > 0){

			foreach($feedItem['bill_ids'] as $relatedBill)
			{
				echo "<span class = 'related populate' pop = '" . $relatedBill . "'></span>";
				/*$relatedBill_info = new Bill($relatedBill,null,true);
                             
				if($relatedBill_info->bill_type_display === NULL)
                                {
                                    //Do nothing...that's not a real bill!
                                }
                                else
                                {
                                    echo "<span class='related populate' pop = '". $relatedBill_info -> bill_id ."'><p class='title'>Related Bill:</p> <a href='".URL."congress/bill/".$relatedBill_info->bill_id."'>".$relatedBill_info->bill_type_display.$relatedBill_info->number." ".$relatedBill_info->short_title."</a></span>";
                                }*/
			}
			
			
		}
		//If there are related rolls...display them
		if(count($feedItem['roll_ids']) > 0){
			foreach($feedItem['roll_ids'] as $relatedRoll)
			{
				$relatedRoll_info = new rollInfo($feedItem['congress'], $relatedRoll);
				echo "<span class='related'><p class='title'>Related Vote:</p> <a href='".URL."congress/votes/".$feedItem['congress']."/".$relatedRoll_info->roll_id."'>".$relatedRoll_info->roll_id."</a></span>";
			}
		}
		//If there are related politicians...display them
		if(count($feedItem['legislator_ids']) > 0){
			foreach($feedItem['legislator_ids'] as $relatedLegislator)
			{
				$relatedLegislator_info = new LegislatorInfo($relatedLegislator);
				echo "<span class='related'><p class='title'>Related Politician:</p> <a href='".URL."legislator/profile/".$relatedLegislator."'>".$relatedLegislator_info->name_first." ".$relatedLegislator_info->name_last."</a></span>";
			}
		}
		echo "</span>";
		
	}
	
	echo "</span>";
	echo "</div>";
	echo "<span class='viewMore'>View/Hide More Updates</span>";
}
?>
<div class="yourPoliticiansBox">
    <h2>Your Politicians</h2><hr>
           <table style="width: 600px; margin-left: auto; margin-right: auto;">
       <tr>
           <?PHP
           try{
                foreach($this->userSenators as $value){
                 echo "<td valign=top>
                            <a href=\"".URL."legislator/profile/".$value->politician_id."\">". $value->name_first. " " . $value->name_last . "<br />
                            <img src='".$value->pic_link."' width='60%' height='50%' border=0/></a><br />
                            <strong>Senator</strong>
                        </td>";
           }
           }catch(Exception $e){
                echo "<td>Unable to load senator</td>";
           }
           
           foreach($this->userRepresentative as $value){
            echo "<td valign=top>
                            <a href=\"".URL."legislator/profile/".$value->politician_id."\">". $value->name_first. " " . $value->name_last . "<br />
                            <img src='".$value->pic_link."' width='60%' height='50%' border=0/></a><br />
                            <strong>Representative</strong>
                        </td>";
           }
           ?>
       </tr>
   </table>
</div>
<div id='upcoming_votes_wrapper'>
    <div id='upcoming_votes_senate_votes'>
       <h2>House Feed</h2><hr>
	<?php displayFeed($this->houseFeed['results']);	?>
       </div>
    
    <div id='upcoming_votes_house_votes'>
    <h2>Senate Feed</h2><hr>
    <?php displayFeed($this->senateFeed['results']); ?>
    </div>
    
    <div style='clear: both;'></div>
</div>

<script>
	$(".viewMore").click(function(){
		$(this).parent().find(".moreInfo").toggle("slow");
	});
	
	$(document).ready(function(){
		var arr = [];
		var json;
		$.each($(".populate"), function(index, value) {
			arr[index] = $(this).attr('pop');
		});
		
		console.log(window.location.pathname);
		console.log(window.location.href);
		
		var url = window.location.href;
		url = url.replace(window.location.pathname, "/congress/bill/");
		
		
		$.ajax({
			url: '<?php echo URL . "dashboard/_ASYNC_Bill_Load"; ?>',
			type: 'get',
			data: {"data": JSON.stringify(arr)} ,
			dataType: 'json',
			success: function(data){
				$.each(data, function(index, element) {
					$.each($('span[pop="'+index+'"'), function(ind, val) {
						if(typeof element.short_title === 'undefined')	
							$(this).html("<p class='title'>Related Bill:</p> <a href = '"+url+element.bill_id+"'>"+element.bill_type_display + element.number+"</a>")
						else
							$(this).html("<p class='title'>Related Bill:</p> <a href = '"+url+element.bill_id+"'>"+element.bill_type_display + element.number+" "+element.short_title+"</a>")
					
						$(this).css("opacity","0");
						$(this).fadeTo(750, 1);
					});
				});
			},
			
		});
	});
</script>
<!--<h2>Community</h2>
<hr> -->