<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<?php 
	echo "<ul style=\"list-style-type:none;\">\n";
	if ($geburtstage) {
		foreach ($geburtstage as $row) {
			//				$geburtstag .= "  <li><img style=\"MARGIN-BOTTOM: -6px;\" src=\"" . JURI::base() . "modules/mod_geburtstag/images/24/" . $row->day_of_birthday . ".png\"/><b> <a href=\"index.php?option=com_comprofiler&task=userProfile&user=" . $row->user_id . "&Itemid=51\">" . $row->firstname . " " . $row->lastname . "</a></b> (" . $row->days_to_birthday . " Tage)" . "</li>\n";
			
			echo "  <li>";
			// prüfen ob Kalender ICON angezeigt werden soll
			if ($params->get('show_cal',1) == 1) {
				echo "<img style=\"MARGIN-BOTTOM: -6px;\" src=\"" . JURI::base() . "modules/mod_birthdays/images/24/" . $row->day_of_birthday . ".png\" alt=\"" . $row->birthday . "\"/>";
			}
			//prüfen ob der Nutzername oder der reale Name angezeigt werden soll
			//Vorname Nachname anzeigen
			if ($params->get('display_name',1) == 1) {
                            //prüfen ob link zum CB Profil angezeigt werden soll
                            if ($params->get('show_cblink',1) == 1) {
				echo "<b> <a href=\"index.php?option=com_comprofiler&task=userProfile&user=" . $row->user_id . "\">" . $row->firstname . " " . $row->lastname . "</a></b>";
                            }
                            else {
				echo "<b>" . $row->firstname . " " . $row->lastname . "</b>";
                            }
			}
			//Username anzeigen
			if ($params->get('display_name',1) == 0) {
                            //prüfen ob link zum CB Profil angezeigt werden soll
                            if ($params->get('show_cblink',1) == 1) {
                        	echo "<b> <a href=\"index.php?option=com_comprofiler&task=userProfile&user=" . $row->user_id . "\">" . $row->username . "</a></b>";
                            }
                            else {
                                echo "<b>" . $row->username . "</b>";
                            }
			}
			//Parameter "Alter anzeigen" auswerten
			if ($params->get('show_age',1) == 1) {
				echo " <b>" . $row->age . "</b>";
			}
			// prüfen ob Tage bis zum Geburtstag angezeigt werden sollen
			if ($params->get('show_days',1) == 1) {
				// am Geburtstag Birthday Icon anzeigen
				if  ($row->days_to_birthday == 0) {
					echo " <img style=\"MARGIN-BOTTOM: -6px;\" src=\"" . JURI::base() . "modules/mod_birthdays/images/24/birthday.png\"/>";
				}
				//sonst die Anzahl der verbleibenden Tage
				else {
					echo " (" . $row->days_to_birthday;
					//Prüfung ob Tag im Singular verwendet werden muss
					if  ($row->days_to_birthday == 1) {
						echo " " . $params->get('singular_day','day') . ")";
					}
					//sonst verwende Tag Sting im Plural
					else {
						echo " " . $params->get('plural_day','days') . ")";
					}
				}
			}
			echo "</li>\n";
		}
	}
	echo "</ul>\n";
?>