angular.module( 'apiService', [] )

.factory( 'Register', function( $resource ) {
    return $resource( '/api/create' );
})

.factory( 'Logout', function( $resource ) {
    return $resource( '/api/logout' );
})

.factory( 'Profile', function( $resource ) {
    return $resource( '/api/user/:userId/profile/:profileId', {userId: '@uid', profileId: '@pid'} );
})

.factory( 'Conferences', function( $resource ) {
    return $resource( '/api/conferences');
})
/*
.factory( 'Conference', function( $resource ) {
    return {

        upcoming: function() {
            return $resource( '/api/conferences/upcoming' );
        }

        past: function () {
            return $resource( '/api/conferences/past' );
        }

        fetch: function () {
            return $resource( '/api/conferences/:cid', {cid: 'cid'});
        },

        status: function () {
            return $resource( '/api/conferences/status/:status', {status: '@status'});
        },

        attendees: function () {
            return $resource( '/api/conferences/:cid/attendees/:aid', {cid: '@cid', attId: '@aid'} );
        },

        vehicles: function () {
            return $resource( '/api/conferences/:cid/vehicles/:type/:vid', {cid: '@cid', type: '@type', vid: '@vid'} );
        },

        inventory: function () {
            return $resource( '/api/conferences/:cid/inventory/:id', {cid: '@cid', iid: '@id'} );
        },

        accommodations: function () {
            return $resource( '/api/conferences/:cid/accommodations/:aid', {cid: '@cid', accId: '@aid'} );
        }

        rooms: function () {
            return $resource( '/api/conferences/:cid/accommodations/:aid/:rid', {cid: '@cid', accId: '@aid', rid: '@rid'} );
        }

        flights: function () {
            return $resource( '/api/conferences/:cid/flights/:fid', {cid: '@cid', fid: '@fid'} );
        }
    }
})

.factory( 'Event', function( $resource ) {
    return {

        fetch: function () {
            return $resource( '/api/conferences/:cid/events/:eid', {cid: '@cid', eid: '@eid'} );
        }, 

        status: function () {
            return $resource( '/api/events/status/:status', {status: '@status'} )
        }

        attendees: function () {
            return $resource( '/api/events/:eid/attendees/:aid', {eid: '@eid', attId: '@aid'} );
        },

        vehicles: function () {
            return $resource( '/api/events/:eid/vehicles/:type/:vid', {eid: '@eid', type: '@type', vid: '@vid'} );
        },
    }
})
*/