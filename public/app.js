'use strict';

angular.module('cms', [
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
    'popupCtrl',
    'signupConfCtrl',
    'signupEventCtrl',
    'ng-fusioncharts',
    'manageInventoryCtrl',
    'manageTransportationCtrl',
    'ngStorage',
    'popupServices',
    'ngMap',
    'ui.router',
    'manageRequestsCtrl',
])

.run( function( $rootScope, $auth, $localStorage ) {
    $rootScope.auth = $auth.isAuthenticated();
    $rootScope.user = $localStorage.user;
})

.config( function( $stateProvider, $urlRouterProvider, $locationProvider, $authProvider ) {
    $authProvider.loginUrl = 'api/auth/login';
    $authProvider.authHeader = 'X-Auth-Token';
    $authProvider.authToken = '';

    $stateProvider

    .state( 'home', {
        url: '/',
        templateUrl: 'components/home/homeView.html',
        controller: 'homeController'
    })

    .state( 'login', {
        url: '/login',
        templateUrl: 'components/login/loginView.html',
        controller: 'loginController',
        resolve: {
            skipIfLoggedIn: skipIfLoggedIn
        }
    })

    .state( 'admin', {
        url: '/admin',
        templateUrl: 'components/admin/adminView.html',
        controller: 'adminController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .state( 'register', {
        url: '/register',
        templateUrl: 'components/userReg/userRegView.html',
        controller: 'userRegController',
        resolve: {
            skipIfLoggedIn: skipIfLoggedIn
        }
    })

    .state( 'conference', {
        url: '/conference-:conferenceId',
        templateUrl: 'components/conference/conferenceView.html',
        controller: 'conferenceController'
    })

    .state( 'create-conference', {
        url: '/create-conference',
        templateUrl: 'components/createConference/createConferenceView.html',
        controller: 'createConferenceController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .state( 'conference-signup', {
        url: '/conference-:conferenceId/signup?name',
        templateUrl: 'components/signupConference/signupConferenceView.html',
        controller: 'signupConferenceController',
        resolve: {
          loginRequired: loginRequired
        }
    })

    .state( 'event-signup', {
        url: '/event-:eventId/signup?name',
        templateUrl: 'components/signupEvent/signupEventView.html',
        controller: 'signupEventController',
        resolve: {
          loginRequired: loginRequired
        }
    })

    .state( 'profile', {
        url: '/profile',
        templateUrl: 'components/profile/profileView.html',
        controller: 'profileController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .state( 'logs', {
        url: '/logs',
        templateUrl: 'components/activityLog/activityLogView.html',
        controller: 'activityLogController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .state( 'accounts', {
        url: '/accounts',
        templateUrl: 'components/manageAccounts/manageAccountsView.html',
        controller: 'manageAccountsController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .state( 'manage-inventory', {
        url: '/manage-inventory',
        templateUrl: 'components/manageInventory/manageInventoryView.html',
        controller: 'manageInventoryController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .state( '/manage-transportation', {
        url: '/manage-transportation',
        templateUrl: 'components/manageTransportation/manageTransportationView.html',
        controller: 'manageTransportationController'
    })

    .state( 'requests', {
        url: '/manage-requests',
        templateUrl: 'components/manageRequests/manageRequestsView.html',
        controller: 'manageRequestsController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    $urlRouterProvider.otherwise( '/' );

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
