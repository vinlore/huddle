var app = angular.module('permissionService', []);

app.service('checkPermissions', function ($rootScope) {
    return function (type, thing, id) {
        if (!$rootScope.user || !$rootScope.user.permissions) return false;
        var p = $rootScope.user.permissions;
        var id = parseInt(id);
        var isManager = false;
        if (thing == 'conference') {
            isManager = parseInt($rootScope.user.conferences.indexOf(id)) >= 0;
        } else if (thing == 'event') {
            isManager = parseInt($rootScope.user.events.indexOf(id)) >= 0;
        } else if (thing == 'profile') {
            isManager = $rootScope.user.profile_id == id;
        } else {
            isManager = false;
        }
        switch (type) {
            case 'accommodation':
                var permissions = p['accommodation.show'] || p['accommodation.store'] || p['accommodation.update'] || p['accommodation.destroy'] || p['accommodation.show'];
                return permissions && isManager;
                break;
            case 'conference_vehicle':
                var permissions = p['conference_vehicle.show'] || p['conference_vehicle.store'] || p['conference_vehicle.update'] || p['conference_vehicle.destroy'] || p['conference_vehicle.show'];
                return permissions && isManager;
                break;
            case 'conference_attendee':
                var permissions = p['conference_attendee.show'] || p['conference_attendee.update'] || p['conference_attendee.destroy'] || p['conference_attendee.show'];
                return permissions && isManager;
                break;
            case 'item':
                var permissions = p['item.show'] || p['item.store'] || p['item.update'] || p['item.destroy'] || p['item.show'];
                return permissions && isManager;
                break;
            case 'room':
                var permissions = p['room.show'] || p['room.store'] || p['room.update'] || p['room.destroy'] || p['room.show'];
                return permissions && isManager;
                break;
            case 'event_vehicle':
                var permissions = p['event_vehicle.show'] || p['event_vehicle.store'] || p['event_vehicle.update'] || p['event_vehicle.destroy'] || p['event_vehicle.show'];
                return permissions && isManager;
                break;
            case 'event_attendee':
                var permissions = p['event_attendee.show'] || p['event_attendee.update'] || p['event_attendee.destroy'] || p['event_attendee.show'];
                return permissions && isManager;
                break;
            case 'admin':
                var permissions = /*p['event_attendee.show'] || p['event_attendee.update'] || p['event_attendee.destroy'] || p['event_attendee.show'] ||*/ p['event_vehicle.show'] || p['event_vehicle.store'] || p['event_vehicle.update'] || p['event_vehicle.destroy'] || p['event_vehicle.show'] || /*p['conference_attendee.show'] || p['conference_attendee.update'] || p['conference_attendee.destroy'] || p['conference_attendee.show'] ||*/ p['conference_vehicle.show'] || p['conference_vehicle.store'] || p['conference_vehicle.update'] || p['conference_vehicle.destroy'] || p['conference_vehicle.show'] || p['accommodation.show'] || p['accommodation.store'] || p['accommodation.update'] || p['accommodation.destroy'] || p['accommodation.show'] || p['item.show'] || p['item.store'] || p['item.update'] || p['item.destroy'] || p['item.show'] || p['conference.store'] || p['conference.delete'] || p['event.store'] || p['event.destroy'];
                return permissions;
                break;
            case 'publisher':
                var permissions = p['event.update'] || p['conference.update'];
                return permissions;
                break;
            case 'accounts':
                var permissions = p['user.update'] || p['user.show'] || p['user.destroy'] || p['role.store'] || p['role.update'] || p['role.destroy'] || p['role.show'];
                return permissions;
                break;
            case 'user':
                var permissions = p['user.update'] || p['user.show'] || p['user.destroy']
                return permissions;
                break;
            case 'conference':
                var permissions = p['conference.store'] || p['conference.update'] || p['conference.destroy']
                return permissions;
                break;
            case 'event':
                var permissions = p['event.store'] || p['event.update'] || p['event.destroy']
                return permissions;
                break;
            default:
                return isManager; 
        }
    }
})

app.service('checkPermission', function ($rootScope) {
    return function (permission, thing, id) {
        if (!$rootScope.user || !$rootScope.user.permissions) return false;
        var id = parseInt(id);
        var p = $rootScope.user.permissions;
        var isManager = false;
        if (thing == 'conference') {
            isManager = parseInt($rootScope.user.conferences.indexOf(id)) >= 0;
        } else if (thing == 'event') {
            isManager = parseInt($rootScope.user.events.indexOf(id)) >= 0;
        } else {
            isManager = false;
        }
        return isManager && $rootScope.user.permissions[permission];
    }
})

app.service('isAdmin', function ($rootScope) {
    return function () {
        if (!$rootScope.user || !$rootScope.user.permissions) return false;
        var p = $rootScope.user.permissions;
        return p['conference.store'] && p['conference.update'] && p['conference.destroy'] && p['role.show'] && p['role.store'] && p['role.update'] && p['role.destroy'] && p['event.store'] && p['event.update'] && p['event.destroy'] && p['conference_attendee.show'] && p['conference_attendee.update'] && p['conference_attendee.destroy'] && p['event_attendee.show'] && p['event_attendee.update'] && p['event_attendee.destroy'] && p['item.store'] && p['item.show'] && p['item.update'] && p['item.destroy'] && p['conference_vehicle.store'] && p['conference_vehicle.show'] && p['conference_vehicle.update'] && p['conference_vehicle.destroy'] && p['event_vehicle.store'] && p['event_vehicle.show'] && p['event_vehicle.update'] && p['event_vehicle.destroy'] && p['accommodation.store'] && p['accommodation.show'] && p['accommodation.update'] && p['accommodation.destroy'] && p['room.show'] && p['room.store'] && p['room.update'] && p['room.destroy'] && p['user.show'] && p['user.update'] && p['user.destroy'];
    }
})