angular.module('eventAttendeeModalCtrl', [])
.controller('eventAttendeeModalController', function ($scope, $uibModalInstance, Events, preferences, eventId) {
    
    $scope.preference = preferences;
    $scope.user = {
        arrivalVehicle: null,
        departureVehicle: null,
        room: null
    }

    $scope.arrivalVehicles, $scope.departVehicles = [];

    $scope.loadArrivalVehicles = function () {
        Events.vehicles().query( {eid: eventId, type: 'arrival'} )
            .$promise.then( function( response ) {
                if ( response ) {
                    $scope.arrivalVehicles = response;
                } else {
                }
            })
    }

    $scope.loadArrivalVehicles();

    $scope.loadDepartVehicles = function () {
        Events.vehicles().query( {eid: eventId, type: 'departure'} )
            .$promise.then( function( response ) {
                if ( response ) {
                    $scope.departVehicles = response;
                } else {
                }
            })
    }

    $scope.loadDepartVehicles();

    $scope.approve = function () {
        if ($scope.attendeeForm.$valid) {
            $uibModalInstance.close($scope.user);
        }
    }

    $scope.close = function () {
        $uibModalInstance.close(false);
    }

})