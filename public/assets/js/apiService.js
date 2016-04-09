angular.module( 'apiService', [] )

.factory( 'Register', function ( $resource ) {
    return $resource( '/api/auth/register' );
})

.factory('Activity', function ( $resource ){
    return $resource('/api/activities');
})

.factory( 'Logout', function ( $resource ) {
    return $resource( '/api/auth/logout' );
})

.factory( 'Password', function ( $resource ) {
    return $resource( '/api/users/:uid/password', { uid: '@uid' } );
})

.factory('ProfileAttendsConferences', function ( $resource ){
  return {
    fetch: function () {
        return $resource( '/api/profiles/:pid/conferences', { pid: '@pid'});
    },

    status: function () {
        return $resource( '/api/conferences/:cid/attendees/:pid', {cid: '@cid', pid: '@pid'}, {'update': { method: 'PUT' }} );
    },
  }
})

.factory('ProfileAttendsEvents', function ( $resource ){
  return {
    fetch: function () {
        return $resource( '/api/profiles/:pid/events', { pid: '@pid'});
    }
  }
})

.factory('ProfileRooms', function ( $resource ){
  return {
    fetch: function () {
        return $resource( '/api/profiles/:pid/rooms', { pid: '@pid'});
    }
  }
})

.factory('ProfileConferenceVehicles', function ( $resource ){
  return {
    fetch: function () {
        return $resource( '/api/profiles/:pid/conferences/vehicles', { pid: '@pid'});
    }
  }
})

.factory('ProfileEventVehicles', function ( $resource ){
  return {
    fetch: function () {
        return $resource( '/api/profiles/:pid/events/vehicles', { pid: '@pid'});
    }
  }
})

.factory( 'Profile', function ( $resource ) {
    return $resource( '/api/users/:uid/profiles/:pid', { uid: '@uid', pid: '@pid' }, { 'update': { method: 'PUT' } } );
})

.factory( 'Users', function ( $resource ) {
    return $resource( '/api/users/:id', { id: '@id' }, { 'update': { method: 'PUT' } } );
})

.factory( 'Managers', function ( $resource ) {
    return {

        conferences: function () {
            return $resource( '/api/conferences/:cid/managers/:uid', { uid: '@uid', cid: '@cid'} );
        },

        events: function () {
            return $resource( '/api/events/:eid/managers/:uid', {uid: '@uid', eid: '@eid'} );
        }

    }
})

.factory( 'Roles', function ( $resource ) {
    return $resource( '/api/roles/:id', { id: '@id' }, { 'update': { method: 'PUT' } } );
})

.factory( 'Conferences', function( $resource ) {
    return {

        fetch: function () {
            return $resource( '/api/conferences/:cid', {cid: '@cid'}, {'update': { method: 'PUT' }} );
        },

        status: function () {
            return $resource( '/api/conferences/status/:status', {status: '@status'}, {'update': { method: 'PUT' }} );
        },

        events: function () {
            return $resource( '/api/conferences/:cid/events/status/:status', {status: '@status'} );
        },

        attendees: function () {
            return $resource( '/api/conferences/:cid/attendees/:pid', {cid: '@cid', pid: '@pid'}, {'update': { method: 'PUT' }} );
        },

        vehicles: function () {
            return $resource( '/api/conferences/:cid/vehicles/:vid', {cid: '@cid', vid: '@vid'}, {'update': { method: 'PUT' }} );
        },

        inventory: function () {
            return $resource( '/api/conferences/:cid/inventory/:iid', {cid: '@cid', iid: '@iid'}, {'update': { method: 'PUT' }} );
        },

        accommodations: function () {
            return $resource( '/api/conferences/:cid/accommodations/:aid', {cid: '@cid', aid: '@aid'}, {'update': { method: 'PUT' }} );
        },

        rooms: function () {
            return $resource( '/api/accommodations/:aid/rooms/:rid', {aid: '@aid', rid: '@rid'}, {'update': { method: 'PUT' }} );
        },

        passengers: function () {
            return $resource( '/api/conferences/:cid/vehicles/:vid/passengers/:pid', { cid: '@cid', vid: '@vid', pid: '@pid' } );
        }
    }
})

.factory( 'Events', function ( $resource ) {
    return {

        status: function () {
            return $resource( '/api/events/status/:status', {status: '@status'}, {'update': { method: 'PUT' }} );
        },

        fetch: function () {
            return $resource( '/api/conferences/:cid/events/:eid', { cid: '@cid', eid: '@eid' }, { 'update': { method: 'PUT' } } );
        },

        attendees: function () {
            return $resource( '/api/events/:eid/attendees/:pid', { eid: '@eid', pid: '@pid' }, { 'update': { method: 'PUT' } } );
        },

        vehicles: function () {
            return $resource( '/api/events/:eid/vehicles/:vid', { eid: '@eid', vid: '@vid' }, { 'update': { method: 'PUT' } } );
        },

        passengers: function () {
            return $resource( '/api/events/:eid/vehicles/:vid/passengers/:pid', { eid: '@eid', vid: '@vid', pid: '@pid' } );
        }
    }
})

.factory( 'Guests', function ( $resource ) {
    return $resource( '/api/rooms/:rid/guests/:gid', { rid: '@rid', gid: '@gid' } );
})
