var contactPackage = {
    contact:{
        init: function(){

        },
        gmapInit: function(){
            /*
             Map Settings

             Find the Latitude and Longitude of your address:
             - http://universimmedia.pagesperso-orange.fr/geo/loc.htm
             - http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude/

             */

            // Map Markers
            var mapMarkers = [{
                address: "354/47/10/7 Quốc Lộ 1, Khu Phố 3, Bình Hưng Hoà B, Bình Tân, việt nam",
                html: "<strong>Cửa Hàng</strong><br>354/47/10/7 Quốc Lộ 1, Khu Phố 3, Bình Hưng Hoà B, Bình Tân",
                icon: {
                    image: "/../../img/pin.png",
                    iconsize: [26, 46],
                    iconanchor: [12, 46]
                },
                popup: true
            }];

            // Map Initial Location
            var initLatitude = 10.751659;
            var initLongitude = 106.664363;

            // Map Extended Settings
            var mapSettings = {
                controls: {
                    draggable: true,
                    panControl: true,
                    zoomControl: true,
                    mapTypeControl: true,
                    scaleControl: true,
                    streetViewControl: true,
                    overviewMapControl: true
                },
                scrollwheel: false,
                markers: mapMarkers,
                latitude: initLatitude,
                longitude: initLongitude,
                zoom: 16
            };

            var map = $("#googlemaps").gMap(mapSettings);

            // Map Center At
            var mapCenterAt = function(options, e) {
                e.preventDefault();
                $("#googlemaps").gMap("centerAt", options);
            }

        }
    }
};

$.extend(true, Kacana, contactPackage);