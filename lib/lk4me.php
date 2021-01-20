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

/**
 * Check if the short URL value is correct.
 * 
 * Correct values:
 * - only numbers and letters
 * - six characters long
 * 
 * @param String $shortURL short URL vlaue
 * @return Boolean True if short URL value is correct.
 */
function validShortURL($shortURL)
{
  // validate hash parameter (numbers or letters, 6 chars long))
  if ((preg_match("$([a-z0-9]{6})$",$shortURL,$values) != 1)||(strlen($shortURL)!=6))
      return False;
  else
      return True;
}


/**
 * Check if the short URL value matchs with an existing long URL in a file.
 * 
 * @param String $shortURL short URL value
 * @param String $urlinfile the URL stored in the file and matching with the short URL 
 * @return Boolean True if short URL value matchs with an existing URL
 */
function existingShortURL($shortURL, &$urlinfile="")
{
  // extract from the digest the firt 2 chars and the first 6 characters
  $character1 = substr($shortURL, 0, 1);
  $character2 = substr($shortURL, 1, 1);

  $filepath = $character1."/".$character2."/".$shortURL;

  if (is_file($filepath)) {
      $urlinfile = file_get_contents($filepath);
      if ($urlinfile === false)
          return False;
      return True; 
  }
  else return False;
}

/**
 * Returns the base of the URI of the current URI in the browser.
 * extract the path to the script from the URI
 * to generate the path to the short URI
 * Example 1 : 
 * . uri = http://domain.tld/shorturl.php?url=xxx
 * . baseurl = http://domain.tld/
 * Example 2 :
 * . uri = http://domain.tld/test/shorturl.php?url=xxx
 * . baseurl = http://domain.tld/test/
 * @return String URI base of the current URI
 */
function getURIbase(){
  $baseuri = 'http';
  
  if ($_SERVER["HTTPS"] == "on") {$baseuri .= "s";}
  $baseuri .= "://";
  
  if ($_SERVER["SERVER_PORT"] != "80") {
     $baseuri .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/";
  } else {
         $baseuri .= $_SERVER["SERVER_NAME"]."/";
  }

  $tmp = explode("/",$_SERVER['SCRIPT_NAME']);
  $count = count($tmp) - 1;

  for ($i=1;$i<$count;$i++) {
       $baseuri = $baseuri . $tmp[$i] ."/";
  }
  return $baseuri;
}

/**
 * @return Boolean True and the short url value is stored in the shorturl variable.
 * Returns false if we were unable to generate, after 6 attemtps, 
 * a hash which the six first characters are not already used
 * and shorturl variable left unset.
 * 
 * @param String $url the long URL that has to be shorten
 * @param String $baseurl the base of the short URL (for ex. : http://lk4.me/)
 * @param String $shortURL the short URL value set by the function
 * @return Boolean True if the function has been able to generate a short URL
 * Returns false if we were unable to generate, after 6 attemtps, 
 * a hash which the six first characters are not already used and shorturl variable 
 * left unset.

 */
function generateShortURI($url, $baseurl, &$shorturl=""){
  $shift = 0;
  $hash=sha1($url);

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
  // if we were unable to generate, after 6 attemtps, a hash which the six first characters 
  // are not already used, return false and shorturl variable left unset.
  // Else, return true and the short url value is stored in the shorturl variable.  
  if ($shift==6) 
     return false;
  else
     return $shorturl;
} 

/**
 * Return the 6 chars long string of the short URL value .
 * 
 * @param String $shortURL short URL value
 * @return string the 6 chars long value of the short URL value
 */
function FilePathFromShortURL($shortURL)
{
  // extract the final part of the short URL
  $sixcharsstr = strrchr($shortURL, "/");
  $sixcharsstr = substr($sixcharsstr,1);
  $character1 = substr($sixcharsstr, 0, 1);
  $character2 = substr($sixcharsstr, 1, 1);
      
  $dirpath = $character1."/".$character2;
  return $dirpath."/".$sixcharsstr;
}

?>
