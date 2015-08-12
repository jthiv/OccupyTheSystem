<?PHP
$arrStanceRequests = $this->stanceRequests;

echo "<h2>Inbox</h2>";
echo "<hr>";
echo "<div id='inbox_wrapper'>";

echo "<div id='inbox_network' class='inbox'>";
    echo "<span class='title'><p>Your Network</p></span>";
    echo "<em>-Coming Soon-</em>";
echo "</div>";
echo "<div id='inbox_stanceRequests' class='inbox'>";
    echo "<span class='title'><p>Stance Requests</p></span>";
    if(empty($arrStanceRequests)){
        echo "<em>-You have no stance requests-</em>";
    }else{
        foreach($arrStanceRequests as $req){
            //print_r($req);
            echo "<p class='reqs'><a href='http://www.occupythesystem.org/overview/showuserprofile/".$req->sender_userID."'>".$req->user_name."</a> wants you to take a stance on <a href='http://www.occupythesystem.org/congress/bill/".$req->billID."'>a bill(".$req->billID.")</a></p>";
        }
    }
echo "</div>";



echo "<div id='inbox_privateMail' class='inbox'>";
    //echo "<span id='inbox_compose_link' class='links'>Compose Message</span>";
    //    echo "<div id='inbox_compose'>";
    //        echo "<span class='title'><p>Compose Message</p></span>";
    //        echo "To: <input type='text' name='message_to' /> <br />";
    //        echo "Subject: <input type='text' name='message_subject' /><br />";
    //        echo "Message:<br /><textarea></textarea><br />";
    //        echo "<input type='submit' class='button' />";
    //    echo "</div>";
    echo "<span class='title'><p>Private Messages</p></span>";
     echo "<em>-Coming Soon-</em>";
echo "</div>";

echo "</div>";
?>
<script>
    $("#inbox_compose_link").click(function(){
        $("#inbox_compose").toggle('slow');    
    });
</script>