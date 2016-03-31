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
    'managersCtrl',
    'createConferenceCtrl',
    'profileCtrl',
    'activityCtrl',
    'manageAccountsCtrl',
    'apiService',
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
    'manageAccommodationsCtrl',
    'manageInventoryCtrl',
    'manageConferenceAttendeesCtrl',
    'manageEventAttendeesCtrl',
    'manageConferenceTransportationCtrl',
    'manageEventTransportationCtrl',
    'manageRoomsCtrl',
    'ngStorage',
    'popupServices',
    'ngMap',
    'ui.router',
    'manageRequestsCtrl',
    'ngTable',
    'ngSanitize',
    'ngCsv',
    'permissionService',
    'reportsCtrl',
    'angular-timeline',
    'ui.mask',
    'createEventCtrl',
    'attendeeConfCtrl',
    'attendeeEventCtrl',
    'conferenceAttendeeModalCtrl',
    'eventAttendeeModalCtrl',
    'draftEventCtrl',
    'draftConferenceCtrl'
])

.run( function( $rootScope, $auth, $localStorage, $http, popup ) {
    $rootScope.auth = $auth.isAuthenticated();

    $rootScope.$on('$stateChangeStart',
        function () {
            var user;
            if ($rootScope.user) {
                user = $rootScope.user.id;
                var token;
                if ($auth.getToken()) token = $auth.getToken();
                $http({
                    method: 'POST',
                    url: 'api/auth/confirm',
                    headers: {
                        'X-Auth-Token': token,
                        'ID': user
                    }
                }).success( function ( response ) {
                    if ( response.status == 500 ) {
                        popup.alert('danger', 'You have been logged out.');
                        $auth.removeToken();
                        $rootScope.auth = null;
                        $rootScope.user = null;
                        delete $localStorage.user;
                    } else {
                        $rootScope.user.permissions = response.permissions;
                        $rootScope.user.conferences = response.manages_conf;
                        $rootScope.user.events = response.manages_event;
                    }
                })
            }
        });

    $rootScope.user = $localStorage.user;
    $rootScope.alerts = [];
})

.config(function( $stateProvider, $urlRouterProvider, $locationProvider, $authProvider, $httpProvider, uiMaskConfigProvider ) {
    $authProvider.loginUrl = 'api/auth/login';
    $authProvider.httpInterceptor = false;

    $httpProvider.interceptors.push('tokenInterceptor');
    $httpProvider.defaults.headers.common["Accept"] = 'application/json';
    $httpProvider.defaults.headers.common["X-frame-options"] = "DENY";

    var maskDefinitions = uiMaskConfigProvider.$get().maskDefinitions;
    angular.extend(maskDefinitions, {'2': /[0-2]/, '6': /[0-6]/});

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
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermissions) {
                var deferred = $q.defer();
                if ( checkPermissions('admin', '', '') ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
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
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, checkPermission) {
                var deferred = $q.defer();
                if ( checkPermission('conference.store', '', '') ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
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

    .state( 'create-event', {
        url: '/conference-:conferenceId/create-event',
        templateUrl: 'components/createEvent/createEventView.html',
        controller: 'createEventController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermission) {
                var deferred = $q.defer();
                if ( checkPermission('event.store', 'conference', $stateParams.conferenceId) ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
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
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermissions) {
                var deferred = $q.defer();
                if ( checkPermissions('accounts', '', '') ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
        }
    })

    .state( 'conference-managers', {
        url: '/conference-:conferenceId/managers',
        templateUrl: 'components/manageManagers/manageManagersView.html',
        controller: 'conferenceManagersController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermission) {
                var deferred = $q.defer();
                if ( checkPermission('user.store', '', '') ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
        }
    })

    .state( 'event-managers', {
        url: '/event-:eventId/managers',
        templateUrl: 'components/manageManagers/manageManagersView.html',
        controller: 'eventManagersController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermission) {
                var deferred = $q.defer();
                if ( checkPermission('user.store', '', '') ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
            // TODO
        }
    })

    .state( 'manage-accommodations', {
        url: '/manage-accommodations-:conferenceId',
        templateUrl: 'components/manageAccommodations/manageAccommodationsView.html',
        controller: 'manageAccommodationsController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermissions) {
                var deferred = $q.defer();
                if ( checkPermissions('acommodation', 'conference', $stateParams.conferenceId) ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
        }
    })

    .state( 'manage-inventory', {
        url: '/manage-inventory-:conferenceId',
        templateUrl: 'components/manageInventory/manageInventoryView.html',
        controller: 'manageInventoryController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermissions) {
                var deferred = $q.defer();
                if ( checkPermissions('item', 'conference', $stateParams.conferenceId) ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
        }
    })

    .state( 'manage-rooms', {
        url: '/manage-rooms-:conferenceId-:accommodationId',
        templateUrl: 'components/manageRooms/manageRoomsView.html',
        controller: 'manageRoomsController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermissions) {
                var deferred = $q.defer();
                if ( checkPermissions('room', 'conference', $stateParams.conferenceId) ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
        }
    })

    .state( 'manage-transportation-conference', {
        url: '/manage-transportation-conference-:conferenceId',
        templateUrl: 'components/manageTransportation/manageTransportationView.html',
        controller: 'manageConferenceTransportationController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermissions) {
                var deferred = $q.defer();
                if ( checkPermissions('conference_vehicle', 'conference', $stateParams.conferenceId) ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
        }
    })

    .state( 'manage-transportation-event', {
        url: '/manage-transportation-event-:conferenceId-:eventId',
        templateUrl: 'components/manageTransportation/manageTransportationView.html',
        controller: 'manageEventTransportationController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermissions) {
                var deferred = $q.defer();
                if ( checkPermissions('event_vehicle', 'event', $stateParams.eventId) ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
        }
    })

    .state( 'requests', {
        url: '/requests',
        templateUrl: 'components/manageRequests/manageRequestsView.html',
        controller: 'manageRequestsController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, checkPermissions) {
                var deferred = $q.defer();
                if ( checkPermissions('publisher', '', '') ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
        }
    })

    .state( 'reports', {
        url: '/reports-:conferenceId',
        templateUrl: 'components/reports/reportsView.html',
        controller: 'reportsController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermissions) {
                var deferred = $q.defer();
                if ( checkPermissions('conference_attendee', 'conference', $stateParams.conferenceId) ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
        }
    })

    .state( 'manage-attendees-conference', {
        url: '/manage-attendees-conference-:conferenceId',
        templateUrl: 'components/manageAttendees/manageAttendeesView.html',
        controller: 'manageConferenceAttendeesController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermissions) {
                var deferred = $q.defer();
                if ( checkPermissions('conference_attendee', 'conference', $stateParams.conferenceId) ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
        }
    })

    .state( 'manage-attendees-event', {
        url: '/manage-attendees-event-:conferenceId-:eventId',
        templateUrl: 'components/manageAttendees/manageAttendeesView.html',
        controller: 'manageEventAttendeesController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermissions) {
                var deferred = $q.defer();
                if ( checkPermissions('event_attendee', 'event', $stateParams.eventId) ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
        }
    })

    .state( 'attendee-conference-profile', {
        url: '/attendee-conference-profile-:conference_name?:conference_id?:profile_id',
        templateUrl: 'components/signupConference/attendeeSignupConferenceView.html',
        controller: 'attendeeConferenceController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermissions) {
                var deferred = $q.defer();
                if ( checkPermissions('', 'profile', $stateParams.profile_id) ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
        }
    })

    .state( 'attendee-event-profile', {
        url: '/attendee-event-profile-:event_name?:event_id?:profile_id',
        templateUrl: 'components/signupEvent/signupEventView.html',
        controller: 'attendeeEventController',
        resolve: {
            loginRequired: loginRequired,
            permissionsRequired: function ($q, $location, $stateParams, checkPermissions) {
                var deferred = $q.defer();
                if ( checkPermissions('', 'profile', $stateParams.profile_id) ) {
                    deferred.resolve();
                } else {
                    $location.path('/');
                }
                return deferred.promise;
            }
        }
    })

    .state( 'draft-event', {
        url: '/draft-event-:event_id?:conference_id',
        templateUrl: 'components/createEvent/createEventView.html',
        controller: 'draftEventController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .state( 'draft-conference', {
        url: '/draft-conference-:conference_id',
        templateUrl: 'components/createConference/createConferenceView.html',
        controller: 'draftConferenceController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .state( 'draft-event', {
        url: '/draft-event-:event_id?:conference_id',
        templateUrl: 'components/createEvent/createEventView.html',
        controller: 'draftEventController',
        resolve: {
            loginRequired: loginRequired
        }
    })

    .state( 'draft-conference', {
        url: '/draft-conference-:conference_id',
        templateUrl: 'components/createConference/createConferenceView.html',
        controller: 'draftConferenceController',
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

    function permissionRequired( $q, $location, checkPermission ) {
        return function (permission, type, id) {
            var deferred = $q.defer();
            if ( checkPermission(permission, type, id) ) {
                deferred.resolve();
            } else {
                $location.path('/login');
            }
            return deferred.promise;
        }
    }

    function permissionsRequired( $q, $location, checkPermissions ) {
        return function (permission, type, id) {
            var deferred = $q.defer();
            if ( checkPermissions(permission, type, id) ) {
                deferred.resolve();
            } else {
                $location.path('/login');
            }
            return deferred.promise;
        }
    }
})

.factory('tokenInterceptor', function ($q, $rootScope, $injector) {
    return {
        'response': function (response) {
            var $auth = $injector.get('$auth');
            var $http = $injector.get('$http');
            var token = $auth.getToken();
            if (token) {
                $http.defaults.headers.common["X-Auth-Token"]=token;
            } else {
                $http.defaults.headers.common["X-Auth-Token"]=undefined;
            }
            var user = $rootScope.user;
            var id = undefined;
            if (user) {
                id = user.id;
            }
            $http.defaults.headers.common["ID"]=id;
            return response || $q.when(response);
        }
    };
});
