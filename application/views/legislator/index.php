<h2>Leader Search</h2>
<hr>
<div style='text-align: center;'>
    Click on any state to see the politicians for that state.<br /><br /><br />
    <?PHP
if($this->displayPoliticians){
    $array_reps = $this->arr_rep_data;
    $array_sen = $this->arr_sen_data;
    echo "
    <div style='border-top: 1px solid #90B2C7; border-bottom: 1px solid #90B2C7; margin-bottom: 5px; text-align: center;'>
    <h3>Politicians for ".$this->state."</h3>
    <table style='width: 400px; margin-left: auto; margin-right: auto; text-align: left;'>
    <tr>
    <td valign=top>Senators:</td>";
    echo "<td>";
    foreach($array_sen as $senator){
    echo" <a href=\"".URL."legislator/profile/".$senator["pID"]."\">". $senator['pNameFirst'] . " " . $senator['pNameLast'] . " </a><br />";
    }
    echo "
    </td>
    </tr>
    <tr>
    <td valign=top>Representatives:</td>";
    echo "<td>";
    foreach($array_reps as $representative){
    echo"<a href=\"".URL."legislator/profile/".$representative["pID"]."\">". $representative['pNameFirst'] . " " . $representative['pNameLast'] . " </a> (".$representative['jobDistrict'].")<br />";
    }
    echo "
    </td>
    </tr>
    </table>
    
    </div>";
}
?>
<img id="Image-Maps_2201110211415279" src="<?PHP echo URL; ?>public/img/bluestates.png" usemap="#Image-Maps_2201110211415279" border="0" alt="" />
<map id="_Image-Maps_2201110211415279" name="Image-Maps_2201110211415279">
<area shape="poly" coords="218,190,218,245,181,245,211,281,228,272,244,291,257,308,279,319,275,301,280,286,294,282,312,269,310,261,315,255,307,243,305,228,296,218,274,221,254,214,250,216,248,212,247,189," href="<?PHP echo URL; ?>legislator/index/TX" alt="Texas" title="Texas"   />
<area shape="poly" coords="218,189,218,183,298,183,301,220,296,218,269,219,249,216,247,214,247,189," href="<?PHP echo URL; ?>legislator/index/OK" alt="Oklahoma" title="Oklahoma"   />
<area shape="poly" coords="155,251,160,183,218,183,218,216,218,244,165,246,163,250," href="<?PHP echo URL; ?>legislator/index/NM" alt="New Mexico" title="New Mexico"   />
<area shape="poly" coords="299,185,301,220,306,230,335,230,334,216,342,186," href="<?PHP echo URL; ?>legislator/index/AR" alt="Arkansas" title="Arkansas"   />
<area shape="poly" coords="307,231,307,242,315,254,312,262,312,270,336,277,353,282,365,280,359,266,356,262,352,252,333,252,337,236,334,231," href="<?PHP echo URL; ?>legislator/index/LA" alt="Louisiana" title="Louisiana"   />
<area shape="poly" coords="340,202,362,200,361,238,366,258,355,262,351,255,351,252,333,252,338,237,334,216," href="<?PHP echo URL; ?>legislator/index/MS" alt="Mississippi" title="Mississippi"   />
<area shape="poly" coords="362,201,367,258,376,258,379,257,375,250,400,249,398,230,387,198,376,199," href="<?PHP echo URL; ?>legislator/index/AL" alt="Alabama" title="Alabama"   />
<area shape="poly" coords="387,198,398,227,400,247,427,245,436,243,438,222,424,208,413,198,409,197,409,193,399,195," href="<?PHP echo URL; ?>legislator/index/GA" alt="Georgia" title="Georgia"   />
<area shape="poly" coords="375,251,381,256,387,253,399,260,414,254,425,262,426,275,438,296,450,307,458,305,459,292,452,274,446,261,435,243,424,246,404,247," href="<?PHP echo URL; ?>legislator/index/FL" alt="Florida" title="Florida"   />
<area shape="poly" coords="409,196,421,205,438,222,452,207,459,193,447,186,435,188,421,188,414,190," href="<?PHP echo URL; ?>legislator/index/SC" alt="South Carolina" title="South Carolina"   />
<area shape="poly" coords="98,229,133,249,155,250,160,178,135,176,114,174,111,183,105,182,103,202,100,218," href="<?PHP echo URL; ?>legislator/index/AZ" alt="Arizona" title="Arizona"   />
<area shape="poly" coords="114,174,118,143,122,109,148,112,147,129,165,129,162,159,162,179,137,175," href="<?PHP echo URL; ?>legislator/index/UT" alt="Utah" title="Utah"   />
<area shape="poly" coords="70,102,64,138,104,195,106,183,112,184,117,144,121,109,95,106," href="<?PHP echo URL; ?>legislator/index/NV" alt="Nevada" title="Nevada"   />
<area shape="poly" coords="69,101,35,94,28,107,29,133,37,152,44,177,46,190,64,206,76,215,74,223,99,225,101,214,106,204,102,195,64,136," href="<?PHP echo URL; ?>legislator/index/CA" alt="California" title="California"   />
<area shape="poly" coords="164,130,161,184,228,183,228,130," href="<?PHP echo URL; ?>legislator/index/CO" alt="Colorado" title="Colorado"   />
<area shape="poly" coords="229,146,229,183,298,183,298,155,291,152,293,146,287,146,259,146," href="<?PHP echo URL; ?>legislator/index/KS" alt="Kansas" title="Kansas"   />
<area shape="poly" coords="286,139,298,156,299,186,343,185,346,180,337,165,337,159,324,148,317,139,305,139," href="<?PHP echo URL; ?>legislator/index/MO" alt="Missouri" title="Missouri"   />
<area shape="poly" coords="345,182,340,202,362,200,397,195,410,183,423,169,398,172,375,176,362,178," href="<?PHP echo URL; ?>legislator/index/TN" alt="Tennessee" title="Tennessee"   />
<area shape="poly" coords="422,169,412,179,401,189,397,195,410,191,427,187,448,188,460,194,466,192,466,185,472,180,480,178,476,174,478,170,482,168,482,163,477,160,474,156,453,160,434,165," href="<?PHP echo URL; ?>legislator/index/NC" alt="North Carolina" title="North Carolina"   />
<area shape="poly" coords="348,181,346,177,348,172,353,173,356,166,361,161,371,162,374,156,380,158,382,148,388,145,397,148,406,145,406,151,415,159,408,170,381,175,361,179," href="<?PHP echo URL; ?>legislator/index/KY" alt="Kentucky" title="Kentucky"   />
<area shape="poly" coords="408,171,415,159,421,161,430,156,435,150,439,141,444,135,447,125,458,125,463,137,471,146,476,154,453,160,430,167," href="<?PHP echo URL; ?>legislator/index/VA" alt="Virginia" title="Virginia"   />
<area shape="poly" coords="404,145,417,160,426,158,435,152,439,143,443,139,447,128,452,123,450,121,444,123,438,127,436,126,435,122,423,126,420,117,419,130,416,132,412,136," href="<?PHP echo URL; ?>legislator/index/WV" alt="West Virginia" title="West Virginia"   />
<area shape="poly" coords="434,123,436,129,448,120,458,126,462,137,476,137,476,148,482,130,476,131,466,115,458,116," href="<?PHP echo URL; ?>legislator/index/MD" alt="Maryland" title="Maryland"   />
<area shape="poly" coords="466,113,476,132,482,129,476,124,471,118," href="<?PHP echo URL; ?>legislator/index/DE" alt="Delaware" title="Delaware"   />
<area shape="rect" coords="507,128,531,148" href="<?PHP echo URL; ?>legislator/index/DE" alt="Delaware" title="Delaware"    />
<area shape="rect" coords="510,147,531,167" href="<?PHP echo URL; ?>legislator/index/MD" alt="Maryland" title="Maryland"    />
<area shape="poly" coords="469,95,479,97,479,109,477,118,469,114,472,108,468,101," href="<?PHP echo URL; ?>legislator/index/NJ" alt="New Jersey" title="New Jersey"   />
<area shape="poly" coords="419,99,423,126,448,119,468,114,472,107,466,99,469,93,463,86,442,93," href="<?PHP echo URL; ?>legislator/index/PA" alt="Pennsylvania" title="Pennsylvania"   />
<area shape="rect" coords="510,109,531,129" href="<?PHP echo URL; ?>legislator/index/NJ" alt="New Jersey" title="New Jersey"    />
<area shape="poly" coords="423,96,428,86,422,82,431,78,442,77,446,71,443,65,447,61,452,49,466,45,474,66,479,89,481,97,469,93,463,87,446,91," href="<?PHP echo URL; ?>legislator/index/NY" alt="New York" title="New York"   />
<area shape="poly" coords="467,44,479,40,479,50,482,70,476,71,470,59," href="<?PHP echo URL; ?>legislator/index/VT" alt="Vermont" title="Vermont"   />
<area shape="rect" coords="443,23,464,43" href="<?PHP echo URL; ?>legislator/index/VT" alt="Vermont" title="Vermont"    />
<area shape="poly" coords="476,72,496,65,501,75,498,81,494,77,477,82," href="<?PHP echo URL; ?>legislator/index/MA" alt="Massachusetts" title="Massachusetts"   />
<area shape="poly" coords="477,82,481,93,492,86,490,79," href="<?PHP echo URL; ?>legislator/index/CT" alt="Connecticut" title="Connecticut"   />
<area shape="poly" coords="490,79,492,85,498,82,495,77," href="<?PHP echo URL; ?>legislator/index/RI" alt="Rhode Island" title="Rhode Island"   />
<area shape="poly" coords="478,38,485,36,496,62,482,69,479,62,479,51,482,46," href="<?PHP echo URL; ?>legislator/index/NH" alt="New Hampshire" title="New Hampshire"   />
<area shape="poly" coords="484,36,495,62,500,45,509,37,520,27,511,13,506,3,502,5,496,1,490,14,490,21," href="<?PHP echo URL; ?>legislator/index/ME" alt="Maine" title="Maine"   />
<area shape="rect" coords="510,55,531,75" href="<?PHP echo URL; ?>legislator/index/MA" alt="Massachusetts" title="Massachusetts"    />
<area shape="rect" coords="510,72,531,92" href="<?PHP echo URL; ?>legislator/index/RI" alt="Rhode Island" title="Rhode Island"    />
<area shape="rect" coords="510,90,531,110" href="<?PHP echo URL; ?>legislator/index/CT" alt="Connecticut" title="Connecticut"    />
<area shape="rect" coords="459,9,480,29" href="<?PHP echo URL; ?>legislator/index/NH" alt="New Hampshire" title="New Hampshire"    />
<area shape="poly" coords="419,98,407,110,394,110,382,112,386,145,394,148,402,145,412,137,415,131,421,124,421,114," href="<?PHP echo URL; ?>legislator/index/OH" alt="Ohio" title="Ohio"   />
<area shape="poly" coords="381,113,369,114,357,117,361,145,359,163,371,161,378,159,384,145," href="<?PHP echo URL; ?>legislator/index/IN" alt="Indiana" title="Indiana"   />
<area shape="poly" coords="354,110,327,112,324,124,321,138,324,147,334,156,337,165,346,174,352,173,360,155,359,135," href="<?PHP echo URL; ?>legislator/index/IL" alt="Illinois" title="Illinois"   />
<area shape="poly" coords="363,114,393,110,397,100,399,95,393,81,386,87,382,84,387,78,386,67,371,65,370,63,379,59,368,51,359,54,351,56,346,51,341,50,338,49,337,53,331,56,328,61,345,66,348,74,357,65,366,62,369,68,369,76,366,69,362,77,361,86,365,99," href="<?PHP echo URL; ?>legislator/index/MI" alt="Michigan" title="Michigan"   />
<area shape="poly" coords="354,109,327,112,323,109,322,95,313,86,306,86,308,82,308,69,305,68,312,63,312,57,320,56,330,63,345,65,348,72,353,74,350,87," href="<?PHP echo URL; ?>legislator/index/WI" alt="Wisconsin" title="Wisconsin"   />
<area shape="poly" coords="321,101,273,101,280,122,286,138,318,139,326,131,322,127,323,122,329,119,329,113,322,108," href="<?PHP echo URL; ?>legislator/index/IA" alt="Iowa" title="Iowa"   />
<area shape="poly" coords="330,39,316,39,303,33,295,36,291,28,293,24,288,22,285,29,270,32,273,52,274,71,274,100,301,100,321,101,321,94,311,86,307,85,304,67,311,61,316,49," href="<?PHP echo URL; ?>legislator/index/MN" alt="Minnesota" title="Minnesota"   />
<area shape="poly" coords="211,107,211,130,228,130,228,146,288,146,281,127,278,114,262,106,238,107," href="<?PHP echo URL; ?>legislator/index/NE" alt="Nebraska" title="Nebraska"   />
<area shape="poly" coords="212,70,211,108,263,107,278,113,274,100,273,72,240,71," href="<?PHP echo URL; ?>legislator/index/SD" alt="South Dakota" title="South Dakota"   />
<area shape="poly" coords="211,32,211,72,274,71,274,53,271,49,269,32,240,32," href="<?PHP echo URL; ?>legislator/index/ND" alt="North Dakota" title="North Dakota"   />
<area shape="poly" coords="150,79,149,130,211,129,210,80," href="<?PHP echo URL; ?>legislator/index/WY" alt="Wyoming" title="Wyoming"   />
<area shape="poly" coords="211,32,211,79,151,79,150,86,136,85,129,68,130,55,124,37,125,27,163,30," href="<?PHP echo URL; ?>legislator/index/MT" alt="Montana" title="Montana"   />
<area shape="poly" coords="150,86,149,111,122,109,94,105,97,89,103,84,100,80,110,63,107,59,116,26,126,27,123,36,130,57,129,66,135,83," href="<?PHP echo URL; ?>legislator/index/ID" alt="Idaho" title="Idaho"   />
<area shape="poly" coords="49,43,44,64,37,73,36,94,68,102,95,105,98,86,102,83,100,78,108,62,106,59,93,55,78,55,60,51,56,44," href="<?PHP echo URL; ?>legislator/index/OR" alt="Oregon" title="Oregon"   />
<area shape="poly" coords="52,10,67,17,65,31,73,24,73,14,95,21,116,26,107,58,88,54,71,53,59,50,54,43,49,46,52,35,55,28,52,25,52,18," href="<?PHP echo URL; ?>legislator/index/WA" alt="Washington" title="Washington"   />
<area shape="poly" coords="62,221,47,220,29,216,16,226,10,231,21,241,15,244,11,242,2,250,12,255,20,255,17,262,11,263,4,271,7,281,16,283,16,290,28,290,24,297,16,303,10,309,2,313,15,313,24,305,37,295,40,284,48,275,48,287,57,280,59,275,67,281,77,280,94,283,112,299,118,290,111,291,108,285,100,285,92,276,88,277,80,273,72,253,67,236," href="<?PHP echo URL; ?>legislator/index/AK" alt="Alaska" title="Alaska"   />
<area shape="poly" coords="246,347,236,332,220,325,216,340,220,352,232,351," href="<?PHP echo URL; ?>legislator/index/HI" alt="Hawaii" title="Hawaii"   />
<area shape="poly" coords="213,316,220,315,213,311,202,309,206,314,210,321," href="<?PHP echo URL; ?>legislator/index/HI" alt="Hawaii" title="Hawaii"   />
<area shape="poly" coords="178,302,173,295,170,293,165,294,169,301," href="<?PHP echo URL; ?>legislator/index/HI" alt="Hawaii" title="Hawaii"   />
<area shape="poly" coords="193,304,189,306,193,315,200,307," href="<?PHP echo URL; ?>legislator/index/HI" alt="Hawaii" title="Hawaii"   />
<area shape="poly" coords="147,283,143,284,147,292," href="<?PHP echo URL; ?>legislator/index/HI" alt="Hawaii" title="Hawaii"   /></map>
</div>