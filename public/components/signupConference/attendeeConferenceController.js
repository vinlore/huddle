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
  //$scope.user = {}

  $scope.changeCountry = function(country) {
    $scope.citiesOnly.componentRestrictions = { country: country.code };
    //console.log($scope.citiesOnly)
  };

  $scope.citiesOnly = {
    types: ['(cities)']
  };


  $scope.loadAttendeeProfile = function() {
    Conferences.attendees().get({cid: $stateParams.conference_id, pid: $stateParams.profile_id})
    .$promise.then(function(response){
      if(response){
        var profile = response.pivot;
        $scope.user = profile;
        console.log(profile);
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })
  };
  $scope.loadAttendeeProfile();

  $scope.accommodations = [];
  $scope.loadAccommodations = function () {
    Conferences.accommodations().query( {cid: $stateParams.conference_id} )
    .$promise.then( function( response ) {
      if ( response ) {
        $scope.accommodations = response;
        //console.log(response);
      } else {
        // TODO error
      }
    })
  }
  $scope.loadAccommodations();

  $scope.arrival = {
    arrv_time: null,
  }

  $scope.departure = {
    dept_time: null,
  }

  $scope.submitRequest = function(){
    if(!$scope.user.arrv_ride_req){
      $scope.user.arrv_date = null;
      $scope.user.arrv_airport = null;
      $scope.user.arrv_time = null;
    }
    if(!$scope.user.dept_ride_req){
      $scope.user.dept_date = null;
      $scope.user.dept_airport = null;
      $scope.user.dept_time = null;
    }
    var profile = {
      first_name: $scope.user.first_name,
      middle_name: $scope.user.middle_name,
      last_name: $scope.user.last_name,
      birthdate: $filter('date')($scope.user.birthdate, 'yyyy-MM-dd'),
      gender: $scope.user.gender,
      country: $scope.user.country,
      city: $scope.user.city,
      email: $scope.user.email,
      phone: $scope.user.phone,
      phone2: $scope.user.phone2,
      medical_conditions: $scope.user.medical_conditions,
      contact_first_name: $scope.user.contact_first_name,
      contact_last_name: $scope.user.contact_last_name,
      contact_email: $scope.user.email,
      contact_phone: $scope.user.contact_phone,
      arrv_time: $filter('time')($scope.arrival.arrv_time),
      arrv_date: $filter('date')($scope.user.arrv_date, 'yyyy-MM-dd'),
      arrv_airport: $scope.user.arrv_airport,
      arrv_ride_req: $scope.user.arrv_ride_req,
      dept_ride_req: $scope.user.dept_ride_req,
      dept_airport: $scope.user.dept_airport,
      dept_time: $filter('time')($scope.departure.dept_time),
      dept_date:  $filter('date')($scope.user.dept_date, 'yyyy-MM-dd'),
      accommodation_req: $scope.user.accommodation_req,
      accommodation_pref: String($scope.user.accommodation_pref)
    }
    console.log(profile);
    Conferences.attendees().update({cid: $stateParams.conference_id, pid: $stateParams.profile_id}, profile)
    .$promise.then( function ( response ) {
      if ( response.status == 200 ) {
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
