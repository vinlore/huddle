angular.module('guestsModalCtrl', [])
.controller('guestsModalController', function ($scope, $uibModalInstance, Guests, roomId, ngTableParams, popup, $filter) {
     
    $scope.tableParams = new ngTableParams(
    {
    },
    {
        counts: [],
        getData: function ($defer, params) {
            Guests.query( {rid: roomId} )
            .$promise.then( function( response ) {
                if ( response ) {
                    console.log(response);
                    $scope.data = response;
                    $scope.data = params.sorting() ? $filter('orderBy') ($scope.data, params.orderBy()) : $scope.data;
                    $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                    $defer.resolve($scope.data);
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })

        }
    });

    $scope.close = function () {
        $uibModalInstance.close(false);
    }

})