<?php

/*
   ----------------------------------------------------------------------
   Monitoring plugin for GLPI
   Copyright (C) 2010-2011 by the GLPI plugin monitoring Team.

   https://forge.indepnet.net/projects/monitoring/
   ----------------------------------------------------------------------

   LICENSE

   This file is part of Monitoring plugin for GLPI.

   Monitoring plugin for GLPI is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 2 of the License, or
   any later version.

   Monitoring plugin for GLPI is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with Monitoring plugin for GLPI.  If not, see <http://www.gnu.org/licenses/>.

   ------------------------------------------------------------------------
   Original Author of file: David DURIEUX
   Co-authors of file:
   Purpose of file:
   ----------------------------------------------------------------------
 */

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginMonitoringConfig extends CommonDBTM {
   

   /**
   * Get name of this type
   *
   *@return text name of this type by language of the user connected
   *
   **/
   static function getTypeName() {
      global $LANG;

      return "Configuration";
   }



   function canCreate() {
      return true;
   }


   
   function canView() {
      return true;
   }


   
   function canCancel() {
      return true;
   }


   
   function canUndo() {
      return true;
   }


   
   function canValidate() {
      return true;
   }


   
   /**
   * Display form for configuration
   *
   * @param $items_id integer ID 
   * @param $options array
   *
   *@return bool true if form is ok
   *
   **/
   function showForm($items_id, $options=array()) {
      global $DB,$CFG_GLPI,$LANG;

      $options['candel'] = false;

      if ($this->getFromDB("1")) {
         
      } else {
         $input = array();
         $input['rrdtoolpath'] = "/usr/local/bin/";
         $this->add($input);
         $this->getFromDB("1");
      }

      $this->showFormHeader($options);

      $this->getFromDB($items_id);

      echo "<tr class='tab_bg_1'>";
      echo "<td>path of RRDTOOL&nbsp;:</td>";
      echo "<td align='center'>";
      echo "<input name='rrdtoolpath' type='text' value='".$this->fields['rrdtoolpath']."' />";
      echo "</td>";
      echo "<td>";
      echo $LANG['plugin_monitoring']['config'][0]."&nbsp:";
      echo "</td>";
      echo "<td>";
         $a_timezones = $this->getTimezones();
      
         $a_timezones_selected = importArrayFromDB($this->fields['timezones']);
         $a_timezones_selected2 = array();
         foreach ($a_timezones_selected as $timezone) {
            $a_timezones_selected2[$timezone] = $a_timezones[$timezone];
            unset($a_timezones[$timezone]);
         }
         ksort($a_timezones_selected2);
            
            echo "<table>";
            echo "<tr>";
            echo "<td class='right'>";

            if (count($a_timezones)) {
               echo "<select name='timezones_to_add[]' multiple size='5'>";

               foreach ($a_timezones as $key => $val) {
                  echo "<option value='$key'>".$val."</option>";
               }

               echo "</select>";
            }

            echo "</td><td class='center'>";

            if (count($a_timezones)) {
               echo "<input type='submit' class='submit' name='timezones_add' value='".
                     $LANG['buttons'][8]." >>'>";
            }
            echo "<br><br>";

            if (count($a_timezones_selected2)) {
               echo "<input type='submit' class='submit' name='timezones_delete' value='<< ".
                     $LANG['buttons'][6]."'>";
            }
            echo "</td><td>";

         if (count($a_timezones_selected2)) {
            echo "<select name='timezones_to_delete[]' multiple size='5'>";
            foreach ($a_timezones_selected2 as $key => $val) {
               echo "<option value='$key'>".$val."</option>";
            }
            echo "</select>";
         } else {
            echo "&nbsp;";
         }
         echo "</td>";
         echo "</tr>";
         echo "</table>";
      echo "</td>";
      echo "</tr>";

      $this->showFormButtons($options);

      return true;
   }

   
   
   static function getRRDPath() {
      
      $pmConfig = new PluginMonitoringConfig();
      $pmConfig->getFromDB("1");
      return $pmConfig->getField("rrdtoolpath");
   }
   
   
   static function getTimezones() {
      $a_timezones = array();
      $a_timezones['0'] = "GMT";
      $a_timezones['+1'] = "GMT+1";
      $a_timezones['+2'] = "GMT+2";
      $a_timezones['+3'] = "GMT+3";
      $a_timezones['+4'] = "GMT+4";
      $a_timezones['+5'] = "GMT+5";
      $a_timezones['+6'] = "GMT+6";
      $a_timezones['+7'] = "GMT+7";
      $a_timezones['+8'] = "GMT+8";
      $a_timezones['+9'] = "GMT+9";
      $a_timezones['+10'] = "GMT+10";
      $a_timezones['+11'] = "GMT+11";
      $a_timezones['+12'] = "GMT+12";
      $a_timezones['-1'] = "GMT-1";
      $a_timezones['-2'] = "GMT-2";
      $a_timezones['-3'] = "GMT-3";
      $a_timezones['-4'] = "GMT-4";
      $a_timezones['-5'] = "GMT-5";
      $a_timezones['-6'] = "GMT-6";
      $a_timezones['-7'] = "GMT-7";
      $a_timezones['-8'] = "GMT-8";
      $a_timezones['-9'] = "GMT-9";
      $a_timezones['-10'] = "GMT-10";
      $a_timezones['-11'] = "GMT-11";
      
      ksort($a_timezones);
      return $a_timezones;
      
   }

}

?>