
$(function() {
  
  var alert=2.5;
  
  var ownUse=0;
  var electraUse=0;
  var sunnyGen=0;
  var alertOn=false;
  
  function sendSunnyRequest(){
    $.ajax({
      url: "updateSunny.php",
      success: 
      function(result){
        var error=false;
        try {
          var jsonData = JSON.parse(result);
          if(jsonData['result']!="success"){
            error=true;
          }
        }catch (e) {
          error=true;
        }
        
        if(!error){
          sunnyGen=Number(jsonData['opbrengst']);
          $('#sunnyIn').text(sunnyGen.toFixed(3)); //insert text of test.php into your div
          setVisuals();
        }
        setTimeout(function(){
            sendSunnyRequest(); //this will send request again and again;
        }, 2000);
      }
    });
  }
  sendSunnyRequest();
  
  function sendRequest(){
    $.ajax({
      url: "updateTeller.php",
      success: 
      function(result){
        var error=false;
        try {
          var jsonData = JSON.parse(result);
          if(jsonData['result']!="success"){
            error=true;
          }
        }catch (e) {
          error=true;
        }
        
        if(!error){  
          $('#kartPiek').text(Number(jsonData['kwartPiek']).toFixed(3));
          $('#maandPiek').text(Number(jsonData['maandPiek']).toFixed(3));
          $('#kartTijd').text(jsonData['timestamp']);

          if(Number(jsonData['verbruik'])>Number(jsonData['opbrengst'])){
            electraUse=Number(jsonData['verbruik']);
            $('#electraValue').text(electraUse.toFixed(3));
          }else{
            electraUse=-Number(jsonData['opbrengst']);
            $('#electraValue').text(Number(jsonData['opbrengst']).toFixed(3));
          }
          setVisuals();
        }
        setTimeout(function(){
            sendRequest(); //this will send request again and again;
        }, 1000);
      }
    });
  }
  sendRequest();
  
  function setVisuals(){

    if(electraUse>0){
      $('#tellerIcon').removeClass("injectieIcon");
      $('#tellerBox').removeClass("injectie");
      $('#tellerWat').text($('#consumption').val());
      if((electraUse-sunnyGen)>=alert){
        $('#electraValue').addClass("waardeAlert");
        //$('#alertBox').animate({'marginTop': "110px"},1000);
        $('#alertBox').addClass('alertBoxTranition');
        alertOn=true;
        /*margin-top: 57px;*/
      }else if(alertOn){
        $('#electraValue').removeClass("waardeAlert");
        $('#alertBox').removeClass('alertBoxTranition');
        alertOn=false;
      }
    }else{
      $('#tellerBox').addClass("injectie");
      $('#tellerIcon').addClass("injectieIcon");
      $('#tellerWat').text($('#injection').val());
      if(alertOn){
        $('#electraValue').removeClass("waardeAlert");
        $('#alertBox').removeClass('alertBoxTranition');
        alertOn=false;
      }
    }
    
    if(electraUse>=0){
      var ownUse=electraUse+sunnyGen;
    }else{
      var ownUse=sunnyGen+electraUse;
    }
    $('#ownValue').text(ownUse.toFixed(3));
  }
  
  $('#verbruiksLijst').click(function(){
		$('#overlay').show();
    $('#appList').show();
	})
  
  $('#apparaatClose').click(function(){
		$('#overlay').hide();
    $('#appList').hide();
	})
  
  

})