'use strict';

angular.module('cms', [
  'ngRoute',
  'ui.bootstrap',
  'ngAnimate',
  'homeController'
])

.config(function($routeProvider, $locationProvider) {
  $routeProvider

  .when('/', {
  	templateUrl: 'components/home/homeView.html',
  	controller: 'homeController'
  })

  .otherwise({redirectTo: '/'});

  $locationProvider.html5Mode(true);
});
