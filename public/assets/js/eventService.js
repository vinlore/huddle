angular.module( 'eventService', [] )
.factory( 'Events', function ( $resource ) {

    return {

        all: function(cid) {
            return $resource( 'mockdata/events.json' ).query();
        }
    }

} )
