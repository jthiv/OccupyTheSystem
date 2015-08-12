<?php
class LoadingBar    // New class
{
    public $startDateStr;
    public $endDateStr;
    public $currentDateStr;
    public $percentComplete;
    
    function __construct($start, $end)
    {
        date_default_timezone_set('America/New_York');
        $this -> startDateStr = $start;
        $this -> endDateStr = $end;
        $this -> currentDateStr = date("Y-m-d");
        $durationInOffice = strtotime($this->currentDateStr) - strtotime($this->startDateStr);
        $termLength = strtotime($this->endDateStr) - strtotime($this -> startDateStr);
        $this -> percentComplete = $durationInOffice / $termLength * 100;
    }
}
?>