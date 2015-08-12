<h2>Write News Article</h2>
<hr>
    <p>
        <div id="form">
            <table>
                <tr class="addPoliticians" style="display: none;">
                    <td colspan=2 style="text-align: center;">
                        Add Politicians: <input type="text" id="polSearch" placeholder="Enter Name" /><br />
                        <div id="leaderSearchDisplay">
                            <fieldset>
                                <legend>
                                    Search Results
                                </legend>
                                To tag a politician in your news story, double click on their name below:<br />
                                <div class="results"><em>No results!</em><div>
                            </fieldset>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Tag Politicians:</td>
                    <td><span id='taggedPols'><em>None</em></span> <span class="tagPoliticians">(Add)</span></td>
                </tr>
                <tr class="addBills" style="display: none;">
                    <td colspan=2>Add Bills</td>
                </tr>
                <tr>
                    <td>Tag Bills:</td>
                    <td><em>None</em> <span class="tagBills">(Add)</span></td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select>
                            <option value='politics'>Politics</option>
                            <option value='misc'>Misc</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan=2><em>In order to post at state and national levels you first must meet the requirements.</em></td>
                </tr>
                <tr>
                    <td>State</td>
                    <td>
                        <select>
                            <option value='VA'>Virginia</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>District</td>
                    <td>
                        <select>
                            <option value="1">1</option>
                        </select>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>Title:</td>
                    <td><input type='text' /></td>
                </tr>
                <tr>
                    <td colspan=2>Body:<br /><textarea placeholder="Be sure to read the rulles before posting"></textarea></td>
                </tr>
            </table>
            <input type="submit" class="button" />
        </div>
        <div id="newsRules">
            News rules go here.
        </div>
        <div style="clear:both;"></div>
    </p>
    
    <script>
        var taggedPols = [];
        $(".tagPoliticians, .tagBills").css('color','#0000FF').css('text-decoration','underline');
        $(".tagPoliticians").click(function(){
            $(".addPoliticians").toggle("slow");
        });
        $(".tagBills").click(function(){
            $(".addBills").toggle("slow");
        });
        
        $("#polSearch").keyup(function(){
            var searchValue = $(this).val();
            if (searchValue.length > 2) {
                $("#leaderSearchDisplay").find("fieldset").find(".results").html("");
                $.getJSON( "../legislator/_findPoliticians/"+searchValue, function( data ) {

                    $.each( data.results, function( key, val ) {
                        $("#leaderSearchDisplay").find("fieldset").find(".results").append("<div id='pol_"+val.bioguide_id+"' class='polListItem'> + <strong>"+val.first_name+" "+val.last_name+"</strong>("+val.title+"-"+val.state+") + </div>");
                    });
                    
                   
                })
                .fail(function() {})
                    .always(function() {
                        $(".polListItem").off("dblclick").on('dblclick', function (e) {
                            var ID = $(this).attr('id');
                            ID = ID.substr(4);
                            
                            var val = $(this).text();
                            val = val.substr(3);
                            val = val.substring(0, val.length - 11);
                            
                            var objPol2Add = {ID:ID, name:val};
                            
                            taggedPols.push(objPol2Add);
                            $(this).remove();
                            updateTaggedList();
                        });  
                });
            }
        });
        
        function updateTaggedList(){
            $("#taggedPols").html("");
            
            var counter=0;
            $.each(taggedPols, function(index,value){
                if (counter>0) {
                    $("#taggedPols").append(",");
                }
                $("#taggedPols").append(value.name);
                counter++;
                //alert(value.name);    
            });    
        }
        
    </script>
    <style>
    .polListItem{
        display: block;
        border: 1px solid #2e7185;
        background-color: #cdeefc;
        margin-bottom: 5px;
        padding: 10px;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 10px; /* future proofing */
        -khtml-border-radius: 10px; /* for old Konqueror browsers */
    }
    </style>