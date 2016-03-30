var app = angular.module('attendeeConfCtrl', []);
app.controller('attendeeConferenceController', function($scope, $stateParams, Conferences, Countries, Profile, popup, $rootScope, $filter, $state) {

  $scope.calendar = {
    isOpen1: false,
    isOpen2: false,
    isOpen3: false
  };

  $scope.accordionIsOpen = [];
  $scope.countries = Countries;
  $scope.header = "Application";

  $scope.conference = {
    conference_id: $stateParams.conference_id,
    name: $stateParams.conference_name
  }
  $scope.user = {}

  $scope.changeCountry = function(country) {
    $scope.citiesOnly.componentRestrictions = { country: country.code };
    console.log($scope.citiesOnly)
  };

  $scope.citiesOnly = {
    types: ['(cities)']
  };

  $scope.emergencyContact = {
    first_name: $scope.user.contact_first_name,
    last_name: $scope.user.contact_last_name,
    phone: $scope.user.contact_phone,
    email: $scope.user.email
  }

  $scope.arrival = {
    arrv_ride_req: $scope.user.arrv_ride_req,
    arrv_flight: $scope.user.arrv_flight,
    arrv_airport: $scope.user.arrv_airport,
    arrv_date: $scope.user.arrv_date,
    arrv_time: $scope.user.arrv_time
  }

  $scope.departure = {
    dept_ride_req: $scope.user.dept_ride_req,
    dept_flight: $scope.user.dept_flight,
    dept_airport: $scope.user.dept_airport,
    dept_date: $scope.user.dept_date,
    dept_time: $scope.user.dept_time
  }

  $scope.loadAttendeeProfile = function() {
    Conferences.attendees().get({cid: $stateParams.conference_id, pid: $stateParams.profile_id})
    .$promise.then(function(response){
      if(response){
        var profile = response.pivot;
        $scope.user = profile;
        console.log(response);
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })
  };
  $scope.loadAttendeeProfile();

  $scope.accommodation = {
    accommodation_pref: $scope.user.accommodation_pref,
    accommodation_req: $scope.user.accommodation_req
  }

  $scope.accommodations = [];
  $scope.loadAccommodations = function () {
    Conferences.accommodations().query( {cid: $stateParams.conference_id} )
    .$promise.then( function( response ) {
      if ( response ) {
        $scope.accommodations = response;
      } else {
        // TODO error
      }
    })
  }

  $scope.loadAccommodations();

  $scope.submitRequest = function(){
    var profile = {
      profile_id: $scope.user.profile_id,
      first_name: $scope.user.first_name,
      last_name: $scope.user.last_name,
      birthdate: $filter('date')($scope.user.birthdate, 'yyyy-MM-dd'),
      gender: $scope.user.gender,
      country: $scope.user.country,
      city: $scope.user.city,
      email: $scope.user.email,
      phone: $scope.user.phone,
      phone2: $scope.user.phone2,
      medical_conditions: $scope.user.medical_conditions,
      contact_first_name: $scope.emergencyContact.first_name,
      contact_last_name: $scope.emergencyContact.last_name,
      contact_email: $scope.emergencyContact.email,
      contact_phone: $scope.emergencyContact.phone,
      arrv_time: $filter('time')($scope.arrival.dept_time),
      arrv_date: $filter('date')($scope.arrival.arrv_date, 'yyyy-MM-dd'),
      arrv_airport: $scope.arrival.arrv_airport,
      arrv_ride_req: $scope.arrival.arrv_ride_req,
      dept_ride_req: $scope.departure.dept_ride_req,
      dept_airport: $scope.departure.dept_airport,
      dept_time: $filter('time')($scope.departure.dept_time),
      dept_date:  $filter('date')($scope.departure.dept_date, 'yyyy-MM-dd'),
      accommodation_req: $scope.accommodation.accommodation_req,
      accommodation_pref: $scope.accommodations[$scope.accommodation.accommodation_pref].name,
      status: 'pending'
    }
    console.log(profile);
    Conferences.attendees().update({cid: $stateParams.conference_id, pid: $stateParams.profile_id}, profile)
    .$promise.then( function ( response ) {
      if ( response ) {
        $state.go('profile');
        popup.alert( 'success', "Conference profile successfully updated" );
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })
  };

})
