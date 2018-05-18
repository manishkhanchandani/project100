
	<!-- map starts -->
<?php

$latitude = 37.3382082;
$longitude = -121.88632860000001;
?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseLocation"><span class="glyphicon glyphicon-file">
				</span>Location</a>
			</h4>
		</div>
		<div id="collapseLocation" class="panel-collapse collapse in">
			<div class="panel-body">
				
				
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<div id="latlng"></div>
						</div>
						<div class="form-group">
						  <div id="mapCanvas"></div>
						<input type="text" name="city_id" id="city_id" placeholder="city_id" value="">
						<input type="text" name="city" id="locality" placeholder="city" value="">
						<input type="text" name="state" id="administrative_area_level_1" placeholder="state" value="">
						<input type="text" name="country" id="country" placeholder="country" value="">
						<input type="text" name="county" id="administrative_area_level_2" placeholder="county" value="">
						<input type="text" name="lat" id="lat" placeholder="lat" value="">
						<input type="text" name="lon" id="lon" placeholder="lon" value="">
						  <input id="address" name="address" placeholder="Enter your address"
													   onFocus="geolocate()" type="text" style="width:70%" value="<?php echo (!empty($_POST['address'])) ? $_POST['address'] : ''; ?>" class="addressBox"></input>
						  <input type="button" value="Find Address" onclick="codeAddress()">
						  <br /><br />
						  <p><b>Note: If you feel that the address in above field is incorrect, then please re-enter your address here below (after you move the map icon to proper location):</b><br /><br />
						  <input id="address2" name="address2" placeholder="Enter custom address" type="text" style="width:100%" value="<?php echo (!empty($_POST['address2'])) ? $_POST['address2'] : ''; ?>" />
													   </p>
						</div>
						<div class="form-group">
						  <input name="showAddress" type="checkbox" id="showAddress" value="1" <?php if ((isset($_POST['showAddress']) && $_POST['showAddress'] == 1) || !isset($_POST['showAddress'])) { ?>checked="checked"<?php } ?>>
						  <label for="showAddress">Show on map </label>
						</div>
					</div>
				</div>
				
				
				
				
				
			</div>
		</div>
	</div>
<style type="text/css">

#mapCanvas {
    width: 100%;
    height:300px;
    padding-bottom: 15px;
    margin-bottom: 15px;
}
</style>
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        var str = e.target.className;
        var n = str.indexOf("addressBox");
        if (n === -1) {
          return true;
        } else {
          return false;
        }
        /*str = e.currentTarget.className;
        n = str.indexOf("formMEnter");
        if (n === -1) {
            e.preventDefault();
            return false;
        }*/
        return true;
    }
});
</script>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCWqKxrgU8N1SGtNoD6uD6wFoGeEz0xwbs&libraries=places"></script>
<script language="javascript">
var geocoder;
var map;
var marker;
function showaddress(lat, lng)
{
  filllatlng(lat,lng)
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        //console.log(results);
        /*var len = (results[0].address_components).length;
        var zip =  results[0].address_components[(len-1)].short_name;
        var country =  results[0].address_components[(len-2)].short_name;
        var state =  results[0].address_components[(len-3)].short_name;
        var county =  results[0].address_components[(len-4)].short_name;
        var city =  results[0].address_components[(len-5)].short_name;
        $('#curCity').val(city);
        var addr = "lat: "+lat + "|lng:" + lng + "|addr:" + results[0].formatted_address + "|zip:" + zip + "|city:" + city + "|state:" + state + "|country:" + country + "|county:" + county;
        console.log(addr);*/
        $('#address').val(results[0].formatted_address);
      } else {
        //alert("Geocoder failed due to: " + status);
      }
    });
}
function codeAddress() {
  var address = document.getElementById('address').value;
  if (!address) {
    return false;
  }
  $('#address2').val(address);
  deleteMarkers();
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      /*map.setCenter(results[0].geometry.location);
      marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });*/
      showmap(results[0].geometry.location.lat(),results[0].geometry.location.lng());
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

// Sets the map on all markers in the array.
function setAllMap(map) {
  marker.setMap(map);
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setAllMap(null);
}
// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  clearMarkers();
  marker = null;
}
function filllatlng(lat,lng)
{
  
  $('#latlng').html(lat + "," + lng);
  $('#lat').val(lat);
  $('#lng').val(lng);
}
function showmap(lat,lng)
{
  filllatlng(lat,lng);
  var myLatlng = new google.maps.LatLng(lat,lng);
  var mapOptions = {
    zoom: 17,
    center: myLatlng,
    panControl: true,
    zoomControl: true,
    scaleControl: true
  }
  map = new google.maps.Map(document.getElementById('mapCanvas'),
                                mapOptions);
  marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
	  draggable:true,
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    // 3 seconds after the center of the map has changed, pan back to the
    // marker.
	  
    showaddress(marker.getPosition().lat(), marker.getPosition().lng());
  });
}
function displayLocation( lat, lng ) {
  //showaddress(lat, lng);
  showmap(lat,lng);
}
function displaySelfLocation( position ) {
  lat = position.coords.latitude;
  lng = position.coords.longitude;
  showaddress(lat, lng);
  showmap(lat,lng);
}
function handleError( error ) {
	var errorMessage = [ 
		'We are not quite sure what happened.',
		'Sorry. Permission to find your location has been denied.',
		'Sorry. Your position could not be determined.',
		'Sorry. Timed out.'
	];

	//console.log( errorMessage[ error.code ] );
  
  var latitude = '<?php echo !empty($latitude) ? $latitude : 0; ?>';
  var longitude = '<?php echo !empty($longitude) ? $longitude : 0; ?>';
  displayLocation(latitude, longitude);
}
function initialize() {
    var newlat = parseFloat('<?php echo !empty($latitude) ? $latitude : 0; ?>');
    var newlon = parseFloat('<?php echo !empty($longitude) ? $longitude : 0; ?>');
    if (newlat && newlon) {
      displayLocation(newlat, newlon);
    } else if ( navigator.geolocation ) {
      navigator.geolocation.getCurrentPosition( displaySelfLocation, handleError );
    } else {
      var latitude = '<?php echo !empty($latitude) ? $latitude : 0; ?>';
      var longitude = '<?php echo !empty($longitude) ? $longitude : 0; ?>';
      displayLocation(latitude, longitude);
    }
}

//autocomplete

var placeSearch, autocomplete;
var componentForm = {
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  administrative_area_level_2: 'short_name',
  country: 'long_name'
};
function init() {
      // Create the autocomplete object, restricting the search
      // to geographical location types.
      autocomplete = new google.maps.places.Autocomplete(
          /** @type {HTMLInputElement} */(document.getElementById('address')),
          { types: ['(cities)'] });
      // When the user selects an address from the dropdown,
      // populate the address fields in the form.
      google.maps.event.addListener(autocomplete, 'place_changed', function() {
        fillInAddress();
      });
    }

function fillInAddress() {
      // Get the place details from the autocomplete object.
      var place = autocomplete.getPlace();

      lat = place.geometry.location.lat();
      lng = place.geometry.location.lng();
	  document.getElementById('city_id').value = place.place_id;

	  $('#lat').val(lat);
	  $('#lon').val(lng);
	  
	for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];
		if (componentForm[addressType]) {
			var val = place.address_components[i][componentForm[addressType]];
			document.getElementById(addressType).value = val;
		}
	}
	  
      showmap(lat,lng);
    }

function geolocate() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var geolocation = new google.maps.LatLng(
              position.coords.latitude, position.coords.longitude);
          autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
              geolocation));
        });
      }
    }
google.maps.event.addDomListener(window, 'load', initialize);

</script>
<script language="javascript">
$( document ).ready(function() {
    init();
});
</script>
	<!-- map starts -->