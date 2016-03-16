angular.module( 'conferenceCtrl', [] )
.controller( 'conferenceController', function( $scope, $filter, Conference, Gmap, Events, $routeParams, $resource, popup ) {

    $scope.conference = {};

    $scope.loadConference = function () {
        Conference.all()
            .$promise.then( function( result ) {
                angular.forEach( result, function( value, key ) {
                    if ( value.conferenceId == $routeParams.conferenceId ) {
                        value.startDate = new Date( value.startDate );
                        value.endDate = new Date( value.endDate );
                        $scope.conference = value;
                        console.log( $scope.conference );
                        $scope.background = 'assets/img/' + $scope.conference.country + '/big/' + $filter( 'randomize' )( 3 ) + '.jpg';
                    }
                } );
            } );
        /*Conference.fetch().get( {cid: $routeParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response.status == 'success' && response.conference ) {
                    var conf = response.conference;
                    conf.startDate = new Date( conf.start_date );
                    conf.endDate = new Date( conf.end_date );
                    $scope.conference = conf;
                    $scope.background = 'assets/img/' + $scope.conference.country + '/big/' + $filter( 'randomize' )( 3 ) + '.jpg';
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            } )*/
    }

    $scope.loadConference();

    var conferenceBackup = {};

    $scope.background = { 'background-image': 'url(assets/img/overlay.png), url(assets/img/' + $scope.conference.country + '/big/' + $filter( 'randomize' )( 3 ) + '.jpg)' };

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
    $scope.editConference = function() {
        $scope.isDisabled = false;
        angular.extend( conferenceBackup, $scope.conference );
    }

    // Saves any conference changes to server
    $scope.updateConference = function() {
        $scope.isDisabled = true;
    };

    // Restores from conference backup if changes do not want to be saved to server
    $scope.resetConference = function() {
        $scope.conference = conferenceBackup;
        $scope.isDisabled = true;
    }

    $scope.getMap = function( event ) {
        return Gmap( event.address, "400x250", 12, [ { color: 'green', label: '.', location: event.address } ] );
    }

    /*
    $scope.loadEvents = function () {
        Event.fetch().query( {cid: $routeParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response.status == 'success' && response.events ) {
                    $scope.events = response.events;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadEvents();

    $scope.loadInventory = function () {
        Conference.inventory().get( {cid: $routeParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response.status == 'success' && response.inventory ) {
                    $scope.inventory = response.inventory;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadInventory();

    $scope.loadAccommodations = function () {
        Conference.accommodations().get( {cid: $routeParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response.status == 'success' && response.accommodations ) {
                    $scope.accommodations = response.accommodations;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadAccommodations();

    $scope.loadArrivalVehicles = function () {
        Conference.vehicles().get( {cid: $routeParams.conferenceId, type: 'arrival'} )
            .$promise.then( function( response ) {
                if ( response.status == 'success' && response.vehicles ) {
                    $scope.arrivalVehicles = response.vehicles;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadArrivalVehicles();

    $scope.loadDepartVehicles = function () {
        Conference.vehicles().get( {cid: $routeParams.conferenceId, type: 'departure'} )
            .$promise.then( function( response ) {
                if ( response.status == 'success' && response.vehicles ) {
                    console.log( 'Retrieved departure vehicles' ); console.log( response.vehicles );
                    $scope.departVehicles = response.vehicles;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.loadDepartVehicles();*/

    $scope.saveDetails = function () {
        var confDetails = {
            name: $scope.conference.name,
            start_date: $filter('date')($scope.conference.startDate, 'yyyy-MM-dd'),
            end_date: $filter('date')($scope.conference.endDate, 'yyyy-MM-dd'),
            address: $scope.conference.address,
            description: $scope.conference.description,
            capacity: $scope.conference.capacity,
            city: $scope.conference.city,
            country: $scope.conference.country
        }
        Conference.fetch().update( {cid: $routeParams.conferenceId}, confDetails )
            .$promise.then( function( response ) {
                if ( response.status == 'success' ) {
                    console.log( 'Changes saved to conference' );
                    // TODO success alert
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.dataset1 = {
        "chart": {
            "caption": "Countries Represented by Attendees",
            "subCaption": "2016",
            "showBorder": "0",
            "use3DLighting": "0",
            "enableSmartLabels": "1",
            "startingAngle": "30",
            "showLabels": "1",
            "showPercentValues": "1",
            "showLegend": "1",
            "defaultCenterLabel": "",
            "centerLabel": "1",
            "centerLabelBold": "1",
            "showTooltip": "1",
            "decimals": "0",
            "useDataPlotColorForLabels": "1",
            "theme": "fint",
            "enableMultiSlicing": "1",
            "radius3D": "4"
        },
        "data": [
            {
                "label": "Canada",
                "value": "500"
        },
            {
                "label": "India",
                "value": "1500"
        },
            {
                "label": "USA",
                "value": "275"
        },
            {
                "label": "Germany",
                "value": "120"
        }
    ]
    }

    $scope.dataset2 = {
        "chart": {
            "caption": "Gender Representation",
            "subCaption": "2016",
            "showBorder": "0",
            "use3DLighting": "0",
            "enableSmartLabels": "1",
            "startingAngle": "30",
            "showLabels": "1",
            "showPercentValues": "1",
            "showLegend": "1",
            "defaultCenterLabel": "",
            "centerLabel": "1",
            "centerLabelBold": "1",
            "showTooltip": "1",
            "decimals": "0",
            "useDataPlotColorForLabels": "1",
            "theme": "fint",
            "enableMultiSlicing": "1",
            "radius3D": "5"
        },
        "data": [
            {
                "label": "Males",
                "value": "820"
            },
            {
                "label": "Females",
                "value": "1300"
            },
            {
                "label": "Other",
                "value": "275"
            },
        ]
    }

})
