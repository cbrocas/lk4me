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
?>

<form id="url" name="URL" action="shorturl.php" method="GET" enctype="application/x-www-form-urlencoded" novalidate="novalidate">

Your long URL :<br>
<input type="url" name="url" size="40" value="<?php if (isset($url)) echo $url; ?>" >
<button type="submit" name="go">shorten !</button>
</form>  
<br/>

<?php
// Display shortened URL if its value has been updated
if ($shorturl!=getURIbase()."...")
{
?>

Your short link: <span class="red"><?php echo $shorturl;?></span><br/>

<?php
}

// display the QRCode of the shorten URL if :
// . short url is a valid short url
// . gd library extension for php is loaded FilePathFromShortURL($shorturl)
$qrcodefilepath = FilePathFromShortURL($shorturl).".png";
if ((is_file($qrcodefilepath)) && ($shorturl!=getURIbase()."...")) 
{
?>
<br/>
QR code containing your short link:<br/>
<img class="qrcode" src="<?php echo $qrcodefilepath;?>" alt="qrcode for <?php echo qrcodefilepath;?>" />
<?php
}
?>
