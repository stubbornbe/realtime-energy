<?
include('config.php');

switch($lang){
  case "NL":
    $yield='opbrengst';
    $consumption='afname';
    $injection="injectie";
    $currentConsumption='huidig verbruik';
    $monthlyPeak="maandpiek";
    $alert='Overschrijding van piekvermogen';
  break;
  case "EN":
    $yield='yield';
    $consumption='demand';
    $injection="injection";
    $currentConsumption='current consumption';
    $monthlyPeak="monthpeak";
    $alert='Exceeding peak consumption';
  break;
}

?>
<!DOCTYPE HTML>
<html lang="NL">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <title><?=$title;?></title>
 
    <base href="<?=$url;?>/" target="_self" />
    
    <!-- MOBILE OPTIMIZATION -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="HandheldFriendly" content="true" />
    <meta name="format-detection" content="telephone=no">
    <meta name="MobileOptimized" content="width" />
    
    <link rel="icon" type="image/png" href="images/favicons//favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="images/favicons//favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicons//apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="<?=$title;?>" />
    <link rel="manifest" href="images/favicons//site.webmanifest" />

    <meta name="author" content="Stubborn BV"/>
    <meta name="robots" content="index, follow" />
    <meta name="keywords" content="Real-time energy viewer" />
    <meta name="description" content="<?=$title;?>" />
		
    <meta property="og:title" content="<?=$title;?>" /> 
    <meta property="og:site_name" content="<?=$title;?>"/>
    <meta property="og:description" content="<?=$title?>" />
    <meta property="og:url" content="<?=$url;?>" />
    <meta property="og:type" content="website" />
		<? /*<meta property="og:image" content="<?=$url;?>/images/metalogo.png"/>
		<meta property="og:image:secure_url" content="<?=$url;?>/images/metalogo.png"/>*/?>
		<meta property="og:image:alt" content="<?=$title?>"/>
    <link rel="stylesheet" href="css/reset.css" type="text/css" />
    <link rel="stylesheet" href="css/grid.css" type="text/css" />
    <? /*<link rel="stylesheet" href="css/default.css" type="text/css" />*/?>
    <link rel="stylesheet" href="css/master.css" type="text/css" />
		<?/*<link rel="stylesheet" href="css/default_after.css" type="text/css" />
		<link rel="stylesheet" href="css/mediaqueries.css" type="text/css" />*/?>
		
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href='https://fonts.googleapis.com/css?family=Inter:400,700' rel='stylesheet' type='text/css' />
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/stubborn.js"></script>
</head>

<body>
<div class="bovenkant">
  <div class="centerCont">
    <div class="rfll col span2"></div>
    <div class="rfll span20">
      <div class="sfeerBol1"></div>
      <div class="sfeerBol2"></div>
      
      <div class="title"><h1>Realtime<br />energy</h1></div>
      <div class="zonneCont">
        <div class="zonBol1"></div>
        <div class="zonBol2">
          <div class="w100 txtCenter zonTitel"><?=$yield;?></div>
          <div class="w100 txtCenter zonWaarde" id="sunnyIn">0</div>
          <div class="w100 txtCenter zonEenheid">kW</div>
        </div>
      </div>
      <a class="btnVerbruiksLijst" href="#" id="verbruiksLijst"></a>
    </div>
  </div>
</div>
<div class="onderkant">
  <div class="centerCont">
    <div class="alertBox" id="alertBox"><?=$alert;?></div>
    
    
    <div class="valBoxAbs afname" id="tellerBox">
      <div class="waardeIcon afnameIcon" id="tellerIcon"></div>
      <div class="waardeBox">
        <div class="waardeWat" id="tellerWat"><?=$consumption;?></div>
        <div class="waardeVal" id="electraValue">?</div>
      </div>
      <div class="waardeEenheid">kW</div>
    </div>
    
    
    <div class="valBox verbruik">
      <div class="waardeIcon verbruikIcon"></div>
      <div class="waardeBox">
        <div class="waardeWat"><?=$currentConsumption;?></div>
        <div class="waardeVal" id="ownValue">?</div>
        <div class="minus waardeVal" id="minus">-</div>
      </div>
      <div class="waardeEenheid">kW</div>
    </div>
    
    <div class="vlBoxHalfCont">
      <div class="valBoxHalf">
        <div class="kwartPiek" id="kartTijd">00 : 00</div>
        <div class="piekTekst" id="kartPiek">0</div>
        <div class="piekEenheid">kW</div>
      </div>
      
      <div class="valBoxHalf rflr">
        <div class="maandPiek"><?=$monthlyPeak;?></div>
        <div class="piekTekst" id="maandPiek">0</div>
        <div class="piekEenheid">kW</div>
      </div>
    </div>
    
  </div>
</div>

<div class="overlay hide" id="overlay"></div>
<div class="apparatenLijst hide" id="appList">
  <div class="centerCont">
    <div class="rfll col span2"></div>
      <div class="rfll span20">
      <div class="rfll w100 mt80px mb80px">
        <div class="apparaat mt80px">
          <div class="apparaatNaam">Wasmachine</div>
          <div class="apparaatVerbruik">0,761 <span class="apparaatEH">kW</span></div>
        </div>
        
        <div class="apparaat">
          <div class="apparaatNaam">Droogkast</div>
          <div class="apparaatVerbruik">0,761 <span class="apparaatEH">kW</span></div>
        </div>
        
        <div class="apparaat">
          <div class="apparaatNaam">Stofzuiger</div>
          <div class="apparaatVerbruik">0,761 <span class="apparaatEH">kW</span></div>
        </div>
        
        <div class="apparaat">
          <div class="apparaatNaam">Vaatwas</div>
          <div class="apparaatVerbruik">0,761 <span class="apparaatEH">kW</span></div>
        </div>
        
        <div class="apparaat">
          <div class="apparaatNaam">Oven 200&deg;</div>
          <div class="apparaatVerbruik">0,761 <span class="apparaatEH">kW</span></div>
        </div>
        
        <div class="apparaat">
          <div class="apparaatNaam">Kookplaat 1 vuur</div>
          <div class="apparaatVerbruik">0,761 <span class="apparaatEH">kW</span></div>
        </div>
      </div>
      <a class="btnClose" href="#" id="apparaatClose">
        <div class="crosssign_stem"></div>
        <div class="crosssign_stem2"></div>
      </a>
    </div>
  </div>
</div>

<input type="hidden" id="consumption" value="<?=$consumption;?>" />
<input type="hidden" id="injection" value="<?=$injection;?>" />
</body>
</html>
