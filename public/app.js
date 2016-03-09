'use strict';

angular.module('cms', [
    'ngRoute',
    'ngResource',
    'ui.bootstrap',
    'ngAnimate',
    'headerCtrl',
    'homeCtrl',
    'adminCtrl',
    'userRegCtrl',
    'conferenceCtrl',
    'loginCtrl',
    'createConferenceCtrl',
    'profileCtrl',
    'activityCtrl',
    'manageAccountsCtrl',
    'apiService',
    'conferenceService',
    'eventService',
    'mapService',
    'countryService',
    'satellizer',
    'customDirs',
    'validateDirectives',
    'customFilters',
    'google.places',
    'popupPromptCtrl',
    'signupConfCtrl',
    'signupEventCtrl',
    'ng-fusioncharts'
])

.run( function( $rootScope, $auth ) {
    $rootScope.auth = $auth.isAuthenticated();
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
        controller: 'loginController',
        resolve: {
            skipIfLoggedIn: skipIfLoggedIn
        }
    })

    .when( '/admin', {
        templateUrl: 'components/admin/adminView.html',
        controller: 'adminController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .when( '/register', {
        templateUrl: 'components/userReg/userRegView.html',
        controller: 'userRegController',
        resolve: {
            skipIfLoggedIn: skipIfLoggedIn
        }
    })

    .when( '/conference-:conferenceId', {
        templateUrl: 'components/conference/conferenceView.html',
        controller: 'conferenceController'
    })

    .when( '/create-conference', {
        templateUrl: 'components/createConference/createConferenceView.html',
        controller: 'createConferenceController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .when('/signup-conference', {
        templateUrl: 'components/signupConference/signupConferenceView.html',
        controller: 'signupConferenceController',
        resolve: {
          loginRequired: loginRequired
        }
    })

    .when('/signup-event', {
        templateUrl: 'components/signupEvent/signupEventView.html',
        controller: 'signupEventController',
        resolve: {
          loginRequired: loginRequired
        }
    })

    .when( '/profile', {
        templateUrl: 'components/profile/profileView.html',
        controller: 'profileController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .when( '/logs', {
        templateUrl: 'components/activityLog/activityLogView.html',
        controller: 'activityLogController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .when( '/accounts', {
        templateUrl: 'components/manageAccounts/manageAccountsView.html',
        controller: 'manageAccountsController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .otherwise({redirectTo: '/'});

    $locationProvider.html5Mode(true);

    function skipIfLoggedIn( $q, $auth, $location ) {
        var deferred = $q.defer();
        if ( $auth.isAuthenticated() ) {
            $location.path('/');
        } else {
            deferred.resolve();
        }
        return deferred.promise;
    }

    function loginRequired( $q, $auth, $location ) {
        var deferred = $q.defer();
        if ( $auth.isAuthenticated() ) {
            deferred.resolve();
        } else {
            $location.path('/login');
        }
        return deferred.promise;
    }
});
