


$( document ).ready(function() {
   console.log( "document loaded" );
   setListeners();
   askForLights();
});


function setListeners(){
  $('.bombilla').each(function(index){
     $(this).click(function(){
        var bombillaId = $(this).attr("idbom")
        var valueBombilla = $(this).attr("status");
        var valueToToggle = (valueBombilla == 'true');
        valueToToggle = !valueToToggle;
        //change the statu

        setBombilla(bombillaId, this, valueToToggle);
     });
  });
}

function setBombilla(bombillaId, $selector, valueBombilla){
   $.get("https://atenea-ia.tk/yaya/api/insert_php.php?bombilla=" + bombillaId, function( data ) {
      //get valores de data
      if(valueBombilla){
         $($selector).removeClass('apagada');
      } else {
         $($selector).addClass('apagada');
      }

      $($selector).attr("status", valueBombilla)
    });
}


function askForLights(){
   setTimeout(function(){
      console.log("Asking for lights....")
      requestForLights();
      askForLights();

   }, 5000);
}

function requestForLights(){
   var respuesta;
   var results;
   $.get("https://atenea-ia.tk/yaya/api/insert_php.php", function( data ) {
      respuesta = data.toString();
      results = respuesta.split("|");

      $.each(results, function (index, value) {
        var twovalues = value.split("-");
        var idBombilla = twovalues[0];
        var valorBombilla = twovalues[1];
        updateBombillas(idBombilla, valorBombilla);
        
    });
});
}

function updateBombillas(bombillaId, value){
   var valueToUpdate = (value == '1');
   $('#' + bombillaId).attr("status", valueToUpdate);

   if(valueToUpdate ){
      $('#bombilla' + bombillaId).removeClass('apagada');
   } else {
      $('#bombilla' + bombillaId).addClass('apagada');
   }
}