angular.module ( 'conferenceCtrl', [] )
.controller ( 'conferenceController', function ( $scope, $filter, Conference, Gmap, Events, $routeParams, $resource ) {
    
    $scope.conference = {};

    $scope.loadConference = function () {
        Conference.all().$promise.then(function(result) {
            angular.forEach(result, function(value, key) {
                if (value.conferenceId == $routeParams.conferenceId) {
                    value.startDate = new Date(value.startDate);
                    value.endDate = new Date(value.endDate);
                    $scope.conference = value;
                    console.log($scope.conference);
                    $scope.background = 'assets/img/' + $scope.conference.country + '/big/' + $filter('randomize')(3) + '.jpg';
                }
            });
        });
    }

    $scope.loadConference();

    var conferenceBackup = {};

    $scope.background = {'background-image': 'url(assets/img/overlay.png), url(assets/img/' + $scope.conference.country + '/big/' + $filter('randomize')(3) + '.jpg)'};

    $scope.inventory = [
        {
            name: "Water"
        },
        {
            name: "Toothbrush"
        },
        {
            name: "Towel"
        }
    ]

    $scope.arrivalTransport = [
        {
            vehicleId: 123,
            name: "Bus",
            passengerCount: 30,
            capacity: 40
        }
    ]

    $scope.departureTransport = [
        {
            vehicleId: 323,
            name: "Car",
            passengerCount: 2,
            capacity: 4
        }
    ]

    $scope.accommodations = [
        {
            accommodationsId: 123,
            name: "Some dude's house",
            address: "1234 Fake street",
            rooms: [
                {
                    roomId: 134,
                    room_no: 1,
                    capacity: 4
                },
                {
                    roomId: 135,
                    room_no: 2,
                    capacity: 3
                }
            ]
        }
    ]

    $scope.events = Events.all();

    $scope.calendar = {
        isOpen1: false,
        isOpen2: false
    };

    $scope.isDisabled = true;

    // Makes conference fields editable and creates a 'backup' of the conference data
    $scope.editConference = function () {
        $scope.isDisabled = false;
        angular.extend(conferenceBackup, $scope.conference);
    }

    // Saves any conference changes to server
    $scope.updateConference = function () {
        $scope.isDisabled = true;
    };

    // Restores from conference backup if changes do not want to be saved to server
    $scope.resetConference = function () {
        $scope.conference = conferenceBackup;
        $scope.isDisabled = true;
    }

    $scope.getMap = function( event ) {
        return Gmap( event.address, "400x250", 12, [{color: 'green', label: '.', location: event.address}] );
    }

})