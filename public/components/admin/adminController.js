angular.module('adminCtrl', [])
.controller('adminController', function($scope, $location, $log) {

	$scope.conferences = [
        {
            conferenceId: 1,
            name: "India Conference",
            address: "Sansad Marg, Connaught Place, New Delhi, Delhi 110001, India",
            startDate: "Feb 10, 2016",
            endDate: "Feb 11, 2016",
            image: "assets/img/india-flag.gif",
            events: [
            	{
            		name: "Opening Ceremony",
            		address: "Sansad Marg, Connaught Place, New Delhi, Delhi 110001, India",
            		startDateTime: "Feb 10, 2016 9:00 AM",
            		endDateTime: "Feb 10, 2016 10:00 AM"
            	},
            	{
            		name: "Closing Ceremony",
            		address: "Sansad Marg, Connaught Place, New Delhi, Delhi 110001, India",
            		startDateTime: "Feb 11, 2016 5:00 PM",
            		endDateTime: "Feb 11, 2016 6:00 PM"
            	}
            ]
        },
        {
            conferenceId: 2,
            name: "Canada Conference",
            address: "1055 Canada Pl, Vancouver, BC, V6C 0C3, Canada",
            startDate: "Feb 16, 2016",
            endDate: "Feb 17, 2016",
            image: "assets/img/canada-flag.gif",
            events: [
            ]
        },
        {
            conferenceId: 3,
            name: "France Conference",
            address: " 17 Boulevard Saint Jacques,  Paris,  75014,  France  ",
            startDate: "Feb 22, 2016",
            endDate: "Feb 23, 2016",
            image: "assets/img/world-flag.gif",
            events: [
            ]
        }
    ];

    show = function(events) {
    	alert("hi");
		if (events.show == false) {
			events.show = true;
		}
	}

    $scope.goAccommodations = function(id, event){
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        $location.url('/manage-accommodations-' + id);
    }

    $scope.goTransportation = function(id, event){
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        $location.url('/manage-transportation-' + id);
    }

		$scope.goInventory = function(id, event){
				if (event) {
						event.preventDefault();
						event.stopPropagation();
				}
				$location.url('/manage-inventory-' + id);
		}

		$scope.goReports = function(id, event){
				if (event) {
						event.preventDefault();
						event.stopPropagation();
				}
				$location.url('/reports-' + id);
		}

})
