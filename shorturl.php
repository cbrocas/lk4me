<?php
/*
  Copyright 2010 Christophe Brocas

  This file is part of lk4me.

  lk4me is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  lk4me is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with lk4me.  If not, see <http://www.gnu.org/licenses/>.
*/
  
  include('html/lk4me.html.inc.php');
  require('lib/lk4me.php');

  // filter url received through Query String
  $url = filter_var($_GET["url"],FILTER_SANITIZE_URL);
  
  $hash = sha1($url);
  $baseurl = getURIbase();
  $shift = 0;

  while($shift < 6) {
      // extract from the digest the firt 2 chars and the first 6 characters
      $character1 = substr($hash, $shift , 1);
      $character2 = substr($hash, $shift+1, 1);
      $hash6characters = substr($hash, $shift, 6);
      
      $dirpath = $character1."/".$character2;
      $filepath = $dirpath."/".$hash6characters;

      // if the directories of the filepath do not exist, create them
      if (!is_dir($dirpath)) 
          mkdir($dirpath, 0700, true);

      // add the six chars long hash to the shorturl
      $shorturl = $baseurl . $hash6characters;

      if (is_file($filepath)) {
          $urlinfile = file_get_contents($filepath);
          
          if ($urlinfile == $url) {
              break;
          }
          else {
	     // collision : first 6 characters of the sha-1 hash of the received URL
             //             are already used by a 6 char. long hash of another URL. We shift 
             //             for one character on the right of the sha-1 hash of the 
             //             received URL and retry. We do this up to 6 times.
	     $shift=$shift+1;
         }
      
      }
      else {
          $f = fopen($filepath,"w+");
          fputs($f, $url);
          fclose($f);
          break;
      }
  }
  
  if ($shift==6) { 
      echo "<span class=\"red\">ERROR: Unable to generate a free value of 6 characters for the short URL. Sorry</span> <br/>";

  }
  require('form.html.inc.php');
?>
</body>
</html>
