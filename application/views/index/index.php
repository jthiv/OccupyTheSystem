
<h2>What is Occupy The System?</h2>
<p><strong>Occupy The System</strong> is a place for civil discourse. Our goal is to provide information about
<strong>politicians and legislation</strong> to serve as a jumping off point for community discussion.
<strong>Occupy The System</strong> is meant to be a nonpartisan resource. The data we provide is biographical and legislative,
taken from congressional sources and organizations such as <a href="https://sunlightfoundation.com/">The Sunlight Foundation</a>. We will allow users to crowd-source site wide ettiquette to be used in the sections where conversations
take place. The goal is to help each other learn about politics, encourage civic engagement, and collectively take part in
<strong>meaningful</strong> conversations about the future of our government and society.
</p>
<?PHP
$stances = $this->objBillStances;
	echo "<div id='bill_stance_moreInfo_wrapper'>";
	echo "<h2>Find a bill. Take a stand!</h2>";
	echo "<hr>";
	echo "<div style='margin-bottom: 10px;'>If you find a bill you are interested, take a stance and share it. You can take a position for are against bills. Below are some examples of stances our users are taking currently.</div>";
	
		echo "<div id='bill_stance'>";
			//echo "<h2>Stances in Support</h2><hr>";
			if(empty($stances->support)){
				echo "<em>There are no stances in support of this bill yet!</em>";
			}else{
				foreach($stances->support as $stance)
				{
					$bill = new Bill($stance->bill_id);
					echo "<div class='stance'>";
					echo "<span class='supportHeader'>".$stance->user_name." supports <a href='".URL."congress/bill/".$stance->bill_id."'>".$bill->bill_type_display.$bill->number."</a></span>";
					echo "<p>\"".$stance->stance_text."\"</p>";
					echo "</div>";
				}
			}
		echo "</div>";
		
		echo "<div id='more_info'>";
			//echo "<h2>Stances in Opposition</h2><hr>";
			if(empty($stances->oppose)){
				echo "<em>There are no stances in opposition of this bill yet!</em>";
			}else{
				foreach($stances->oppose as $stance)
				{
					$bill = new Bill($stance->bill_id);
					echo "<div class='stance'>";
					echo "<span class='opposeHeader'>".$stance->user_name." opposes <a href='".URL."congress/bill/".$stance->bill_id."'>".$bill->bill_type_display.$bill->number."</a></span>";
					echo "<p>\"".$stance->stance_text."\"</p>";
					echo "</div>";
				}
			}
		echo "</div>";
		echo "<div style='clear: both;'></div>";
	echo "</div>";
	
	?>
<h2>Why Occupy?</h2>
<p>Our legislative system is complicated. Navigating it successfully requires a thorough understanding of legal processes and procedures.
As a result of this complication the "system" as it stands is currently only occupied by the politicians who write the laws.
<a href="http://www.occupythesystem.org">OccupyTheSystem.Org</a> was created with the belief that real fundamental change can only occur
if the people the system most affects are capable of understanding and participating in it. The staff of <strong>Occupy The System</strong> is made up of
a community of passionate developers, educators, and poltical scientists with the common goal of making America's legislative system less
complicated, and easier to approach. </p>
<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>
