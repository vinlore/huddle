angular.module('conferenceAttendeeModalCtrl', [])
.controller('conferenceAttendeeModalController', function ($scope, $uibModalInstance, Conferences, preferences, conferenceId) {
    
    $scope.preference = preferences;
    $scope.user = {
        arrivalVehicle: null,
        departureVehicle: null,
        room: null
    }
    $scope.accommodations = []; $scope.arrivalVehicles = []; $scope.departVehicles = []; $scope.rooms = [];

    $scope.loadAccommodations = function () {
        Conferences.accommodations().query( {cid: conferenceId} )
            .$promise.then( function( response ) {
                if ( response ) {
                    $scope.accommodations = response;
                } else {
                }
            })
    }

    $scope.loadAccommodations();

    $scope.loadArrivalVehicles = function () {
        Conferences.vehicles().query( {cid: conferenceId, type: 'arrival'} )
            .$promise.then( function( response ) {
                if ( response ) {
                    for (var i=0; i<response.length; i++) {
                        console.log(response[i])
                        if (response[i].passenger_count < response[i].capacity) {
                            $scope.arrivalVehicles.push(response[i]);
                        }
                    }
                } else {
                }
            })
    }

    $scope.loadArrivalVehicles();

    $scope.loadDepartVehicles = function () {
        Conferences.vehicles().query( {cid: conferenceId, type: 'departure'} )
            .$promise.then( function( response ) {
                if ( response ) {
                    for (var i=0; i<response.length; i++) {
                        if (response[i].passenger_count < response[i].capacity) {
                            $scope.departVehicles.push(response[i]);
                        }
                    }
                } else {
                }
            })
    }

    $scope.loadDepartVehicles();

    $scope.getRooms = function (id) {
        Conferences.rooms().query({aid: id})
            .$promise.then( function (response) {
                if (response) {
                    for (var i=0; i<response.length; i++) {
                        if (response[i].guest_count < response[i].capacity) {
                            $scope.rooms.push(response[i]);
                        }
                    }
                } else {
                    $scope.rooms = null;
                }
            })
    }

    $scope.getRooms($scope.preference.accommodation_pref);

    $scope.approve = function () {
        $uibModalInstance.close($scope.user);
    }

    $scope.close = function () {
        $uibModalInstance.close(false);
    }

})