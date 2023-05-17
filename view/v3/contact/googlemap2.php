<section class="googleMap">
	<div id="map"></div>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBckxsH19YvM9ThtZIq12yOcVz49NrzXkQ"></script>
	<script type="text/javascript">

		// define googlemap
		var mapPosition=[24.221145, 120.652760];
		var mapStyle   =[
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#444444"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#ffffff"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#BEE3F3"
            },
            {
                "visibility": "on"
            }
        ]
    }
]
		var mapIcon    ='images/tw/mapIcon.svg';

		// make map
		mapPosition={lat:mapPosition[0],lng:mapPosition[1]}
	    google.maps.event.addDomListener(window, 'load', init);
	    function init() {
	        var mapOptions = {
	            zoom: 16,
	            center: mapPosition,
	            scrollwheel: false,
	            styles: mapStyle
	        };
	        var mapElement = document.getElementById('map');
	        var map = new google.maps.Map(mapElement, mapOptions);
	        var marker = new google.maps.Marker({
	            position: mapPosition,
	            map: map,
	            icon: mapIcon,
	        });
	    }
	</script>
</section>
