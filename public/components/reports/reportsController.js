angular.module( 'reportsCtrl', [] )
.controller( 'reportsController', function( $scope, Conferences, Events, $stateParams, popup, $rootScope ) {

  // $scope.countryMap = {}
  $scope.attendees = []
  $scope.males = []
  $scope.females = []
  $scope.others = []
  $scope.countries = []
  $scope.countryData = []
  $scope.eventData = []
  $scope.eventsName = []

  $scope.filterGender = function(arr){
    for (var i = 0; i < arr.length; i++){
      if(arr[i].gender == "male"){
        $scope.males.push(arr[i]);
      } else if (arr[i].gender == "female"){
        $scope.females.push(arr[i]);
      } else {
        $scope.others.push(arr[i]);
      }
    }
  }

  $scope.filterCountries = function(arr){
    for (var i = 0; i < arr.length; i++){
      if($scope.countries.indexOf(arr[i].pivot.country) == -1){
        $scope.countries.push(arr[i].pivot.country);
        var obj = {
          "label": ""+arr[i].pivot.country+"",
          "value": "1"
        }
        $scope.countryData.push(obj);
      } else {
        var offset = $scope.countries.indexOf(arr[i].pivot.country);
        var newVal = parseInt($scope.countryData[offset].value) + 1;
        $scope.countryData[offset].value = ""+newVal+"";
      }
    }
  }

  $scope.filterEvents = function(arr){
    for (var i = 0; i < arr.length; i++){
      if($scope.eventsName.indexOf(arr[i].name) == -1){
        $scope.eventsName.push(arr[i].name);
        var obj = {
          "label": ""+arr[i].name+"",
          "value": ""+arr[i].attendee_count+""
        }
        $scope.eventData.push(obj);
      } else {
        var offset = $scope.eventsName.indexOf(arr[i].name);
        var newVal = parseInt($scope.eventData[offset].value) + 1;
        $scope.eventData[offset].value = ""+newVal+"";
      }
    }
  }

  $scope.loadConferenceData = function(){
    Conferences.fetch().get({cid: $stateParams.conferenceId})
    .$promise.then( function( response ) {
      if ( response ) {
        $scope.conference = response;
        //console.log(response);
      } else {
        popup.error( 'Error', response.message );
      }}, function () {
        popup.connection();
      })
    };
    $scope.loadConferenceData();

  $scope.loadAttendees = function () {
    Conferences.attendees().query( {cid: $stateParams.conferenceId} )
    .$promise.then( function( response ) {
      if ( response ) {
        //console.log(response);
        $scope.attendees = response;
        $scope.filterGender($scope.attendees);
        $scope.filterCountries($scope.attendees);
        $scope.updateGenderData();
      } else {
        popup.error( 'Error', response.message );
      }}, function () {
        popup.connection();
      })
    };
    $scope.loadAttendees();

    $scope.loadEvents = function () {
        Events.fetch().query( {cid: $stateParams.conferenceId} )
            .$promise.then( function( response ) {
                if ( response ) {
                    $scope.events = response;
                    $scope.filterEvents($scope.events)
                    //console.log(response);
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }
    $scope.loadEvents();

    $scope.genderData =  [
      {
        "label": "Males",
        "value": "0"
      },
      {
        "label": "Females",
        "value": "0"
      },
      {
        "label": "Other",
        "value": "0"
      }
    ]

    $scope.updateGenderData = function(){
      // Males
      $scope.genderData[0].value = ""+$scope.males.length+"";
      // Females
      $scope.genderData[1].value = ""+$scope.females.length+"";
      // Others
      $scope.genderData[2].value = ""+$scope.others.length+"";
    }


    $scope.countryDataSet = {
      "chart": {
        "caption": "Countries Represented by Attendees",
        "showBorder": "0",
        "use3DLighting": "1",
        "enableSmartLabels": "1",
        "startingAngle": "45",
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
      "data": $scope.countryData
    }

    $scope.genderDataSet = {
      "chart": {
        "caption": "Conference Gender Distribution",
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
      "data": $scope.genderData
    }

    $scope.eventDataSet = {
      "chart": {
        "caption": "Events Attendee Count",
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
      "data": $scope.eventData
    }

  })
