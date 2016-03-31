var app = angular.module('signupConfCtrl', []);
app.controller('signupConferenceController', function($scope, $stateParams, Conferences, Countries, Profile, popup, $rootScope, $filter, $state) {

    $scope.calendar = {
        isOpen1: false,
        isOpen2: false,
        isOpen3: false
    };

    $scope.accordionIsOpen = [];

    $scope.countries = Countries;
    $scope.header = "Signup";

    $scope.changeCountry = function(country) {
        $scope.citiesOnly.componentRestrictions = { country: country.code };
        console.log($scope.citiesOnly)
    };

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.emergencyContact = {
        contact_first_name: null,
        contact_last_name: null,
        contact_phone: null,
        contact_email: null
    }

    $scope.conference = {
        conferenceId: $stateParams.conferenceId,
        name: $stateParams.name
    }

    $scope.arrival = {
        arrv_ride_req: false,
        arrv_flight: null,
        arrv_airport: null,
        arrv_date: null,
        arrv_time: null
    }

    $scope.departure = {
        dept_ride_req: false,
        dept_airport: null,
        dept_flight: null,
        dept_date: null,
        dept_time: null
    }

    $scope.familyMembers = [];

    $scope.members = [];

    $scope.loadProfiles = function() {
        Profile.query({ uid: $rootScope.user.id })
            .$promise.then( function ( response ) {
                if ( response ) {
                    var profiles = [];
                    for (var i=0; i < response.length; i++) {
                        var date = response[i].birthdate.split('-');
                        response[i]['profile_id'] = response[i]['id'];
                        delete response[i]['id'];
                        delete response[i]['user_id'];
                        response[i].birthdate = new Date(parseInt(date[0]), parseInt(date[1])-1, parseInt(date[2]));
                        if (response[i]['is_owner']) {
                            delete response[i]['is_owner'];
                            $scope.user = response[i];
                        } else {
                            delete response[i]['is_owner'];
                            profiles.push(response[i]);
                        }
                    }
                    $scope.members = profiles;
                    console.log(profiles);
                } else {
                }
            }, function () {
                popup.connection();
            })
    }
    $scope.loadProfiles();

    $scope.conference = {
        conferenceId: $stateParams.conferenceId,
        name: $stateParams.name
    }

    $scope.accommodations = [];

    $scope.loadAccommodations = function () {
      Conferences.accommodations().query( {cid: $stateParams.conferenceId} )
          .$promise.then( function( response ) {
              if ( response ) {
                  $scope.accommodations = response;
              } else {
                // TODO error
              }
          })
    }

    $scope.loadAccommodations();

    $scope.accommodation = {
        accommodation_req: false,
        accommodation_pref: null
    }

    $scope.signupMember = function (member, $index) {
        if ($scope.familyMembers[$index]) {
            delete $scope.familyMembers[$index];
            $scope.accordionIsOpen[$index] = false;
        } else {
            var newSignup = {
                profile_id: member.id,
                first_name: member.first_name,
                middle_name: member.middle_name,
                last_name: member.last_name,
                birthdate: member.birthdate,
                gender: member.gender,
                arrv_ride_req: false,
                arrv_flight: null,
                arrv_airport: null,
                arrv_date: null,
                arrv_time: null,
                dept_ride_req: false,
                dept_airport: null,
                dept_flight: null,
                dept_date: null,
                dept_time: null,
                accommodation_req: false,
                accommodation_pref: null
            }
            $scope.familyMembers[$index] = newSignup;
            $scope.accordionIsOpen[$index] = true;
        }
    }

    var processMembers = function (family) {
        var result = [];
        for (var i=0; i < family.length; i++) {
            console.log(family[i])
            family[i].birthdate = $filter('date')(family[i].birthdate, 'yyyy-MM-dd');
            family[i].arrv_time = $filter('time')(family[i].arrv_time);
            family[i].arrv_date = $filter('date')(family[i].arrv_date);
            family[i].dept_time = $filter('time')(family[i].dept_time);
            family[i].dept_date = $filter('date')(family[i].dept_date);
            family[i].phone = $scope.user.phone;
            family[i].contact_first_name = $scope.emergencyContact.contact_first_name,
            family[i].contact_last_name = $scope.emergencyContact.contact_last_name,
            family[i].contact_phone = $scope.emergencyContact.contact_phone,
            family[i].contact_email = $scope.emergencyContact.contact_email
            result.push(family[i]);
        }
        return result;
    }

    var signup = function (profile) {
        Conferences.attendees().save({ cid: $scope.conference.conferenceId }, profile)
                .$promise.then(function(response) {
                    if (response.status == 200) {
                        popup.alert('success', 'You have been successfully signed up for approval to attend this conference.');
                        $state.go('conference', { conferenceId: $scope.conference.conferenceId });
                    } else {
                        popup.error('Error', response.message);
                    }
                }, function() {
                    popup.connection();
                });
    }

    $scope.submitRequest = function() {

        if ($scope.profileForm.$valid) {
            var profile = $scope.user;
            profile.birthdate = $filter('date')(profile.birthdate, 'yyyy-MM-dd');
            profile.arrv_date = $filter('date')(profile.arrv_date, 'yyyy-MM-dd');
            profile.dept_date = $filter('date')(profile.dept_date, 'yyyy-MM-dd');
            delete profile['updated_at'];
            angular.extend(profile, $scope.accommodation);
            angular.extend(profile, $scope.arrival);
            angular.extend(profile, $scope.departure);
            angular.extend(profile, $scope.emergencyContact);
            profile.arrv_time = $filter('time')(profile.arrv_time);
            profile.dept_time = $filter('time')(profile.dept_time);
            var members = processMembers($scope.familyMembers);
            for (var i=0; i<members.length; i++) {
                console.log(members[i])
                signup(members[i]);
            }
            signup(profile);
        }
    }

})
