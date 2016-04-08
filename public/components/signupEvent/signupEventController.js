angular.module('signupEventCtrl', [])
.controller('signupEventController', function($scope, $stateParams, Profile, Events, popup, $state, $rootScope) {

    $scope.header = "Sign Up";

    $scope.familyMembers = [];
    $scope.members = [];
    $scope.accordionIsOpen = [];

    $scope.event = {
        name: $stateParams.name,
        id: $stateParams.eventId,
        conference_id: $stateParams.conferenceId
    }

    $scope.attendee = {
        arrv_ride_req: false,
        dept_ride_req: false,
    }

    var calcAge = function(date) {
        var today = new Date();
        var birthdate = date;
        var age = today.getFullYear() - birthdate.getFullYear();
        var m = today.getMonth() - birthdate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }
        return age;
    }

    var createDate = function(date) {
        if (date) {
            var input = date.split('-');
            return new Date(parseInt(input[0]), parseInt(input[1]) - 1, parseInt(input[2]));
        } else {
            return null;
        }
    }

    $scope.loadProfiles = function() {
        Profile.query({ uid: $rootScope.user.id })
            .$promise.then(function(response) {
                if (response) {
                    var profiles = [];
                    for (var i = 0; i < response.length; i++) {
                        response[i]['profile_id'] = response[i]['id'];
                        delete response[i]['id'];
                        delete response[i]['user_id'];
                        response[i].age = calcAge(createDate(response[i].birthdate));
                        if (response[i]['is_owner']) {
                            delete response[i]['is_owner'];
                            $scope.attendee['profile_id'] = response[i]['profile_id'];
                            console.log($scope.attendee)
                        } else {
                            delete response[i]['is_owner'];
                            profiles.push(response[i]);
                        }
                    }
                    $scope.members = profiles;
                } else {}
            })
    }
    $scope.loadProfiles();

    $scope.signupMember = function(member, $index) {
        if ($scope.familyMembers[$index]) {
            delete $scope.familyMembers[$index];
            $scope.accordionIsOpen[$index] = false;
        } else {
            var newSignup = {
                profile_id: member.profile_id,
                arrv_ride_req: $scope.attendee.arrv_ride_req,
                dept_ride_req: $scope.attendee.dept_ride_req,
                age: member.age
            }
            $scope.familyMembers[$index] = newSignup;
            $scope.accordionIsOpen[$index] = true;
        }
    }

    $scope.loadEvent = function() {
        Events.fetch().get({ cid: $stateParams.conferenceId, eid: $stateParams.eventId })
            .$promise.then(function(response) {
                if (response) {
                    $scope.event = response;

                } else {
                    popup.error('Error', response.message);
                }
            })
    }
    $scope.loadEvent();

    $scope.submitRequest = function() {
        if ($scope.event.age_limit > 0 && $scope.event.age_limit) {
            for (var i = 0; i < $scope.familyMembers.length; i++) {
                if ($scope.familyMembers[i].age >= $scope.event.age_limit) {
                    submitRequestApplication2($scope.familyMembers[i]);
                }
            }
            if ($scope.attendee.age >= $scope.event.age_limit) {
                submitRequestApplication($scope.attendee);
            } else {
                var warningMessage = 'You were unable to signup for ' + $scope.event.name + ' Event. You do not meet the age limit of ' + $scope.event.age_limit + '+.'
                var modalInstance = popup.warning('Event Signup', warningMessage);
                modalInstance.result.then(function(result) {
                    if (result) {
                        $state.go('conference', { conferenceId: $scope.event.conference_id });
                    }
                })
            }
        } else {
            for (var i = 0; i < $scope.familyMembers.length; i++) {
                submitRequestApplication2($scope.familyMembers[i]);
            }
            submitRequestApplication($scope.attendee);
        }
    };

    var submitRequestApplication = function(profile) {
        delete profile.age;
        Events.attendees().save({ eid: $scope.event.id }, profile)
            .$promise.then(function(response) {
                if (response.status == 200) {
                    popup.alert('success', 'You have been successfully signed up for approval to attend this event.');
                    $state.go('conference', { conferenceId: $scope.event.conference_id });
                } else {
                    popup.error('Error', response.message);
                }
            });
    };

    var submitRequestApplication2 = function(profile) {
        delete profile.age;
        Events.attendees().save({ eid: $scope.event.id }, profile)
            .$promise.then(function(response) {
                if (response.status == 200) {
                    popup.alert('success', 'An associated member been successfully signed up for approval to attend this event.');
                } else {
                    popup.error('Error', response.message);
                }
            });
    };
})
