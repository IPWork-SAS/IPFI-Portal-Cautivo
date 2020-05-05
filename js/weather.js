
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(getPosSuccess, getPosErr);
} else {
    alert('geolocation not available?! What year is this?');
    // IP address or prompt for city?
}
// getCurrentPosition: Successful return
function getPosSuccess(pos) {
  // Get the coordinates and accuracy properties from the returned object
  var geoLat = pos.coords.latitude.toFixed(5);
  var geoLng = pos.coords.longitude.toFixed(5);
  var geoAcc = pos.coords.accuracy.toFixed(1);

    //API Variables
    var proxy = 'https://cors-anywhere.herokuapp.com/';
    var dsAPI = "api.openweathermap.org/data/2.5/weather?lat=";
    var cityAPI = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat="

    //Concatenate API Variables into a URLRequest
    var URLRequestWeather = proxy + dsAPI + String(geoLat) + "&lon=" + String(geoLng) + "&appid=0e27a4ab9a77087ef72775fe34dcf0e8"
    var URLRequestCity = proxy + cityAPI + String(geoLat) + "&lon=" + String(geoLng)

    //Make the jQuery.getJSON request
    $.getJSON( URLRequestWeather )
      //Success promise
      .done(function( data ) {
        $(".img-weather").prepend("");
        $(".img-weather").prepend('<img src="http://openweathermap.org/img/wn/'+data.weather[0].icon+'@2x.png">')
        // $("#geoLoc").text("Lat: "+geoLat + ", " + "Long:" +geoLng);
        $("#wTemp").html("");
        $("#wTemp").html(data.main.temp- 273.15);
      })
      //Error promise
      .fail(function() {
        alert('Sorry, something bad happened when retrieving the weather');
      }

      
    );

    $.getJSON( URLRequestCity )
      .done(function( data ) {
        $("#wSummary").text(data.address.city);
      })
      //Error promise
      .fail(function() {
        alert('Sorry, something bad happened when retrieving the weather');
      }
    );
}
// getCurrentPosition: Error returned
function getPosErr(err) {
  switch (err.code) {
    case err.PERMISSION_DENIED:
      alert("User denied the request for Geolocation.");
      break;
    case err.POSITION_UNAVAILABLE:
      alert("Location information is unavailable.");
      break;
    case err.TIMEOUT:
      alert("The request to get user location timed out.");
      break;
    default:
      alert("An unknown error occurred.");
  }
}
