'use strict';

angular.module('cms', [
  'ngRoute',
  'ui.bootstrap',
  'ngAnimate',
  'homeController'
])

.config(function($routeProvider, $locationProvider) {
  $routeProvider

  .when('/home', {
  	templateUrl: 'components/home/homeView.html',
  	controller: 'homeController'
  })

  .otherwise({redirectTo: '/home'});

  $locationProvider.html5Mode(true);
});
