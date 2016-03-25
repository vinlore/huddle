angular.module( 'reportsCtrl', [] )
.controller( 'reportsController', function( $scope ) {

  $scope.dataset1 = {
    "chart": {
      "caption": "Countries Represented by Attendees",
      "subCaption": "2016",
      "showBorder": "0",
      "use3DLighting": "0",
      "enableSmartLabels": "1",
      "startingAngle": "30",
      "showLabels": "1",
      "showPercentValues": "1",
      "showLegend": "1",
      "defaultCenterLabel": "",
      "centerLabel": "1",
      "centerLabelBold": "1",
      "showTooltip": "1",
      "decimals": "0",
      "useDataPlotColorForLabels": "1",
      "theme": "fint",
      "enableMultiSlicing": "1",
      "radius3D": "4"
    },
    "data": [
      {
        "label": "Canada",
        "value": "500"
      },
      {
        "label": "India",
        "value": "1500"
      },
      {
        "label": "USA",
        "value": "275"
      },
      {
        "label": "Germany",
        "value": "120"
      }
    ]
  }

  $scope.dataset2 = {
    "chart": {
      "caption": "Gender Representation",
      "subCaption": "2016",
      "showBorder": "0",
      "use3DLighting": "0",
      "enableSmartLabels": "1",
      "startingAngle": "30",
      "showLabels": "1",
      "showPercentValues": "1",
      "showLegend": "1",
      "defaultCenterLabel": "",
      "centerLabel": "1",
      "centerLabelBold": "1",
      "showTooltip": "1",
      "decimals": "0",
      "useDataPlotColorForLabels": "1",
      "theme": "fint",
      "enableMultiSlicing": "1",
      "radius3D": "5"
    },
    "data": [
      {
        "label": "Males",
        "value": "820"
      },
      {
        "label": "Females",
        "value": "1300"
      },
      {
        "label": "Other",
        "value": "275"
      },
    ]
  }

  // $scope.attendees = []
  //
  // $scope.loadAttendees = function () {
  //     Conferences.attendees().get( {cid: $stateParams.conferenceId} )
  //         .$promise.then( function( response ) {
  //             if ( response.status == 'success' && response.attendees ) {
  //                 $scope.attendees = response.attendees;
  //             } else {
  //                 popup.error( 'Error', response.message );
  //             }
  //         }, function () {
  //             popup.connection();
  //         })
  // }
  //
  // $scope.loadAttendees();
  //
  //
  // $scope.femaleCount = 0;
  // $scope.maleCount = 0;
  // $scope.otherCount = 0;
  //
  // $scope.loadGenderDistribution = function() {
  //     for (var i = 0; i < attendees.length; i++){
  //       console.log(attendees[i].gender);
  //       if (attendees.[i].gender == "Male"){
  //           $scope.maleCount++;
  //       } else if (attendees.[i].gender == "Female"){
  //           $scope.femaleCount++;
  //       } else {
  //           $scope.otherCount++;
  //       }
  //     }
  // }
  //
  // $scope.updateMyChartData = function() {
  //   $scope.dataset2.data[0].value = ""+$scope.maleCount;
  //   $scope.dataset2.data[1].value = ""+$scope.femaleCount;
  //   $scope.dataset2.data[2].value = ""+$scope.otherCount;
  // }
  //
  // $scope.updateMyChartData();

})
