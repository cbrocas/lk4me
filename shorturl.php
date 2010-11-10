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
  
  // extract from the digest the firt 2 chars and the first 6 characters
  $shift = 0;

  $character1 = substr($hash, $shift , 1);
  $character2 = substr($hash, $shift+1, 1);
  $hash6characters = substr($hash, $shift, 6);

  $dirpath = $character1."/".$character2;
  $filepath = $dirpath."/".$hash6characters;

  // if the directories of the filepath do not exist, create them
  if (!is_dir($dirpath)) 
      mkdir($dirpath, 0700, true);

  if (is_file($filepath)) {
      $f = fopen($filepath,"r");
      $urlinfile = fgets($f,16000);
      fclose($f); 

      if ($urlinfile == $url) {
          echo "- SHORT URL (already known): [".$shorturl."]<br/>";
      }
      else {
	      echo "collision !";
	      exit(1);
      }
      
  }
  else {

      // extract the path to the script from the URL
      // to generate the path to the short URL
      // Example 1 : 
      // . url = http://domain.tld/shorturl.php?url=xxx
      // . shorturl = http://domain.tld/
      // Example 2 :
      // . url = http://domain.tld/test/shorturl.php?url=xxx
      // . shorturl = http://domain.tld/test/

      $shorturl = "http://".$_SERVER['HTTP_HOST']."/";
      $tmp = explode("/",$_SERVER['SCRIPT_NAME']);
      $count = count($tmp) - 1;

      for ($i=1;$i<$count;$i++) {
           $shorturl = $shorturl . $tmp[$i] ."/";
      }

      // add the six chars long hash to the shorturl
      $shorturl = $shorturl . $hash6characters;

      $f = fopen($filepath,"w+");
      fputs($f, $url);
      fclose($f);
  
      echo "- SHORT URL (new): [" .$shorturl."]<br/>";
  }

?>
