angular.module('eventAttendeeModalCtrl', [])
.controller('eventAttendeeModalController', function ($scope, $uibModalInstance, Events, preferences, eventId) {
    
    $scope.preference = preferences;
    $scope.user = {
        arrivalVehicle: null,
        departureVehicle: null,
        room: null
    }

    $scope.arrivalVehicles = []; $scope.departVehicles = [];

    $scope.loadArrivalVehicles = function () {
        Events.vehicles().query( {eid: eventId, type: 'arrival'} )
            .$promise.then( function( response ) {
                if ( response ) {
                    for (var i=0; i<response.length; i++) {
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
        Events.vehicles().query( {eid: eventId, type: 'departure'} )
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

    $scope.approve = function () {
        $uibModalInstance.close($scope.user);
    }

    $scope.close = function () {
        $uibModalInstance.close(false);
    }

})