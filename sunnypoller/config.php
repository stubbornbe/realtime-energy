<?php 
/***********
PHP script to read out Sunnyboy values and writeout to file in json format

Inputs needed: 
- URL of Sunnyboy (Fixed IP / DHCP reservation needed)
- Password of the "user" user
- Path to store the current API token

To prevent new API login every run, the API token is written to sunnyToken.txt and tested first before issuing a new token.
If you find the location insecure, set up a proper one.

***********/
/***********TO CONFIGURE************/
$hostname="<YOUR HOSTNAME OR IP>";
$pw="<YOUR SMA USER PASSWORD>";
$sunnyTokenPath=".";
/***********END TO CONFIGURE************/

 ?>