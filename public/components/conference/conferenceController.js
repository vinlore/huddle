angular.module ( 'conferenceCtrl', [] )
.controller ( 'conferenceController', function ( $scope, Conference ) {
    
    $scope.conference = Conference.get(123);



})