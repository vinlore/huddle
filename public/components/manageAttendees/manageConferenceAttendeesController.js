angular.module('manageConferenceAttendeesCtrl', [])
.controller('manageConferenceAttendeesController', function($scope, ngTableParams, $stateParams, $filter, Conferences, popup, $uibModal, Passengers, Guests) {

    // Conference ID
    $scope.conferenceId = $stateParams.conferenceId;

    $scope.radioModel = '';

    console.log($scope.radioModel);

    //////// Load Data //////// 

    $scope.load = function() {
        $scope.tableParams = new ngTableParams(
        {
            filter: {
                'pivot.status' : $scope.radioModel
            }
        }, {
            counts: [],
            getData: function($defer, params) {

                // organize filter as $filter understand it (graph object)
                var filters = {};
                angular.forEach(params.filter(), function(val, key) {
                    var filter = filters;
                    var parts = key.split('.');
                    for (var i = 0; i < parts.length; i++) {
                        if (i != parts.length - 1) {
                            filter[parts[i]] = {};
                            filter = filter[parts[i]];
                        } else {
                            filter[parts[i]] = val;
                        }
                    }
                })

                Conferences.attendees().query({ cid: $scope.conferenceId })
                    .$promise.then(function(response) {
                        if (response) {
                            $scope.data = response;

                            console.log(JSON.stringify(params.filter()));

                            // filter with $filter (don't forget to inject it)
                            var filteredDatas =
                                params.filter() ?
                                $filter('filter')($scope.data, filters) :
                                $scope.data;

                            // ordering
                            var sorting = params.sorting();
                            var key = sorting ? Object.keys(sorting)[0] : null;
                            var orderedDatas = sorting ? $filter('orderBy')(filteredDatas, key, sorting[key] == 'desc') : filteredDatas;

                            $defer.resolve(orderedDatas);
                        } else {}
                    }, function() {
                        popup.connection();
                    })

            }
        });
    }

    $scope.load();

    //////// Button Functions ////////

    var attend = function(id) {
        Conferences.attendees().update({ cid: $scope.conferenceId, pid: id }, { status: 'approved' })
            .$promise.then(function(response) {
                if (response.status == 200) {
                    console.log('Changes saved to profile_attends_conferences (approve)');
                    popup.alert('success', 'User has been approved.');
                } else {
                    popup.error('Error', response.message);
                }
            }, function() {
                popup.connection();
            })
    }

    $scope.approve = function(attendee) {
        if (attendee.pivot.arrv_ride_req || attendee.pivot.dept_ride_req || attendee.pivot.accommodation_req) {
            var modalInstance = $uibModal.open({
                animation: false,
                templateUrl: 'components/manageAttendees/conferenceAttendeeModal.html',
                controller: 'conferenceAttendeeModalController',
                size: 'lg',
                resolve: {
                    conferenceId: function() {
                        return $stateParams.conferenceId;
                    },
                    preferences: function() {
                        return {
                            arrv_ride_req: attendee.pivot.arrv_ride_req,
                            dept_ride_req: attendee.pivot.dept_ride_req,
                            accommodation_req: attendee.pivot.accommodation_req,
                            accommodation_pref: attendee.pivot.accommodation_pref
                        }
                    }
                }
            })

            modalInstance.result.then(function(result) {
                if (result) {
                    console.log(result);
                    // TODO store to profile rides and profile stays table
                    if (result.arrivalVehicle) {
                        Passengers.save({ vid: result.arrivalVehicle }, { profile_id: attendee.id })
                            .$promise.then(function(response) {
                                if (response.status != 200) {
                                    popup.error('Error', response.message);
                                    return false;
                                }
                            })
                    }
                    if (result.departureVehicle) {
                        Passengers.save({ vid: result.departureVehicle }, { profile_id: attendee.id })
                            .$promise.then(function(response) {
                                if (response.status != 200) {
                                    popup.error('Error', response.message);
                                    return false;
                                }
                            })
                    }
                    if (result.room) {
                        Guests.save({ rid: result.room }, { profile_id: attendee.id })
                            .$promise.then(function(response) {
                                if (response.status != 200) {
                                    popup.error('Error', response.message);
                                    return false;
                                }
                            })
                    }
                    attend(attendee.id);
                }
            })
        } else {
            attend(attendee.id);
        }
        $scope.tableParams.reload();
    }

    $scope.deny = function(id) {

        Conferences.attendees().update({ cid: $scope.conferenceId, pid: id }, { status: 'denied' })
            .$promise.then(function(response) {
                if (response.status == 200) {
                    console.log('Changes saved to profile_attends_conferences (deny)');
                    popup.alert('success', 'User has been denied.');
                } else {
                    popup.error('Error', response.message);
                }
            }, function() {
                popup.connection();
            })

        $scope.tableParams.reload();
    }

});
