<?PHP
if(isset($_GET["edition"]))
{
    $edition = preg_replace("/[^A-Za-z0-9 ]/", '', $_GET["edition"]);
}
else
{
    $edition = "local";
}

$stateSel=null;
$nationalSel=null;
$localSel=null;
switch($edition)
{
    case 'state':
        $stateSel="selected";
        break;
    case 'national':
        $nationalSel="selected";
        break;
    default:
        $localSel="selected";
}
?>
<h2>News</h2>
<hr>
    <p>Browse news stories and essays written by members of Occupy The System. <a href="#">Vote/Contribute</a></p>
    <span style="float: right;">
        Set Edition:
        <select id="editionSelect">
            <option value="local" <?PHP echo $localSel; ?>>Local</option>
            <option value="state" <?PHP echo $stateSel; ?>>State</option>
            <option value="national" <?PHP echo $nationalSel; ?>>National(U.S)</option>
        </select>
    </span>
<?PHP
    switch($edition)
    {
        case 'state':
            echo "STATE";
            break;
        case 'national':
            echo "NaTIONAL";
            break;
        default:
            echo "Local";
    }
?>
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><center><input type="button" class="button" value="Send" style="border: 0;"/></center>
<script>
    $("#editionSelect").change(function () {
        var edition = $(this).val();
        window.location.replace("?edition="+edition);
    });
</script>