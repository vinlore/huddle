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

.filter( 'upcoming', function () {
    return function (input) {
        var result = {
            upcoming: [],
            past: []
        };
        for (var i=0; i<input.length; i++) {
            var today = new Date();
            var date = new Date(input[i].end_date);
            if (date >= today) {
                result.upcoming.push(input[i]);
            } else {
                result.past.push(input[i]);
            }
        }
        return result;
    }
})