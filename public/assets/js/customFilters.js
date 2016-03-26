angular.module( 'customFilters', [] )
.filter( 'time', function () {
    return function (input) {
        return input.substr(0,2) + ':' + input.substr(2,4);
    }
})

.filter( 'randomize', function() {
    return function( input, scope ) {
        if ( input != null && input > 0 ) {
            return Math.floor( (Math.random() * input ) + 1 );
        }
    }
})