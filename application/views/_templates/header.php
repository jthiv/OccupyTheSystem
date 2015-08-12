<?PHP
$pageInfo = explode("/",$filename);
$header_info_controller= $pageInfo[0];
$header_info_action = $pageInfo[1];

switch($header_info_controller)
{
    case 'community':
	    switch($header_info_action)
		{
			case 'thread':
			    $thread = $this->arr_thread_info;
			    $meta_title = $thread["thread_parent_title"];
			    $meta_description = substr($thread["thread_parent_text"],0,150);
				$meta_description = strip_tags($meta_description)."...";
			break;
			default:
			    $meta_title = "Community Water Cooler";
			    $meta_description = "The Community Water Cooler is a place for casual conversation on OccupyTheSystem.Org.";
		}
    break;
    default:
        $meta_title = "OccupyTheSystem - Civic Engagement Made Easy";
        $meta_description = "OccupyTheSystem is a nonpartisan resource for civil discourse. We provide the information needed for citizens to engage with their legislative system and representatives.";
}
$meta_description = htmlspecialchars($meta_description);
$meta_title.=" - OccupyTheSystem.Org";
date_default_timezone_set('America/New_York');
function humanTiming ($time){
            $time = strtotime($time);
            $time = time() - $time; // to get the time since that moment

            $tokens = array (
                31536000 => 'year',
                2592000 => 'month',
                604800 => 'week',
                86400 => 'day',
                3600 => 'hour',
                60 => 'minute',
                1 => 'second'
            );
        
            foreach ($tokens as $unit => $text) {
                if ($time < $unit) continue;
                $numberOfUnits = floor($time / $unit);
                return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s ago':' ago');
            }
        }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <title><?PHP echo $meta_title; ?></title>
	<meta charset = "UTF-8" name="description" content="<?PHP echo $meta_description; ?>">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/master_1.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/tagit.css">
    <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://maps.google.com/maps/api/js?sensor=false"></script>
	<script src="<?php echo URL; ?>public/js/nicEdit.js" type="text/javascript"></script>
    <script src="<?php echo URL; ?>public/js/tagit.js" type="text/javascript" charset="utf-8"></script>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-30228850-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <table width=100% class="headerTable">
                <tr>
                    <td width=450>
                        <?php if (Session::get('user_logged_in') == true):?>
                            <a href="<?php echo URL; ?>dashboard"><img src="<?php echo URL; ?>public/img/layout/logo.gif" alt="OccupyTheSystem Logo" border=0/></a>
                            <?php endif; ?>
                             <?php if (Session::get('user_logged_in') == false):?>
                            <a href="http://www.occupythesystem.org"><img src="<?php echo URL; ?>public/img/layout/logo.gif" alt="OccupyTheSystem Logo" border=0/></a>
                        <?php endif; ?>
                    </td>
                    <td>
                    <a href="<?php echo URL; ?>community"><img src="<?php echo URL; ?>public/img/layout/nav/watercooler.png" alt="Community Water Cooler" border=0/></a>
                    <a href="<?php echo URL; ?>legislator"><img src="<?php echo URL; ?>public/img/layout/nav/politicians.png" alt="Politicians" border=0/></a>
	            <a href="<?php echo URL; ?>congress/bill"><img src="<?php echo URL; ?>public/img/layout/nav/bills.png" alt="Bills" border=0/></a>
		    <a href="https://www.kickstarter.com/projects/1649251461/occupy-the-system"><img src="<?php echo URL; ?>public/img/layout/nav/microbills.png" alt="MicroBills" border=0/></a>
                    </td>
                </tr>
            </table>
            <?php if (Session::get('user_logged_in') == true):?>
            <span style="float: right; margin-left: 600px; position: fixed; top: 0;">Welcome back, <?php echo Session::get('user_name'); ?>! ( <a href="<?php echo URL; ?>login/showprofile">Account</a> | <a href="<?php echo URL; ?>login/logout">Logout</a> )</span>
            <?php endif; ?>
        </div>
	<div id="locationBar">
            <!-- If a user is already logged in -->
            <?php if (Session::get('user_logged_in') == true):?>
            <a href="<?php echo URL; ?>dashboard">My Dashboard</a> 
            - 
            <a href="<?php echo URL; ?>dashboard/leaders">My Leaders</a>
            -
            <a href="<?php echo URL; ?>dashboard/inbox">Inbox<span id='notifications'>(0)</span></a>
            <?php endif; ?>
            
            <!-- for not logged in users -->
            <?php if (Session::get('user_logged_in') == false):?>
		<a href="<?php echo URL; ?>login/"><img src="<?php echo URL; ?>public/img/layout/signin.png" alt="Sign In" border=0/></a>
		<a href="<?php echo URL; ?>login/register"><img src="<?php echo URL; ?>public/img/layout/signup.png" alt="Register" border=0/></a>
                
                <?php endif; ?>
	</div>
	<div id="contentBox">