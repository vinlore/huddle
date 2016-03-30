angular.module('manageRoomsCtrl',[])
.controller('manageRoomsController', function($scope, ngTableParams, $stateParams, $filter, Conferences, popup, $uibModal){

    // Conference ID
    $scope.conferenceId = $stateParams.conferenceId;

    // Accommodation ID
    $scope.accommodationId = $stateParams.accommodationId;

    // Initial input data array
    $scope.room = {
        accommodation_id: $scope.accommodationId,
        room_no: null,
        guest_count: 0,
        capacity: null
    }

    //////// Load Data ////////

    $scope.getAccommodation = function () {
        Conferences.accommodations().get( {cid: $scope.conferenceId, aid: $scope.accommodationId} )
            .$promise.then( function( response ) {
                if ( response ) {
                    $scope.accommodation = response;
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.getAccommodation();


    $scope.tableParams = new ngTableParams(
    {
    },
    {
        counts: [],
        getData: function ($defer, params) {
            Conferences.rooms().query( {aid: $scope.accommodationId} )
            .$promise.then( function( response ) {
                if ( response ) {
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

    //////// Button Functions ////////

    $scope.add = function(room) {

        // Adds acommodation to accommodations table
        Conferences.rooms().save( {aid: $scope.accommodationId}, room )
        .$promise.then( function( response ) {
            if ( response.status == 200 ) {
                console.log(room);
                console.log( 'Changes saved to rooms' );
                popup.alert( 'success', 'Changes have been saved.' );
                
                // clear input data
                $scope.room.room_no = null;
                $scope.room.capacity = null;
            } else {
                popup.error( 'Error', response.message );
            }
        }, function () {
            popup.connection();
        })

        // refresh tableParams to reflect changes
        $scope.tableParams.reload();
    }

    $scope.del = function(room) {
        console.log(room.id);
        var modalInstance = popup.prompt( 'Delete', 'Are you sure you want to delete?' );

        modalInstance.result.then( function ( result ) {
            if (room.guest_count > 0) {
                popup.error( 'Error', 'Cannot delete rooms with guests.' );
            }
            else if ( result ) {
                Conferences.rooms().delete( {aid: $scope.accommodationId, rid: room.id} )
                .$promise.then( function( response ) {
                    if ( response.status == 200 ) {
                        console.log( 'Room has been successfully deleted' );
                        popup.alert( 'success', 'Room has been successfully deleted.' );
                    } else {
                        popup.error( 'Error', response.message );
                    }
                }, function () {
                    popup.connection();
                })

                $scope.tableParams.reload();
            }
        } )
    }

    $scope.export = function() {
    
    }

});