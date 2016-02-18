angular.module ( 'conferenceCtrl', [] )
.controller ( 'conferenceController', function ( $scope, Conference, Gmap ) {
    
    $scope.conference = {
        "conferenceId": 123,
        "name": "India Conference",
        "country": "India",
        "description": "Description",
        "city": "New Delhi",
        "startDate": "Feb 13, 2016",
        "endDate": "Feb 20, 2016",
        "arrivalTransport": true,
        "departTransport": false,
        "address": "District Centre, Saket, New Delhi, Delhi 110017, India",
        "inventoryId": 123,
        "accommodationId": 123
    };

})