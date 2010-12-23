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
function existingShortURL($shortURL, $urlinfile="")
{
  // extract from the digest the firt 2 chars and the first 6 characters
  $character1 = substr($shortURL, 0, 1);
  $character2 = substr($shortURL, 1, 1);

  $filepath = $character1."/".$character2."/".$shortURL;

  if (is_file($filepath)) {
      $f = fopen($filepath,"r");
      $urlinfile = file_get_contents($f);
      fclose($f);
      return True;
  }
  else return False;
}
?>
