<?PHP
echo "<h2>Interests</h2>";
echo "<hr>";
echo "Adding interests allows us to alert you when votes are taking place that affect you. We can also help you find and take part in discussions that have to do with the subjects you subscribe to here.<br /><br />";
echo "<div class='yourPoliticiansBox'><h3>Your Interests:</h3><div id='yourInterests'>Loading...</div></div>";
echo "<h2>Add Interests</h2>";
echo "<hr>";
echo "Search for interests below by clicking on the letters. To add an interest double click on it."
?>

<div id="interestsWrapper">
    <table class="center">
        <tr><td>
    <?php
    foreach(range('A','Z') as $i){
        echo "<a href='javascript:void(0)' onclick='javascript:findIssue(\"$i\")'>$i</a>";
        if($i != 'Z'){
            echo " - ";
        }
    }
    ?>
    </td></tr>
    </table><br /><br />
    <div id="billsByIssue">Loading...</div>
</div>
<script>
    $( document ).ready(function(){
        buildUserIssuesList(0, false);
        findIssue("a");
        
        
    });
    function removeIssue(ID) {
            buildUserIssuesList(ID, true);
    }
    function findIssue(letter){
        var url = "../congress/findIssuesByLetter/"+letter;
        try{
        $.getJSON(url)
        .done(function(data) {
            $("#billsByIssue").html("<div>");
            var counter = 0;
            $.each(data, function(index, element){
                if (counter == 7) {
                    $("#billsByIssue").append("</div><div>");
                    counter = 0;
                }
                $("#billsByIssue").append("<span id='issue_"+element.ID+"' class='issue_draggable'>"+element.issueName+"</span>");
                counter++;
                });
        })
        .fail(function() {})
        .always(function() {
            $(".issue_draggable").dblclick(function() {
                var ID = $(this).attr('id');
                ID = ID.substr(6);
                buildUserIssuesList(ID, false);
            });  
        });
        }catch(e){
            console.log(e);
        }
    }
    function buildUserIssuesList(issueID, remove){
        var url;
        if (remove) {
            url = "editinterests_add/"+issueID+"/true";
        }else{
            url = "editinterests_add/"+issueID;
        }
        $.getJSON(url)
            .done(function(data) {
                if (data.length == 0) {
                    $("#yourInterests").html("<em>You have not added any interests. Double click on the subjects from the list below to add them to your list of interests.</em>");
                }else{
                    $("#yourInterests").html("<div>");
                    var counter = 0;
                    $.each(data, function(index, element){
                       
                        $("#yourInterests").append("<span class='issue_userList'>"+element.issueName+" <span onclick='removeIssue("+element.issueID+");'>X</span></span>");
                        counter++;
                        });
                    $("#yourInterests").append("</div>");
                }
            })
            .fail(function() {alert("Error adding interest.");});
    }
</script>