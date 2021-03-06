angular.module('manageConferenceTransportationCtrl', [])
.controller('manageConferenceTransportationController', function($scope, ngTableParams, Conferences, $stateParams, popup) {

    // Conference ID
    $scope.conferenceId = $stateParams.conferenceId;

    // Initial data array for holding arrival/departure response jsons
    $scope.data = [];

    // Initial input data array
    $scope.vehicle = {
        name: null,
        capacity: null
    }

    //////// Load Data ////////

    $scope.loadVehicles = function() {

        // Load arrival vehicles
        Conferences.vehicles().query({ cid: $scope.conferenceId, type: 'arrival' })
            .$promise.then(function(response) {
                if (response) {
                    for (var i = 0; i < response.length; i++) {
                        response[i].attendees = Conferences.passengers().query({ cid: $scope.conferenceId, vid: response[i].id });
                    }
                    $scope.data[0] = response;
                } else {
                    popup.error('Error', response.message);
                }
            })

        // Load departure vehicles
        Conferences.vehicles().query({ cid: $scope.conferenceId, type: 'departure' })
            .$promise.then(function(response) {
                if (response) {
                    for (var i = 0; i < response.length; i++) {
                        response[i].attendees = Conferences.passengers().query({ cid: $scope.conferenceId, vid: response[i].id });
                    }
                    $scope.data[1] = response;
                } else {
                    popup.error('Error', response.message);
                }
            })
    }

    $scope.loadConferenceData = function() {
        Conferences.fetch().get({ cid: $stateParams.conferenceId })
            .$promise.then(function(response) {
                if (response) {
                    $scope.conference = response;
                } else {
                    popup.error('Error', response.message);
                }
            })
    };

    $scope.loadVehicles();
    $scope.loadConferenceData();
    console.log($scope.data);

    //////// Button Functions ////////

    $scope.add = function(vehicle, index) {

        var type;

        if (index == 0) {
            type = 'arrival';
        } else {
            type = 'departure';
        }

        vehicle.passenger_count = 0;

        Conferences.vehicles().save({ cid: $scope.conferenceId, type: type }, vehicle)
            .$promise.then(function(response) {
                if (response.status == 200) {
                    console.log(vehicle);
                    console.log('Changes saved to vehicles, profile_rides_vehicles, conference_vehicles');
                    popup.alert('success', 'Changes have been saved.');

                    // clear input data
                    $scope.vehicle.name = null;
                    $scope.vehicle.capacity = null;
                } else {
                    popup.error('Error', response.message);
                }
            })

        $scope.loadVehicles();
    }

    $scope.del = function(vehicle, parent, index, event) {

        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        console.log(parent);
        console.log(index);
        var modalInstance = popup.prompt('Delete', 'Are you sure you want to delete?');

        modalInstance.result.then(function(result) {
            if (result) {
                if (vehicle.passenger_count > 0) {
                    popup.error('Error', 'Cannot delete vehicles with passengers.');
                } else {
                    Conferences.vehicles().delete({ cid: $scope.conferenceId, vid: vehicle.id })
                        .$promise.then(function(response) {
                            if (response.status == 200) {
                                console.log('Vehicle has been successfully deleted');
                                popup.alert('success', 'Vehicle has been successfully deleted.');
                            } else {
                                popup.error('Error', response.message);
                            }
                        })

                    $scope.loadVehicles();
                }
            }
        })
    }

    $scope.export = function() {}

    $scope.removeAttendee = function(vid, pid) {
        Conferences.passengers().delete({ cid: $scope.conferenceId, vid: vid, pid: pid })
            .$promise.then(function(response) {
                if (response.status = 200) {
                    popup.alert('success', 'User no longer taking this vehicle');
                    $scope.loadVehicles();
                } else {
                    popup.error('Error', response.message);
                }
            })
    }

})
