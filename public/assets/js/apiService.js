angular.module( 'apiService', [] )

.factory( 'Register', function( $resource ) {
    return $resource( '/api/register' );
})

.factory( 'Logout', function( $resource ) {
    return $resource( '/api/logout' );
})

.factory( 'Profile', function( $resource ) {
    return $resource( '/api/user/:userId/profile/:profileId', {userId: '@uid', profileId: '@pid'} );
})

/*.factory( 'Conferences', function( $resource ) {
    return $resource( '/api/conferences/:id', {id: '@cid'});
})

.factory( 'Conference', function( $resource ) {
    return {

        get: function() {
            return $resource( '/api/conferences/:cid', {cid: 'cid'});
        },

        attendees: function() {
            return $resource( '/api/conferences/:cid/attendees/:aid', {cid: '@cid', aid: '@aid'} );
        },

        arrivalTransport: function() {
            return $resource( '/api/conferences/:cid/arrivalTransport/:aid', {cid: '@cid', aid: '@aid'} );
        },

        departTransport: function() {
            return $resource( '/api/conferences/:cid/departTransport/:did', {cid: '@cid', aid: '@aid'} );
        },

        inventory: function() {
            return $resource( '/api/conferences/:cid/inventory/:iid', {cid: '@cid', iid: '@id'} );
        },

        accommodation: function() {
            return $resource( '/api/conferneces/:cid/accommodations/:aid', {cid: '@cid', aid: '@aid'} );
        }
    }
})

.factory( 'Events', function( $resource ) {
    return $resource( '/api/conferences/events');
})

.factory( 'Event', function( $resource ) {
    return {

        get: function() {
            return $resource( '/api/conferences/:cid/events/:eid', {cid: '@cid', eid: '@eid'} );
        }, 

        attendees: function() {
            return $resource( '/api/events/:eid/attendees/:aid', {eid: '@eid', aid: '@aid'} );
        },

        arrivalTransport: function() {
            return $resource( '/api/events/:eid/arrivalTransport/:aid', {eid: '@eid', aid: '@aid'} );
        },

        departTransport: function( eventId ) {
            return $resource( '/api/events/:eid/departTransport/:did', {eid: '@eid', did: '@did'} );
        }
    }
})
*/