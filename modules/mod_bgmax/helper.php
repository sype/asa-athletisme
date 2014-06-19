<?php
/*------------------------------------------------------------------------
# mod_bgmax - bgMax
# ------------------------------------------------------------------------
# author    lomart
# copyright : Copyright (C) 2011 lomart.fr All Rights Reserved.
# @license  : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website   : http://lomart.fr
# Technical Support:  Forum - http://forum.joomla.fr
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');

global $bgmaxDebug;

   /**
    *  retourne une couleur en notation hexa sur 6 caractères sans #
    **/       
   function hex2hex($color)
   {
      $color = trim($color,'#');
      if (strlen($color) == 6) {
        return $color;
      } elseif (strlen($color) == 3) {
        return $color[0].$color[0].$color[1].$color[1].$color[2].$color[2];
      } else {
        return "";
      }
   }
  
   /**
    *  retourne une couleur en notation hexa (#RGB ou #RRGGBB ou RGB) 
    *  sous la forme d'une chaine "r,v,b"
    **/       
   function hex2rgb($color)
   {
      $color = trim($color,'#');
      if (strlen($color) == 6) {
        list($r, $g, $b) = array($color[0].$color[1], $color[2].$color[3], $color[4].$color[5]);
      } elseif (strlen($color) == 3) {
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
      } else {
        return false;
      }
      return hexdec($r).','.hexdec($g).','.hexdec($b);
   }

   /**
    *  Retourne la couleur du pixel en bas … gauche de l'image
    **/         
   function colorImageBottom($imageName) {
   
      // recuperer le type et la taille de l'image
      // Pb sur certains JPG qui retourne ''
      list($imgW, $imgH, $imgTyp) = getimagesize($imageName);
      switch ( $imgTyp ) {
        case 1 : $im = imagecreatefromgif($imageName); break;
        case 2;
        case ' ' : $im = imagecreatefromjpeg($imageName); break;
        case 3 : $im = imagecreatefrompng($imageName); break;
        default: {
          $app = &JFactory::getApplication();
          $app->enqueueMessage(JTEXT::_('IMGNAME_ERROR').'[name='.$imageName.'] [ type='.$imgTyp.'] [ format= '.$imgW.'x'.$imgH,'error');
          var_dump(gd_info() );
          return "";
          }
      }
      $rgb = imagecolorat($im, 2, ($imgH-2));
      $hex = sprintf("%06X", $rgb);
      return $hex;
   }

   /**
    *  Retourne un datetime consolide
    *  $date : la date sous la forme JJ/MM/AAAA (separateur indifferent)
    *  $time : l'heure sous la forme HH:MM
    *  Si la date est vide ou erronee, on retourne la date du jour
    **/         
   function makeDateTime($date, $time) {

      $Y = substr($date,6,4);
      $M = substr($date,3,2);
      $D = substr($date,0,2);
      if (checkdate($M,$D,$Y)) {
      	$return = $Y.$M.$D.$time;
      } else {
      	$return = date('Ymd').$time;
      }
      return $return;
   }

   /**
    *  Retourne une image au hasard - adaptation de ja_purity_ii    	
    **/    
    function getRandomImage ($img_folder) {
     
    $imglist=array();

		if ($dh = @opendir($img_folder)) {
			while (($f = readdir($dh)) !== false) {
        $ext = substr(trim(strtolower($f)),-3);
				if (($ext == 'jpg') || ($ext == 'gif') || ($ext == 'png')) {
				  $imglist[] = $f;
				}
			}
			closedir($dh);
		} 

    if(!count($imglist)) return '';

		$random = rand(0, count($imglist)-1);
		$image = $imglist[$random];

		return $image;
	}

   
class modBgMaxHelper
{
  /**
   *  Retourne un tableau avec les arguments … ajouter dans la page
   *  $bgmax["head"]  : chaine … ajouter dans head
   *  $bgmax["body"]  : chaine … ajouter dans body … la position module  
   **/     
   function getBgMaxInfos(&$params, $modTitle)
   {
    $app = &JFactory::getApplication();
    
		// tableau pour retour 
		$bgmax = array("head" => "", "body" => "");

		// DEBUG affiche la totalite des parametres pour analyse
		$bgmaxDebug = $params->get('bgmaxDebug');
		if ($bgmaxDebug=='2') {
		  $user = &JFactory::getUser();
      if (!$user->id) $bgmaxDebug = false;
		}
	  
		/****
		*  PERIODE : DOIT-ON PUBLIER ?
		****/  
		// attention, ambiguite si date fin vide et heure indiquee: 
		// on traite comme periode horaire journaliere	
    $ok = false;
		$debDate = $params->get('debDate'); $debTime=$params->get('debTime','00:00');
		$endDate = $params->get('endDate'); $endTime=$params->get('endTime','23:59');

		if ($debDate.$endDate=='') {
    		$now = date('H:i');
        if ($debTime>$endTime) {  //18:00 -> 8:00 sur 2 jours
            $ok = (($now>=$debTime) || ($now<=$endTime));
        } else {   // 08:00 ->  18:00 sur la journée
            $ok = (($now>=$debTime) && ($now<=$endTime));
        }
    } else {
        // date fournie
    		$now = date('YmdH:i');
    		$debDateTime = makeDateTime($debDate, $debTime);
    		$endDateTime = makeDateTime($endDate, $endTime);
        $ok = (($now < $debDateTime) ||  ($now > $endDateTime));
    }


		if (!$ok) {
			if ($bgmaxDebug) {
			  $msg = '#NO# BGMAX - '.$modTitle.': '; 
			  $msg.= $now." n'est pas entre ".$debDate.$debTime.' et '.$endDate.$endTime;
        $app->enqueueMessage($msg);
      }
			return;
		}

    /****
     *  CONTENU  : DOIT-ON PUBLIER ?
     ****/
    
    if ( ($bgFilter=$params->get('filterContent')) || ($bgmaxDebug) ) {
      $bg_id = JRequest::getVar( 'id', 0, 'get', 'int');
      $bg_menuid = JRequest::getVar( 'Itemid', 0, 'get', 'int');
      $bg_option = trim(JRequest::getVar( 'option', 0 ) );
      $bg_layout = trim(JRequest::getVar( 'layout', 0 ) );
      $bg_view = trim(JRequest::getVar( 'view', 0 ) );
      $bg_artid=''; $bg_catid=''; $bg_secid=''; 
      switch ($bg_view) {
        case 'article':
          $bg_artid = $bg_id; $bg_id = ''; 
          $database =& JFactory::getDBO();
          // section
          $query = "SELECT sectionid FROM #__content WHERE id=".$bg_artid;
          $database->setQuery($query);
          $row = $database->loadObject();
          $bg_secid = $row->sectionid;
          // category
          $query = "SELECT catid FROM #__content WHERE id=".$bg_artid;
          $database->setQuery($query);
          $row = $database->loadObject();
          $bg_catid = $row->catid;
          break;
          
         case 'categories' :
          	$bg_catid = intval(JRequest::getVar( 'id', 0 ) );
            break;
         case 'section' :
    	      $bg_sectid = intval(JRequest::getVar( 'id', 0 ) ); 
            break;
      }
      $context = $bg_option;
      $context.= '+menuid='.$bg_menuid;
      $context.= '+view='.$bg_view;
      if ($bg_layout) $context.= '+layout='.$bg_layout;
      if ($bg_id) $context.= '+id='.$bg_id;
      if ($bg_artid) $context.= '+artid='.$bg_artid;
      if ($bg_catid) $context.= '+catid='.$bg_catid;
      if ($bg_secid) $context.= '+secid='.$bg_secid;

      /*
      Si une des lignes de critere correspond, le module sera affiche 
      un '-' inverse la condition
      exemple, on affiche le module si :
      view=blog -menuid=2  // vue blog non appellé par menu 2
      catid=3    // OU articles de categorie 3
      -artid=2   // MAIS PAS si article d'ID 2 
      */
      if ($bgFilter) {
        $context = '+'.$context.'+';  // pour recherche
        $arr = explode("\n",$bgFilter);
        foreach ($arr as &$lign) {
            $ok = true;
            $mots = explode(" ",$lign);
            foreach ( $mots as $mot ) {
               if ($mot) {
                  if ($mot[0]=="-") {
                    if (stristr($context, '+'.substr($mot,1).'+')) {
                        $ok=false; break;
                    }
                  } elseif ($mot[0]=="+") {
                    if (!stristr($context, '+'.substr($mot,1).'+')) {
                        $ok=false; break;
                    }
                  } else {
                    if (!stristr($context, '+'.$mot.'+')) {
                        $ok=false; break;
                    }
                 }   
               }
            } // foreach mot
            if ($ok) break;   // si ligne OK, on affiche      
        }
        if (!$ok) {
          if ($bgmaxDebug) {
			      $msg = '#ERR# BGMAX - '.$modTitle.': '; 
            $msg.= 'Context:'.$context;
            $msg.= '<br />Filters: '.nl2br($bgFilter, ' || ');
            $app->enqueueMessage($msg);}
          return;
        }  
      } // if debug or Filtercontent
    } // if critere ou debug

    /*************************************
     *            ON AFFICHE 
     *************************************/         

    if ($bgmaxDebug) {
      $msg = '#OK# BGMAX - '.$modTitle.': '; 
      if (isset($context)) $msg.= 'Context:'.$context;
      $app->enqueueMessage($msg);
    }


		/****
		*   QUELLE IMAGE AFFICHER ?  
		*   Ordre des priorites :
		*   1 - celle indiquee dans la zone texte qui peut etre : 
		*       chemin complet ou relatif … racine si debute par '/'
		*   2 - celle indiquee dans la liste du dossier images/bgmax
		*   3 - au hasard dans le dossier indique
		*   4 - aucune, uniquement la couleur               		
		****/                            

    /* 1 */
  	$bgImage = $params->get('image_path', '');
  	if ($bgImage) {
    	if (substr($bgImage, 0, 1) == '/') {
    	    // chemin relatif … la racine 
    			$bgImage = trim(JURI::base(),'/').$bgImage;
    			$bgImageAbs = JPATH_ROOT.strtr($bgImage, '/', DS);
    	} else {
    	    // chemin absolu
    	    $bgImageAbs = $bgImage; 
      }

    /* 2 */
		} elseif ($params->get('image_path_list', '-1')!='-1') {
				$bgImage = trim(JURI::base(),'/').'/images/bgmax/'.$params->get('image_path_list');        
				$bgImageAbs = JPATH_ROOT.strtr('/images/bgmax/'.$params->get('image_path_list'), '/', DS);

    /* 3 */
		} elseif ($params->get('RandomFolder', '-1')!='-1') {
		    $rep = '/images/'.$params->get('RandomFolder').'/';
		    $bgImage = getRandomImage(JPATH_ROOT.strtr($rep, '/', DS));
        if ($bgImage) {
				    $bgImageAbs = JPATH_ROOT.strtr($rep.$bgImage, '/', DS);
        		$bgImage = trim(JURI::base(),'/').$rep.$bgImage;        
        } 
    }
	
		if ($bgmaxDebug) {$app->enqueueMessage("Image (abs): ".@$bgImageAbs);}
	
	  /****
	   *  couleur de fond
	   ****/     	  
		$bodyColor = hex2hex($params->get('bodyColor', ''));
		if ( ($bgImage) && ($params->get('bodyColorAuto', '0')=='1') ) {
			$bodyColor = colorImageBottom($bgImageAbs);
		}

    /****
     *   TAILLE, POSITION ET EFFETS 
     ****/         
		$bgMode  = $params->get('mode', 'max');         // max, full ou none
		$bgEnlarge = $params->get('enlarge', '1');
		$bgReduce = $params->get('reduce', '1');
		$bgPosition = $params->get('position', 'absolute');
		$bgHAlign = $params->get('align', 'center');
		$bgVAlign = $params->get('vertAlign', 'top');
		$bgFadeActive = $params->get('fadeActive', '0');
		$bgFadeAfter = $params->get('fadeAfter', '0');
		$bgFadeDuration = $params->get('fadeDuration', '1000');
		$bgFadeFrame = $params->get('fadeframeRate', '30');
		$bgZIndex = $params->get('zIndex', '-1');
		$bgFFHack = $params->get('ffHack', '0px');
	  
    /****
     *  BLOC CONTENU
     ****/          
		$contentSelector = $params->get('contentSelector', '');  
		$contentColor = hex2hex($params->get('contentColor', ''));  
		$contentOpacity = trim($params->get('contentOpacity', ''),'%');  
		$contentWidth = $params->get('contentWidth', '');  
		$contentAlign = $params->get('contentAlign', '');
    
    /****
     * CODE COMPLEMENTAIRE
     ****/           
    if ($headOther = $params->get('headOther', '')) {
        if (!stristr('</style>',$headOther)) {
          $headOther = "<style type='text/css'>".$headOther."</style>";
        }
        if ($bgmaxDebug) { 
             $app->enqueueMessage('Complementary code: <code>'.htmlspecialchars($headOther).'</code>');
        }
    }

    $headFile = $params->get('headFile', '-1');
    if ($headFile!='-1') {
	    $headFile = JPATH_ROOT.strtr('/images/bgmax/'.$headFile, '/', DS);
      if (file_exists($headFile)) {
        $code =  file($headFile);
        $headOther = implode('', $code); 
        if ($bgmaxDebug) { 
          $app->enqueueMessage('headfile: '.$headFile.'<code>'.htmlspecialchars($headOther).'</code>');
        }
      } else {
    	 $app->enqueueMessage('headFile: '.$headFile.' **NOT FIND**','error'); 
      }
    }      

    /****
     *   Traitement de l'ajout image
     ****/  
                         
     if ( (strstr($bgMode, 'repeat')) || ($bgImage == "") ) {
        //-------------------------------------------
        //-----> Affichage image SANS le script bgmax
        //-------------------------------------------
        if ($bgImage) {  
          $str = 'background:';
          $str.= '#'.$bodyColor;
          $str.= ' url('.$bgImage.')';
          $str.= ' '.$bgMode;
          $str.= ' '.$bgHAlign.' '.$bgVAlign;
          if ($bgPosition=='fixed') {$str.= ' fixed';}
          $str.= ' !important;';

          $bgmax["head"] .= '<style type="text/css">body {'.$str.'} </style>';
        }
     } else {
        //-------------------------------------------
        //-----> Affichage image AVEC le script bgmax
        //-------------------------------------------
        // Appel du script JS dans HEAD
        $site_base = JURI::base();
        if(substr($site_base, -1)=="/") {$site_base = substr($site_base, 0, -1);}
        $bgmax["head"] = '<script type="text/javascript" src="'.$site_base.'/modules/mod_bgmax/bgMax.min.js"></script>';

        // Definir la couleur sous image
        if ($bodyColor) {
          $bgmax["head"] .= '<style type="text/css">body {background-color:#'.$bodyColor.' !important;}</style>';
        }
        // Appel de la fonction JS dans BODY
        $str = "";
			  if ($bgMode == 'full') {$str.= 'mode:"full",';}
			  if ($bgEnlarge != '1') {$str.= 'enlarge:0,';}
			  if ($bgReduce  != '1') {$str.= 'reduce:0,';}
			  if ($bgPosition != 'absolute') {$str.= 'position:"fixed",';}
			  if ($bgHAlign != 'center') {$str.= 'align:"'.$bgHAlign.'",';}
			  switch ($bgVAlign) {
			  	case "center" : $str.= 'vertAlign:"middle",'; break;
			  	case "bottom" : $str.= 'vertAlign:"botoom",'; break;
			  }
			  if ($bgZIndex != '-1') {$str.= 'zIndex:'.$bgZIndex.',';}
			  if ($bgFFHack != '0px') {$str.= 'ffHack:"'.$bgFFHack.'",';}
		                                     
			  if ($bgFadeActive == '1') {           
  				$str .= 'fadeAfter:'.$bgFadeAfter.',';                 
  				$str .= 'fadeOptions:{duration:'.$bgFadeDuration.',';   
  				$str .= 'frameRate:'.$bgFadeFrame.'}';      
  			}                                          
			  $str = trim($str,",");
			  if ($str) {$str = ", {".$str."}";}
			  
			  $bgmax["body"]= '<script type="text/javascript">bgMax.init("'.$bgImage.'"'.$str.');</script>';
     } // if 
     
     /*****
      *   STYLE COMMUN (AVEC ou SANS BGMAX)
      *****/  
                          
      $str = ""; 
       // bloc qui contient tout le contenu 
      if ($contentSelector) {
        $str.= '<style type="text/css">';
        $str.= $contentSelector.' {';
        if ($contentWidth) {
          $str.= 'width:'.$contentWidth.'  !important;';
          switch ($contentAlign) {
            case 'left'   : $str.= 'margin-left: 0 !important;'; break;
            case 'center' : $str.= 'margin: 0 auto !important;'; break;
            case 'right'  : $str.= 'margin-right: 0 !important; margin-left: auto !important;'; break;
          }
        }
        if ($contentColor) {
          $str.= 'background-color: #'.$contentColor.';';
        }
        if ($contentOpacity != '100') {
          $str.= 'background-color: rgba(';      
          $str.= hex2rgb($contentColor).',';
          $str.= ($contentOpacity / 100).') !important;';   
        } 
        $str.= '}</style>'; 
        // si transparence: hack pour IE
        if ($contentOpacity != '100') {
          $sval = dechex($contentOpacity * 2.55);
          $sval.= $contentColor;
          $str.= '<!--[if lte IE 8]> <style type="text/css">';
          $str.= $contentSelector.' {';
          $str.= 'background:transparent; '; 
          $str.= 'filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#'.$sval.',endColorstr=#'.$sval.');'; 
          $str.= 'zoom: 1;';
          $str.= '} </style> <![endif]-->';
        } 
      } // fin if $contentSelector
      
      /*******
       * COMPLEMENT DE CODE POUR HEAD
       *******/
       
      if ($headOther) {
        
          $str.= $headOther;          
      }

      $bgmax["head"] .= $str;

      if ($bgmaxDebug) {
         $app->enqueueMessage('----------------------------');
         foreach ($bgmax as $key=>$value) {
            $app->enqueueMessage($key.' => <code>'.htmlentities($value).'</code>');
         }
      }

    return $bgmax;
    } // fin function getBgMaxInfos
           
} // class

