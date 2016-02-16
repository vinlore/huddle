angular.module('mapService', [])
/*
 * Formats a URL for Google Static Maps API
 * @param  location: String (city, country or co-ords), size: String (widthxheight)
 *         zoom: Int, markers: Array( { color: HEX or String, label: String, location: String (city, country or co-ords)} )
 */
.factory( 'Gmap', function () {

    return function ( location, size, zoom, markers ) {

        var base_url = "https://maps.googleapis.com/maps/api/staticmap?";
        var p1 = "center=" + location;
        var p2 = "&size=" + size;
        var p3 = "&zoom=" + zoom;
        var parameters = p1 + p2 + p3;
        var m;
        for ( m = 0; m < markers.length; m++ ) {
            parameters += "&markers=color:" + m.color + "%7Clabel:" + m.label + m.location;
        }
        return base_url + parameters + "&format=jpg";

    }

})