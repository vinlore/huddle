var app = angular.module('signupConfCtrl', []);
app.controller('signupConferenceController', function($scope, $stateParams, Conferences, Countries, Profile, popup, $rootScope, $filter, $state) {

    $scope.calendar = {
        isOpen1: false,
        isOpen2: false,
        isOpen3: false
    };

    $scope.countries = Countries;

    $scope.changeCountry = function(country) {
        $scope.citiesOnly.componentRestrictions = { country: country.code };
        console.log($scope.citiesOnly)
    };

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.user = {
        id: null,
        FirstName: null,
        MiddleName: null,
        LastName: null,
        Birthdate: null,
        Gender: null,
        Country: null,
        City: null,
        Email: null,
        HomePhone: null,
        OtherPhone: null,
        MedicalConditions: null
    };

    $scope.loadProfile = function() {
        Profile.get({ uid: $rootScope.user.id })
            .$promise.then(function(response) {
                if (response) {
                    var profile = response;
                    $scope.user = {
                        id: profile.id,
                        FirstName: profile.first_name,
                        MiddleName: profile.middle_name,
                        LastName: profile.last_name,
                        Birthdate: new Date(profile.birthdate),
                        Gender: profile.gender,
                        Country: profile.country,
                        City: profile.city,
                        Email: profile.email,
                        HomePhone: profile.phone
                    };
                }
            })
    }
    $scope.loadProfile();

    $scope.accommodation = {
        accommRequired: false,
        accomPref: null
    }

    $scope.conference = {
        conferenceId: $stateParams.conferenceId,
        name: $stateParams.name
    }

    $scope.accommodations = [];

    /*$scope.loadAccommodations = function () {
      Conference.accommodations().query( {cid: $stateParams.conferenceId} )
          .$promise.then( function( response ) {
              if ( response.status == 200 ) {
                  $scope.accommodations = response.accommodations;
              } else {
                  // TODO - error
              }
          })
    }*/

    $scope.familymembers = [{
        id: 'member1',
        FirstName: null,
        MiddleName: null,
        LastName: null,
        Age: null,
        Gender: null,
        Country: null,
        City: null
    }]

    $scope.emergencyContact = {
        FirstName: null,
        LastName: null,
        PhoneNumber: null,
        Email: null
    }

    $scope.arrival = {
        RideRequired: false,
        FlightCode: null,
        Airport: null,
        ArrivalDate: null,
        ArrivalTime: null
    }

    $scope.departure = {
        RideRequired: false,
        FlightCode: null,
        Airport: null,
        DepartureDate: null,
        DepartureTime: null
    }

    $scope.accommodations = [];

    /*$scope.loadAccommodations = function () {
      Conference.accommodations().query( {cid: $stateParams.conferenceId} )
          .$promise.then( function( response ) {
              if ( response.status == 'success' ) {
                  $scope.accommodations = response.accommodations;
              } else {
                  // TODO - error
              }
          })
    }*/

    $scope.addFamilyMember = function() {
        var newFamMem = $scope.familymembers.length + 1;
        $scope.familymembers.push({ 'id': 'member' + newFamMem });
    }

    $scope.removeFamilyMember = function(index) {
        $scope.familymembers.splice(index, 1);
    }

    $scope.submitRequest = function() {
        if ($scope.profileForm.$valid) {
            var profile = {
                profile_id: $scope.user.id,
                first_name: $scope.user.FirstName,
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
            }
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
