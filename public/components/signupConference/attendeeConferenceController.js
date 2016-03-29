var app = angular.module('attendeeConfCtrl', []);
app.controller('attendeeConferenceController', function($scope, $stateParams, Conferences, Countries, Profile, ProfileAttendsConferences, popup, $rootScope, $filter, $state) {

  $scope.calendar = {
    isOpen1: false,
    isOpen2: false,
    isOpen3: false
  };

  $scope.countries = Countries;
  $scope.header = "Application";

  $scope.changeCountry = function(country) {
    $scope.citiesOnly.componentRestrictions = { country: country.code };
    console.log($scope.citiesOnly)
  };

  $scope.citiesOnly = {
    types: ['(cities)']
  };

  $scope.emergencyContact = {
    FirstName: null,
    LastName: null,
    PhoneNumber: null,
    Email: null
  }

  $scope.conference = {
    conferenceId: $stateParams.conference_id,
    name: $stateParams.conference_name
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


  $scope.attendeeProfile = [];
  $scope.loadAttendeeProfile = function() {
    Conferences.attendees().query({cid: $stateParams.conference_id, pid: $stateParams.profile_id})
    .$promise.then(function(response){
      if(response){
        var profile_arr = response;
        var profile = profile_arr[0].pivot;
        $scope.user = {
          profile_id: profile.profile_id,
          first_name: profile.first_name,
          last_name: profile.last_name,
          birthdate: $filter('date')(profile.birthdate, 'yyyy-MM-dd'),
          gender: profile.gender,
          country: profile.country,
          city: profile.city,
          email: profile.email,
          phone: profile.phone,
          phone2: profile.phone2,
          contact_first_name: profile.contact_first_name,
          contact_last_name: profile.contact_last_name,
          contact_email: profile.contact_email,
          contact_phone: profile.contact_phone,
          arrv_time: profile.arrv_time,
          arrv_date: profile.arrv_date,
          arrv_airport: profile.arrv_airport,
          arrv_ride_req: profile.arrv_ride_req,
          dept_ride_req: profile.dept_ride_req,
          dept_airport: profile.dept_airport,
          dept_time: profile.dept_time,
          dept_date: profile.dept_date,
          accommodation_req: profile.accommodation_req,
          medical_conditions: profile.medical_conditions,
          status: profile.status,
          accommodation_pref: profile.accommodation_pref
        };
        console.log($scope.user);
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })
  };
  $scope.loadAttendeeProfile();

  $scope.accommodation = {
    accommRequired: false,
    accomPref: null
  }

  $scope.conference = {
    conferenceId: $stateParams.conference_id,
    name: $stateParams.conference_name
  }


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

  $scope.addFamilyMember = function() {
    var newFamMem = $scope.familymembers.length + 1;
    $scope.familymembers.push({ 'id': 'member' + newFamMem });
  }

  $scope.removeFamilyMember = function(index) {
    $scope.familymembers.splice(index, 1);
  }

  $scope.submitRequest = function() {
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
        contact_first_name: $scope.user.contact_first_name,
        contact_last_name: $scope.user.contact_last_name,
        contact_email: $scope.user.contact_email,
        contact_phone: $scope.user.contact_phone,
        arrv_time: $scope.user.arrv_time,
        arrv_date: $scope.user.arrv_date,
        arrv_airport: $scope.user.arrv_airport,
        arrv_ride_req: $scope.user.arrv_ride_req,
        dept_ride_req: $scope.user.dept_ride_req,
        dept_airport: $scope.user.dept_airport,
        dept_time: $scope.user.dept_time,
        dept_date: $scope.user.dept_date,
        accommodation_req: $scope.user.accommodation_req,
        medical_conditions: $scope.user.medical_conditions,
        status: 'pending',
        accommodation_pref: $scope.user.accommodation_pref
      }
      ProfileAttendsConferences.status().update({cid: $stateParams.conference_id , pid: $stateParams.profile_id}, profile)
      .$promise.then(function(response) {
        if (response.status == 200) {
          popup.alert('success', 'Conference profile updated.');
          $state.go('profile');
        } else {
          popup.error('Error', response.message);
        }
      }, function() {
        popup.connection();
      });
  };

})