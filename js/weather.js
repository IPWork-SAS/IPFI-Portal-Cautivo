function getPosSuccess(geoLat, geoLng) {
  var dsAPI = "https://api.openweathermap.org/data/2.5/weather?lat=";
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
      alert('Lo sentimos, algo pasó al traer la información del clima, recargue nuevamente la página');
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