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

  // filter url received through Query String
  $url = filter_var($_GET["url"],FILTER_VALIDATE_URL);
  
  $hash = sha1($url);

  echo "Your URL [".$url."]<br/>";
  
  // extract the path to the script from the URL
  // to generate the path to the short URL
  // Example 1 : 
  // . url = http://domain.tld/shorturl.php?url=xxx
  // . baseurl = http://domain.tld/
  // Example 2 :
  // . url = http://domain.tld/test/shorturl.php?url=xxx
  // . baseurl = http://domain.tld/test/

  $baseurl = "http://".$_SERVER['HTTP_HOST']."/";
  $tmp = explode("/",$_SERVER['SCRIPT_NAME']);
  $count = count($tmp) - 1;

  for ($i=1;$i<$count;$i++) {
       $baseurl = $baseurl . $tmp[$i] ."/";
  }
  
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
          $f = fopen($filepath,"r");
          $urlinfile = fgets($f,16000);
          fclose($f); 

          if ($urlinfile == $url) {
              echo "- SHORT URL (already known): [".$shorturl."] shift:".$shift;
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
  
          echo "- SHORT URL (new): [" .$shorturl."] shift:".$shift."<br/>";
          break;
      }
  }
  
  if ($shift==6) { 
      echo "ERROR: Unable to generate a free value of 6 characters for the short URL. Sorry";
      echo "[".$hash."]";
  }
?>
