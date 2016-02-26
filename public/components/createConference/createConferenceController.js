angular.module( 'createConferenceCtrl', [])
.controller( 'createConferenceController', function( $scope, Countries ) {
    
    $scope.conference = {
        name: null,
        country: null,
        city: null,
        address: null
    }

    $scope.countries = Countries;

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.addressOnly = {
        types: ['address']
    }

    $scope.calendar = {
        isOpen1: false,
        isOpen2: false
    };

})