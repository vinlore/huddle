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
  'profileCtrl'
  'conferenceService',
  'eventService',
  'mapService',
  'countryService',
  'satellizer',
  'customDirs',
  'customFilters',
  'google.places'
])

.config(function($routeProvider, $locationProvider, $authProvider) {
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
    controller: 'profileViewController'
  })

  .otherwise({redirectTo: '/'});

  $locationProvider.html5Mode(true);
});
