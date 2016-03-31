angular.module( 'draftEventCtrl', [])
.controller( 'draftEventController', function( $scope, Countries, Events, $stateParams, $filter, $location, popup, $state ) {
    $scope.header = "Draft";
    $scope.creation = false;
    $scope.draft = true;
    $scope.event = {
        conference_id: $stateParams.conference_id,
        name: null,
        description: null,
        facilitator: null,
        date: null,
        start_time: null,
        end_time: null,
        address: null,
        city: null,
        country: null,
        age_limit: null,
        gender_limit: null,
        attendee_count: null,
        description: null,
        capacity: null,
        status: null,
    }

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.addressOnly = {
        types: ['address']
    }

    $scope.calendar = {
        isOpen1: false
    };

    $scope.arrTransport = [
        {
            name: null,
            capacity: null
        }
    ]

    $scope.addArrival = function() {
        var item = {
            name: null,
            capacity: null
        }
        $scope.arrTransport.push( item );
    }

    $scope.removeArrival = function( ind ) {
        $scope.arrTransport.splice( ind, 1 );
    }

    $scope.depTransport = [
        {
            name: null,
            capacity: null
        }
    ]

    $scope.addDeparture = function() {
        var item = {
            name: null,
            capacity: null
        }
        $scope.depTransport.push( item );
    }

    $scope.removeDeparture = function( ind ) {
        $scope.depTransport.splice( ind, 1 );
    }

    // $scope.loadEvent = function(){
    //   Events.fetch().get( { cid: $stateParams.conference_id, eid: $stateParams.event_id} )
    //       .$promise.then( function( response ) {
    //           if ( response ) {
    //               console.log(response);
    //           } else {
    //               popup.error( 'Error', response.message );
    //           }
    //       }, function () {
    //           popup.connection();
    //       })
    // }
    // $scope.loadEvent();

    $scope.submit = function () {
        var city, address, country;
        if ( $scope.event.city ) {
            city = $scope.event.city;
            if ( $scope.event.city.name ) {
                city = $scope.event.city.name;
            }
        }

        if ( $scope.event.country ) {
            country = $scope.event.country;
            if ( $scope.event.country.name ) {
                country = $scope.event.country.name;
            }
        }

        if ( $scope.event.address) {
            address = $scope.event.address;
            if ( $scope.event.address.formatted_address ) {
                address = $scope.event.address.formatted_address;
            }
        }

        var _event = {
          conference_id: $scope.event.conference_id,
          name: $scope.event.name,
          description: $scope.event.description,
          facilitator: $scope.event.facilitator,
          date: $filter('date')($scope.event.date, 'yyyy-MM-dd'),
          start_time: $filter('time')($scope.event.start_time),
          end_time: $filter('time')($scope.event.end_time),
          address: address,
          city: city,
          country: country,
          age_limit: String($scope.event.age_limit),
          gender_limit: $scope.event.gender_limit,
          attendee_count: 0,
          capacity: $scope.event.capacity,
          status: 'pending'
        }

        Events.fetch().save( { cid: _event.conference_id }, _event )
            .$promise.then( function( response ) {
                if ( response.status == 200 ) {
                    $location.url('/');
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
            //
            // Events.vehicles().save( {eid: $stateParams.conferenceId} )
            //     .$promise.then( function( response ) {
            //         if ( response.status == 200 ) {
            //             console.log( 'User successfully registered to attend conference' );
            //             // TODO change attending button to pending approval
            //         } else {
            //             popup.error( 'Error', response.message );
            //         }
            //     }, function () {
            //         popup.connection();
            //     });

    }

})