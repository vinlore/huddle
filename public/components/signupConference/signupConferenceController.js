angular.module('signupConfCtrl',[])
.controller('signupConferenceController', function($scope, $stateParams, Conference, Countries, popup){

    $scope.calendar = {
        isOpen1: false,
        isOpen2: false,
        isOpen3: false
    };

    $scope.countries = Countries;

    $scope.changeCountry = function (country) {
        $scope.citiesOnly.componentRestrictions = {country: country.code};
        console.log($scope.citiesOnly)
    };

    $scope.citiesOnly = {
        types: ['(cities)']
    };

  $scope.user = {
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
      MedicalConditions: null,
      accommRequired: false
  };

  $scope.emergencyContact = {
    FirstName: null,
    LastName: null,
    PhoneNumber: null,
    Email: null
  }

  $scope.conference = {
      conferenceId: $stateParams.conferenceId,
      name: $stateParams.name
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
            if ( response.status == 200 ) {
                $scope.accommodations = response.accommodations;
            } else {
                // TODO - error
            }
        })
  }*/

  $scope.familymembers = [
    {
      id : 'member1',
      FirstName: null,
      MiddleName: null,
      LastName: null,
      Age: null,
      Gender: null,
      Country: null,
      City: null
    }
  ]

  $scope.addFamilyMember = function () {
    var newFamMem = $scope.familymembers.length + 1;
    $scope.familymembers.push({'id':'member'+newFamMem});
  }

  $scope.removeFamilyMember = function (index) {
    $scope.familymembers.splice(index, 1);
  }

    /*$scope.submitRequest = function() {
        if ( $scope.profileForm.$valid ) {
            var profile = {
                first_name: $scope.user.FirstName,
                last_name: $scope.user.LastName,
                birthdate: $filter('date')($scope.user.Birthdate, 'yyyy-MM-dd'),
                gender: $scope.user.Gender,
                country: $scope.user.Country,
                city: $scope.user.city,
                email: $scope.user.email,
                phone: $scope.user.HomePhone,
                phone2: $scope.user.OtherPhone,
                conference_id: $stateParams.conferenceId,
                contact_first_name: $scope.emergencyContact.FirstName,
                contact_last_name: $scope.emergencyContact.LastName,
                contact_email: $scope.emergencyContact.Email,
                contact_phone: $scope.emergencyContact.PhoneNumber,
                arrv_ride_req: $scope.arrival.RideRequired,
                dept_ride_req: $scope.departure.RideRequired,
                accomm_req: $scope.user.accommRequired,
                medical_conditions: $scope.user.MedicalConditions,
                accomm_pref:
            }
            Conference.attendees().save( {cid: $stateParams.conferenceId} )
                .$promise.then( function( response ) {
                    if ( response.status == 200 ) {
                        console.log( 'User successfully registered to attend conference' );
                        // TODO change attending button to pending approval
                    } else {
                        popup.error( 'Error', response.message );
                    }
                }, function () {
                    popup.connection();
                });
        }
    }*/

})
