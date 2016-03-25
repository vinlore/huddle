angular.module( 'profileCtrl', [] )
.controller( 'profileController', function ( $scope, Profile, $filter, popup, Users, $rootScope ) {

    $scope.user = {};

    $scope.saveNameChanges = function () {
        var profile = {
            first_name: $scope.user.FirstName,
            last_name: $scope.user.LastName,
            middle_name: $scope.user.MiddleName
        };
        Profile.update( {uid: $rootScope.user.id, pid: $scope.user.id}, profile )
            .$promise.then( function ( response ) {
                if ( response.status == 'success' ) {
                    popup.alert( 'success', 'Name successfully changed.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.saveContactChanges = function () {
        var profile = {
            email: $scope.user.Email,
            phone: $scope.user.HomePhone
        };
        Profile.update( {uid: $rootScope.user.id, pid: $scope.user.id}, profile )
            .$promise.then( function ( response ) {
                if ( response.status == 'success' ) {
                    popup.alert( 'success', 'Contact information successfully changed.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.saveAddressChanges = function () {
        var profile = {
            city: $scope.user.City,
            country: $scope.user.Country
        };
        Profile.update( {uid: $rootScope.user.id, pid: $scope.user.id}, profile )
            .$promise.then( function ( response ) {
                if ( response.status == 'success' ) {
                    popup.alert( 'success', 'Contact information successfully changed.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.savePasswordChanges = function () {
        var password = {
            password: $scope.user.NewPassword
        };
        Users.update( { id: $rootScope.user.id }, password )
            .$promise.then( function ( response ) {
                if ( response.status == 'success' ) {
                    popup.alert( 'success', 'Password successfully changed.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.deleteAccount = function () {
        Users.delete( user )
            .$promise.then( function ( response ) {
                if ( response.status == 'success' ) {
                    popup.alert( 'success', 'User successfully deleted.' );
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    };

    $scope.loadProfile = function () {
        Profile.get( { uid: $rootScope.user.id } )
            .$promise.then( function ( response ) {
                if ( response ) {
                    var profile = response;
                    $scope.user = {
                        id: profile.id,
                        Username: $rootScope.user.name,
                        OldPassword: null,
                        NewPassword: null,
                        ConfirmPassword: null,
                        FirstName: profile.first_name,
                        MiddleName: profile.middle_name,
                        LastName: profile.last_name,
                        Birthdate: $filter('date')(profile.birthdate, 'yyyy-MM-dd'),
                        Gender: profile.gender,
                        Country: profile.country,
                        City: profile.city,
                        Email: profile.email,
                        HomePhone: profile.phone
                    };
                } else {
                    popup.error('Error', response.error);
                }
            }, function () {
                popup.connection();
            } )
    }

    $scope.loadProfile();

    $scope.conferences = [
      {Time: "01:00:00",
      Date: "Monday March 7, 2016",
      Log: "James created a conference name India"},

      {Time: "02:00:00",
      Date: "Tuesday March 8, 2016",
      Log: "Gabby is requesting to attend Canada conference"},

      {Time: "03:00:00",
      Date: "Wednesday March 9, 2016",
      Log: "Viggy editted France conference"},

      {Time: "04:00:00",
      Date: "Wednesday March 9, 2016",
      Log: "Chris approved Martin's conference attendance"},
      {Time: "01:00:00",
      Date: "Monday March 7, 2016",
      Log: "James created a conference name India"},

      {Time: "02:00:00",
      Date: "Tuesday March 8, 2016",
      Log: "Gabby is requesting to attend Canada conference"},

      {Time: "03:00:00",
      Date: "Wednesday March 9, 2016",
      Log: "Viggy editted France conference"},

      {Time: "04:00:00",
      Date: "Wednesday March 9, 2016",
      Log: "Chris approved Martin's conference attendance"},
    ];

} );
