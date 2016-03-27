var app = angular.module('permissionService', []);

app.service('checkPermissions', function ($rootScope) {
    return function (type) {
        if (!$rootScope.user) return false;
        var p = $rootScope.user.permissions;
        switch (type) {
            case 'accommodation':
                return p['accommodation.show'] || p['accommodation.store'] || p['accommodation.update'] || p['accommodation.destroy'] || p['accommodation.show'];
                break;
            case 'conference_vehicle':
                return p['conference_vehicle.show'] || p['conference_vehicle.store'] || p['conference_vehicle.update'] || p['conference_vehicle.destroy'] || p['conference_vehicle.show'];
                break;
            case 'conference_attendee':
                return p['conference_attendee.show'] || p['conference_attendee.store'] || p['conference_attendee.update'] || p['conference_attendee.destroy'] || p['conference_attendee.show'];
                break;
            case 'item':
                return p['item.show'] || p['item.store'] || p['item.update'] || p['item.destroy'] || p['item.show'];
                break;
            case 'event_vehicle':
                return p['event_vehicle.show'] || p['event_vehicle.store'] || p['event_vehicle.update'] || p['event_vehicle.destroy'] || p['event_vehicle.show'];
                break;
            case 'event_attendee':
                return p['event_attendee.show'] || p['event_attendee.store'] || p['event_attendee.update'] || p['event_attendee.destroy'] || p['event_attendee.show'];
                break;
            default:
                return false; 
        }
    }
})