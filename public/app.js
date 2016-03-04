'use strict';

angular.module('cms', [
    'ngRoute',
    'ngResource',
    'ui.bootstrap',
    'ngAnimate',
    'homeCtrl',
    'adminCtrl',
    'userRegCtrl',
    'conferenceCtrl',
    'loginCtrl',
    'createConferenceCtrl',
    'profileCtrl',
    'activityCtrl',
    'apiService',
    'conferenceService',
    'eventService',
    'mapService',
    'countryService',
    'satellizer',
    'customDirs',
    'customFilters',
    'google.places'
])

.run( function( $rootScope, $auth, Logout ) {
    $rootScope.auth = $auth.isAuthenticated();

    // Logout function
    $rootScope.logout = function() {
        Logout.save( $auth.getToken() )
            .$promise.then( function( response ) {  // OK
                if ( response.success ) {   // If logout on server was successful
                    console.log("Logging out...");
                    $auth.logout().then( function( result ) {   // If logout on front-end was successful
                        $rootScope.auth = $auth.isAuthenticated();
                    });
                }
            }, function( response ) {   // API call failed
                console.log("An error occurred while logging in.");
            })
    };
})

.config( function( $routeProvider, $locationProvider, $authProvider ) {
    $authProvider.loginUrl = '/api/auth';

    $routeProvider

    .when( '/', {
    templateUrl: 'components/home/homeView.html',
    controller: 'homeController'
    })

    .when( '/login', {
    templateUrl: 'components/login/loginView.html',
    controller: 'loginController'
  })

    .when( '/admin', {
    templateUrl: 'components/admin/adminView.html',
    controller: 'adminController'
    })

    .when( '/register', {
    templateUrl: 'components/userReg/userRegView.html',
    controller: 'userRegController'
    })

    .when( '/conference-:conferenceId', {
    templateUrl: 'components/conference/conferenceView.html',
    controller: 'conferenceController'
    })

    .when( '/create-conference', {
    templateUrl: 'components/createConference/createConferenceView.html',
    controller: 'createConferenceController'
    })

    .when( '/profile', {
    templateUrl: 'components/profile/profileView.html',
    controller: 'profileController'
    })

    .when( '/logs', {
    templateUrl: 'components/activityLog/activityLogView.html',
    controller: 'activityLogController'
    })

    .otherwise({redirectTo: '/'});

    $locationProvider.html5Mode(true);
});
