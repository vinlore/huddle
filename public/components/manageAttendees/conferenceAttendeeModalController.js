angular.module('conferenceAttendeeModalCtrl', [])
.controller('conferenceAttendeeModalController', function ($scope, $uibModalInstance, Conferences, preferences, conferenceId) {
    
    $scope.preference = preferences;
    $scope.user = {
        arrivalVehicle: null,
        departureVehicle: null,
        room: null
    }
    $scope.accommodations, $scope.arrivalVehicles, $scope.departVehicles, $scope.rooms = [];

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
                    $scope.arrivalVehicles = response;
                } else {
                }
            })
    }

    $scope.loadArrivalVehicles();

    $scope.loadDepartVehicles = function () {
        Conferences.vehicles().query( {cid: conferenceId, type: 'departure'} )
            .$promise.then( function( response ) {
                if ( response ) {
                    $scope.departVehicles = response;
                } else {
                }
            })
    }

    $scope.loadDepartVehicles();

    $scope.getRooms = function (id) {
        Conferences.rooms().query({aid: id})
            .$promise.then( function (response) {
                if (response) {
                    $scope.rooms = response;
                } else {
                    $scope.rooms = null;
                }
            })
    }

    $scope.getRooms($scope.preference.accommodation_pref);

    $scope.approve = function () {
        if ($scope.attendeeForm.$valid) {
            $uibModalInstance.close($scope.user);
        }
    }

    $scope.close = function () {
        $uibModalInstance.close(false);
    }

})