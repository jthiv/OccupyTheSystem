<?php

/**
 * Class Sorter
 * This class is built to handle sorting representatives by various metrics
 * Author: Gerrit Bond
 * Date: 10 / 4 / 2014
 */

class Sorter
{
	private static function asc($a, $b)
	{
		if($a["jobDistrict"] == $b["jobDistrict"])
			return 0;
		
		return ($a["jobDistrict"] < $b["jobDistrict"]) ? -1 : 1;
	}
	
	private static function desc($a, $b)
	{
		if($a["jobDistrict"] == $b["jobDistrict"])
			return 0;
		
		return ($a["jobDistrict"] > $b["jobDistrict"]) ? -1 : 1;
	}
	
	// Alphabetic on the Last Name
	private static function last_alpha($a, $b)
	{
		$a_arr = str_split(strtolower($a["pNameLast"]));
		$b_arr = str_split(strtolower($b["pNameLast"]));
		for($i = 0; $i < (sizeof($a_arr) > sizeof($b_arr) ? sizeof($b_arr) : sizeof($a_arr)); $i++)
		{
			if(ord($a_arr[$i]) < ord($b_arr[$i]))
				return -1;
			if(ord($a_arr[$i]) > ord($b_arr[$i]))
				return 1;
		}	
	}
	
	private static function last_revalpha($a, $b)
	{
		$a_arr = str_split(strtolower($a["pNameLast"]));
		$b_arr = str_split(strtolower($b["pNameLast"]));
		for($i = 0; $i < (sizeof($a_arr) > sizeof($b_arr) ? sizeof($b_arr) : sizeof($a_arr)); $i++)
		{
			if(ord($a_arr[$i]) < ord($b_arr[$i]))
				return 1;
			if(ord($a_arr[$i]) > ord($b_arr[$i]))
				return -1;
		}	
	}
	
	
	// Alphabetic on the First Name
	private static function first_alpha($a, $b)
	{
		$a_arr = str_split(strtolower($a["pNameFirst"]));
		$b_arr = str_split(strtolower($b["pNameFirst"]));
		for($i = 0; $i < (sizeof($a_arr) > sizeof($b_arr) ? sizeof($b_arr) : sizeof($a_arr)); $i++)
		{
			if(ord($a_arr[$i]) < ord($b_arr[$i]))
				return -1;
			if(ord($a_arr[$i]) > ord($b_arr[$i]))
				return 1;
		}	
	}
	
	private static function first_revalpha($a, $b)
	{
		$a_arr = str_split(strtolower($a["pNameFirst"]));
		$b_arr = str_split(strtolower($b["pNameFirst"]));
		for($i = 0; $i < (sizeof($a_arr) > sizeof($b_arr) ? sizeof($b_arr) : sizeof($a_arr)); $i++)
		{
			if(ord($a_arr[$i]) < ord($b_arr[$i]))
				return 1;
			if(ord($a_arr[$i]) > ord($b_arr[$i]))
				return -1;
		}	
	}
	
	// Alphabetic on the full name
	private static function alpha($a, $b)
	{
		$a_arr = str_split(strtolower($a["pNameFirst"] . $a["pNameLast"]));
		$b_arr = str_split(strtolower($b["pNameFirst"] . $b["pNameLast"]));
		for($i = 0; $i < (sizeof($a_arr) > sizeof($b_arr) ? sizeof($b_arr) : sizeof($a_arr)); $i++)
		{
			if(ord($a_arr[$i]) < ord($b_arr[$i]))
				return -1;
			if(ord($a_arr[$i]) > ord($b_arr[$i]))
				return 1;
		}	
	}
	
	private static function revalpha($a, $b)
	{
		$a_arr = str_split(strtolower($a["pNameFirst"] . $a["pNameLast"]));
		$b_arr = str_split(strtolower($b["pNameFirst"] . $b["pNameLast"]));
		for($i = 0; $i < (sizeof($a_arr) > sizeof($b_arr) ? sizeof($b_arr) : sizeof($a_arr)); $i++)
		{
			if(ord($a_arr[$i]) < ord($b_arr[$i]))
				return 1;
			if(ord($a_arr[$i]) > ord($b_arr[$i]))
				return -1;
		}	
	}
	
	public static function jobDistrictSort($array_reps, $order = "asc")
	{
		// This is placed to prevent passing a function that does not exist.
		// If we add more comparison functions, we need to change this statement.
				
		usort($array_reps, array("self",$order));
		return $array_reps;
	}
}