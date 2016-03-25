var app = angular.module('permissionService', []);

app.service('checkPermissions', function ($rootScope) {
    return function (type) {
        var p = $rootScope.user.permissions;
        switch (type) {
            case 'accommodations':
            console.log(p['accommodations.store'])
                return p['accommodations.store'] || p['accommodations.update'] || p['accommodations.destroy'] || p['accommodations.show'];
                break;
            case 'conference_vehicles':
                return p['conference_vehicles.store'] || p['conference_vehicles.update'] || p['conference_vehicles.destroy'] || p['conference_vehicles.show'];
                break;
            case 'conference_attendees':
                return p['conference_attendees.store'] || p['conference_attendees.update'] || p['conference_attendees.destroy'] || p['conference_attendees.show'];
                break;
            case 'item':
                return p['item.store'] || p['item.update'] || p['item.destroy'] || p['item.show'];
                break;
            case 'event_vehicles':
                return p['event_vehicles.store'] || p['event_vehicles.update'] || p['event_vehicles.destroy'] || p['event_vehicles.show'];
                break;
            case 'event_attendees':
                return p['event_attendees.store'] || p['event_attendees.update'] || p['event_attendees.destroy'] || p['event_attendees.show'];
                break;
            default:
                return false; 
        }
    }
})