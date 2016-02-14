'use strict';

angular.module('cms', [
  'ngRoute',
  'ngResource',
  'ui.bootstrap',
  'ngAnimate',
  'homeCtrl',
  'adminCtrl',
  'userRegCtrl'
])

.config(function($routeProvider, $locationProvider) {
  $routeProvider

  .when('/', {
  	templateUrl: 'components/home/homeView.html',
  	controller: 'homeController'
  })

  .when('/admin', {
    templateUrl: 'components/admin/adminView.html',
    controller: 'adminController'
  })

  .when('/register', {
    templateUrl: 'components/userReg/userRegView.html',
    controller: 'userRegController'
  })

  .otherwise({redirectTo: '/'});

  $locationProvider.html5Mode(true);
});
