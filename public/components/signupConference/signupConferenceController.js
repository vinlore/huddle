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
        first_name: null,
        last_name: null,
        phone: null,
        email: null
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
                id: member.id,
                first_name: member.first_name,
                middle_name: member.middle_name,
                last_name: member.last_name,
                birthdate: member.birthdate,
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
            angular.extend(newSignup, $scope.emergencyContact);
            $scope.familyMembers[$index] = newSignup;
            $scope.accordionIsOpen[$index] = true;
        }
    }

    var processFamily = function (family) {
        var result = [];
        for (var i=0; i < family.length; i++) {
            if (family[i].FirstName, family[i].LastName, family[i].Gender, family[i].Birthdate) {
                var profile = {
                    profile_id: family[i].id,
                    first_name: family[i].FirstName,
                    last_name: family[i].LastName,
                    birthdate: $filter('date')(family[i].Birthdate, 'yyyy-MM-dd'),
                    gender: family[i].Gender,
                    country: $scope.user.Country,
                    city: $scope.user.city,
                    email: family[i].email,
                    phone: $scope.user.HomePhone,
                    phone2: $scope.user.OtherPhone,
                    contact_first_name: $scope.emergencyContact.FirstName,
                    contact_last_name: $scope.emergencyContact.LastName,
                    contact_email: $scope.emergencyContact.Email,
                    contact_phone: $scope.emergencyContact.PhoneNumber,
                    /* TODO separate arrival departure info */
                    arrv_time: $scope.arrival.ArrivalTime,
                    arrv_date: $scope.arrival.ArrivalDate,
                    arrv_airport: $scope.arrival.Airport,
                    arrv_ride_req: $scope.arrival.RideRequired,
                    dept_ride_req: $scope.departure.RideRequired,
                    dept_airport: $scope.departure.Airport,
                    dept_time: $scope.departure.DepartureTime,
                    dept_date: $scope.departure.DepartureDate,
                    accommodation_req: $scope.accommodation.accommRequired,
                    accommodation_pref: $scope.accommodation.accomPref
                }
                result.push(profile);
            }
        }
        return result;
    }

    $scope.submitRequest = function() {

        if ($scope.profileForm.$valid) {
            /*var profile = {
                profile_id: $scope.user.id,
                first_name: $scope.user.FirstName,
                middle_name: $scope.user.MiddleName,
                last_name: $scope.user.LastName,
                birthdate: $filter('date')($scope.user.Birthdate, 'yyyy-MM-dd'),
                gender: $scope.user.Gender,
                country: $scope.user.Country,
                city: $scope.user.city,
                email: $scope.user.email,
                phone: $scope.user.HomePhone,
                phone2: $scope.user.OtherPhone,
                contact_first_name: $scope.emergencyContact.FirstName,
                contact_last_name: $scope.emergencyContact.LastName,
                contact_email: $scope.emergencyContact.Email,
                contact_phone: $scope.emergencyContact.PhoneNumber,
                arrv_time: $scope.arrival.ArrivalTime,
                arrv_date: $scope.arrival.ArrivalDate,
                arrv_airport: $scope.arrival.Airport,
                arrv_ride_req: $scope.arrival.RideRequired,
                dept_ride_req: $scope.departure.RideRequired,
                dept_airport: $scope.departure.Airport,
                dept_time: $scope.departure.DepartureTime,
                dept_date: $scope.departure.DepartureDate,
                accommodation_req: $scope.accommodation.accommRequired,
                medical_conditions: $scope.user.MedicalConditions,
                accommodation_pref: $scope.accommodation.accomPref
            };*/
            var profile = $scope.user;
            profile.birthdate = $filter('date')(profile.birthdate, 'yyyy-MM-dd');
            angular.extend(profile, $scope.accommodation);
            angular.extend(profile, $scope.arrival);
            angular.extend(profile, $scope.departure);
            angular.extend(profile, $scope.emergencyContact);
            //var family = processFamily($scope.familymembers);
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
    }

})
