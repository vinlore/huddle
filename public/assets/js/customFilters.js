angular.module( 'customFilters', [] )
.filter( 'time', function () {
    return function ( input ) {
        var temp = input - 12;
        if ( temp < 0 ) {
            return input + "am";
        } else if ( temp == 0 ) {
            return "12pm";
        } else {
            return temp + "pm";
        };
    };
})