angular.module ( 'conferenceCtrl', [] )
.controller ( 'conferenceController', function ( $scope, Conference, Gmap, Events ) {
    
    $scope.conference = {
        "conferenceId": 123,
        "name": "India Conference",
        "country": "India",
        "description": "Description",
        "city": "New Delhi",
        "startDate": new Date("Feb 13, 2016"),
        "endDate": new Date("Feb 20, 2016"),
        "arrivalTransport": true,
        "departTransport": false,
        "address": "District Centre, Saket, New Delhi, Delhi 110017, India",
        "inventoryId": 123,
        "accommodationId": 123
    };

    $scope.events = Events.all();

    $scope.calendar = {
        isOpen1: false,
        isOpen2: false
    };

    $scope.isDisabled = true;

    // Saves any conference changes to server
    $scope.updateConference = function () {
        $scope.isDisabled = true;
    }

    $scope.getMap = function( event ) {
        return Gmap( event.address, "400x250", 12, [{color: 'green', label: '.', location: event.address}] );
    }

})