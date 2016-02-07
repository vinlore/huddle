'use strict';

angular.module('cms', [
  'ngRoute',
  'ui.bootstrap',
  'ngAnimate',
  'homeCtrl',
  'adminCtrl'
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

  .otherwise({redirectTo: '/'});

  $locationProvider.html5Mode(true);
});
