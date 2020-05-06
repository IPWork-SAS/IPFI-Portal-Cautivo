    // se deja el código incompleto por el hecho de que en el backend, en Campaña Controller, se unirá la parte faltante, inicializando 2 variables y ejecutando automaticamente el código con el documento.ready
    getPosSuccess(geoLat,geoLng);
    function getPosSuccess(geoLat, geoLng) {
        var dsAPI = "http://api.openweathermap.org/data/2.5/weather?lat=";
        var cityAPI = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat="
        var URLRequestWeather = dsAPI + String(geoLat) + "&lon=" + String(geoLng) + "&appid=0e27a4ab9a77087ef72775fe34dcf0e8"
        var URLRequestCity = cityAPI + String(geoLat) + "&lon=" + String(geoLng)
        $.getJSON( URLRequestWeather )
          .done(function( data ) {
            $(".img-weather").prepend("");
            $(".img-weather").prepend('<img src="http://openweathermap.org/img/wn/'+data.weather[0].icon+'@2x.png">')
            $("#wTemp").html("");
            $("#wTemp").html(Math.round(data.main.temp_max- 273.15));
          })
          .fail(function() {
            alert('Sorry, something bad happened when retrieving the weather');
          }
        );
        $.getJSON( URLRequestCity )
          .done(function( data ) {
            if('city' in data.address){
              $("#wSummary").text(data.address.city);
            }else{
              $("#wSummary").text(data.address.county);
            }
          })
          .fail(function() {
            alert('Las coordenadas no son validas, por favor verifique');
          }
        );
    }
  }
)