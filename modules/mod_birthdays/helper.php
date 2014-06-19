<?php
/* Stefan Grumpelt - grumpelt-it.de*/
defined( '_JEXEC' ) or die( 'Restricted access' ); 
class modGeburtstagHelper
{
	function getGeburtstag(&$params)
	{
		global $mainframe;

		$db			=& JFactory::getDBO();
		$feld_gebtag = $params->get('field_birthdate','cb_geburtstag');
		$query = "SELECT cp.user_id, u.username, cp.firstname, cp.lastname, cp.$feld_gebtag,"
		//29.2. Bug gefixt
		//Jahreswechsel Bug gefixt
		. "\n @birthday:=ifnull(date(concat(year(now()), '-', month(cp.$feld_gebtag), '-', DAYOFMONTH(cp.$feld_gebtag))),"
		. "\n adddate(date(concat(year(now()), '-', month(cp.$feld_gebtag), '-', DAYOFMONTH(cp.$feld_gebtag)-1)), INTERVAL 1 DAY)) birthday,"
		//Berechnung der Tage bis zu Geburtstag
		//. "\n DATEDIFF(date(concat(year(now()), '-', month(cp.$feld_gebtag), '-', DAYOFMONTH(cp.$feld_gebtag))),now()) days_to_birthday,"
		//if(Bedingung,then,else)
		//if(days_to_birthday dieses Jahr < 0 (also Datum ist schon vorbei),days_to_birthday nächstes Jahr,days_to_birthday dieses Jahr
		. "\n if(DATEDIFF(@birthday,now())<0,DATEDIFF(adddate(@birthday, INTERVAL 1 YEAR),now()),DATEDIFF(@birthday,now())) days_to_birthday,"
                //BugFix: Anzeige des Alters über den Jahreswechsel korrigiert
                . "if(DATEDIFF(@birthday,now())<0, year(now()) - year(cp.$feld_gebtag) +1, year(now()) - year(cp.$feld_gebtag)) age, "
		. "\n day(cp.$feld_gebtag) day_of_birthday "
		. "\n FROM #__comprofiler cp, #__users u "
		. "\n where cp.user_id = u.id"
		. "\n and cp.$feld_gebtag is not null"
		. "\n and cp.$feld_gebtag != date('0000-00-00')"
		. "\n and u.block = 0"
		. "\n order by 7"
		. "\n LIMIT 0," . $params->get('count','5');
		;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();;
		return $rows;
	}
	

}
?>