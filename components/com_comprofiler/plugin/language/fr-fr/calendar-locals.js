// ** I18N

// Calendar FR language 2011-01-15 22:40:11 lavsteph$ 
// Author: forge.joomlapolis.com/projects/lan-cb-fr
// Encoding: any
// Distributed under the same terms as the calendar itself.

// full day names
Calendar._DN = new Array
("Dimanche",
 "Lundi",
 "Mardi",
 "Mercredi",
 "Jeudi",
 "Vendredi",
 "Samedi",
 "Dimanche");

// Please note that the following array of short day names (and the same goes
// for short month names, _SMN) isn't absolutely necessary.  We give it here
// for exemplification on how one can customize the short day names, but if
// they are simply the first N letters of the full name you can simply say:
//
//   Calendar._SDN_len = N; // short day name length
//   Calendar._SMN_len = N; // short month name length
//
// If N = 3 then this is not needed either since we assume a value of 3 if not
// present, to be compatible with translation files that were written before
// this feature.

// short day names
Calendar._SDN = new Array
("Dim",
 "Lun",
 "Mar",
 "Mer",
 "Jeu",
 "Ven",
 "Sam",
 "Dim");

// First day of the week. "0" means display Sunday first, "1" means display
// Monday first, etc. //BB calendar week number is ok only when Monday is FDoW:
Calendar._FD = 1;

// full month names
Calendar._MN = new Array
("Janvier",
 "Février",
 "Mars",
 "Avril",
 "Mai",
 "Juin",
 "Juillet",
 "Août",
 "Septembre",
 "Octobre",
 "Novembre",
 "Décembre");

// short month names
Calendar._SMN = new Array
("Jan",
 "Fév",
 "Mar",
 "Avr",
 "Mai",
 "Jui",
 "Jul",
 "Aou",
 "Sep",
 "Oct",
 "Nov",
 "Déc");

// tooltips
Calendar._TT = {};
Calendar._TT["INFO"] = "A propos du calendrier";

Calendar._TT["ABOUT"] =
"Sélecteur de Date/Heure DHTML\n" +
"(c) dynarch.com 2002-2005 / Author: Mihai Bazon\n" + // don't translate this this ;-)
"Pour la dernière version, voyez le site : http://www.dynarch.com/projects/calendar/\n" +
"Distribué sous GNU LGPL.  Voir http://gnu.org/licenses/lgpl.html pour plus d'informations." +
"\n\n" +
"Sélection de la date :\n" +
"- Utilisez les boutons \xab, \xbb pour choisir l'année\n" +
"- Utilisez les boutons " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " pour choisir le mois\n" +
"- Gardez le bouton de la souris enfoncé sur un de ces boutons pour sélectionner plus rapidement.";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Sélection de l'heure:\n" +
"- Cliquez sur un des composants de l'heure pour l'augmenter\n" +
"- ou Shift-cliquez pour le diminuer\n" +
"- ou cliquez et glissez/déplacez pour sélectionner plus rapidement.";

Calendar._TT["PREV_YEAR"] = "Année préc. (Maintenir=menu)";
Calendar._TT["PREV_MONTH"] = "Mois préc. (Maintenir=menu)";
Calendar._TT["GO_TODAY"] = "Aujourd'hui";
Calendar._TT["NEXT_MONTH"] = "Mois suiv. (Maintenir=menu)";
Calendar._TT["NEXT_YEAR"] = "Année suiv. (M)";
Calendar._TT["SEL_DATE"] = "Date";
Calendar._TT["DRAG_TO_MOVE"] = "Glissez/déplacez";
Calendar._TT["PART_TODAY"] = " (Aujourd'ui)";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Calendar._TT["DAY_FIRST"] = "Afficher %s en premier";

// This may be locale-dependent.  It specifies the week-end days, as an array
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Calendar._TT["WEEKEND"] = "0,6";

Calendar._TT["CLOSE"] = "Fermer";
Calendar._TT["TODAY"] = "Aujourd'hui";
Calendar._TT["TIME_PART"] = "(Shift-)Cliquez ou glissez/déplacez pour changer la valeur";

// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "%d-%m-%Y";
Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Calendar._TT["WK"] = "sem.";
Calendar._TT["TIME"] = "Heure:";
