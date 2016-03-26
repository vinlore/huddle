<html lang="en" ng-app="cms" class="no-js">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Huddle</title>
  <base href="/"> <!-- Gets rid of /#/ in URL -->
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS -->
  <link rel="stylesheet" href="assets/libs/bootstrap-css-only/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/app.css">
  <link rel="stylesheet" href="components/home/home.css">
  <link rel="stylesheet" href="components/admin/admin.css">
  <link rel="stylesheet" href="components/conference/conference.css">
  <link rel="stylesheet" href="components/login/login.css">
  <link rel="stylesheet" href="assets/libs/angular-google-places-autocomplete/dist/autocomplete.min.css">
  <link rel="stylesheet" href="components/createConference/createConference.css">
  <link rel="stylesheet" href="components/userReg/userReg.css">
  <link rel="stylesheet" href="shared/header/header.css">
  <link rel="stylesheet" href="shared/popup/popup.css">
  <link rel="stylesheet" href="components/profile/profile.css">
  <link rel="stylesheet" href="components/signupConference/signupConference.css">
  <link rel="stylesheet" href="components/signupEvent/signupEvent.css">
  <link rel="stylesheet" href="components/manageAccommodations/manageAccommodations.css">
  <link rel="stylesheet" href="components/manageInventory/manageInventory.css">
  <link rel="stylesheet" href="components/manageRooms/manageRooms.css">
  <link rel="stylesheet" href="components/manageTransportation/manageTransportation.css">
  <link rel="stylesheet" href="components/manageRequests/manageRequests.css">
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="components/manageAccounts/manageAccounts.css">
  <link rel="stylesheet" href="assets/libs/ng-table/dist/ng-table.min.css">
  <link rel="stylesheet" href="components/reports/reports.css">
  <link rel="stylesheet" href="assets/css/angular-timeline.css"/>
  <link rel="stylesheet" href="components/activityLog/activityLog.css">
  <link rel="stylesheet" href="components/manageAttendees/manageAttendees.css">
  <link rel="stylesheet" href="components/createEvent/createEvent.css">

  <!-- LIBRARIES -->
  <script src="assets/libs/angular/angular.min.js"></script>
  <script src="assets/libs/angular-ui-router/release/angular-ui-router.min.js"></script>
  <script src="assets/libs/angular-animate/angular-animate.min.js"></script>
  <script src="assets/libs/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
  <script src="assets/libs/angular-resource/angular-resource.min.js"></script>
  <script src="assets/libs/satellizer/satellizer.min.js"></script>
  <script src="assets/libs/angular-google-places-autocomplete/dist/autocomplete.min.js"></script>
  <script src="assets/libs/ng-table/dist/ng-table.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1Pmv3HdlO7MufSCHtByXYIfiuRzhc1mg&libraries=places"></script>
  <script type="text/javascript" src="assets/js/fusioncharts/fusioncharts.js"></script>
  <script type="text/javascript" src="assets/js/fusioncharts/angular-fusioncharts.min.js"></script>
  <script text="text/javascript" src="assets/libs/ngstorage/ngStorage.min.js"></script>
  <script text="text/javascript" src="assets/libs/ngmap/build/scripts/ng-map.min.js"></script>
  <script type="text/javascript" src="assets/libs/ng-table/dist/ng-table.min.js"></script>
  <script text="text/javascript" src="assets/libs/angular-timeline/dist/angular-timeline.js"></script>
  <script text="text/javascript" src="assets/libs/angular-ui-mask/dist/mask.min.js"></script>

  <!-- CONTROLLERS -->
  <script src="components/home/homeController.js"></script>
  <script src="components/admin/adminController.js"></script>
  <script src="components/userReg/userRegController.js"></script>
  <script src="components/conference/conferenceController.js"></script>
  <script src="components/login/loginController.js"></script>
  <script src="components/createConference/createConferenceController.js"></script>
  <script src="components/profile/profileController.js"></script>
  <script src="components/activityLog/activityLogController.js"></script>
  <script src="shared/header/headerController.js"></script>
  <script src="shared/popup/popupController.js"></script>
  <script src="components/manageAccounts/manageAccountsController.js"></script>
  <script src="components/signupConference/signupConferenceController.js"></script>
  <script src="components/signupEvent/signupEventController.js"></script>
  <script src="components/manageAccommodations/manageAccommodationsController.js"></script>
  <script src="components/manageInventory/manageInventoryController.js"></script>
  <script src="components/manageRooms/manageRoomsController.js"></script>
  <script src="components/manageTransportation/manageTransportationController.js"></script>
  <script src="components/manageRequests/manageRequestsController.js"></script>
  <script src="components/manageManagers/manageManagersController.js"></script>
  <script src="components/reports/reportsController.js"></script>
  <script src="components/manageAttendees/manageAttendeesController.js"></script>
  <script src="components/createEvent/createEventController.js"></script>

  <!-- SERVICES -->
  <script src="assets/js/mapService.js"></script>
  <script src="assets/js/countryService.js"></script>
  <script src="assets/js/apiService.js"></script>
  <script src="assets/js/popupServices.js"></script>
  <script src="assets/js/permissionService.js"></script>

  <!-- DIRECTIVES -->
  <script src="assets/js/customDirectives.js"></script>
  <script src="assets/js/validateDirectives.js"></script>

  <!-- FILTERS -->
  <script src="assets/js/customFilters.js"></script>

  <!-- APP.JS -->
  <script src="app.js"></script>
</head>

<body>
  <div ng-include="'shared/header/header.html'" ng-controller="headerController"></div>
  <uib-alert id="popup-alert" ng-repeat="alert in alerts" type="{{alert.type}}" dismiss-on-timeout="2500" close="alerts.splice(index, 1)" class="alert-fade">{{alert.msg}}</uib-alert>
  <div ui-view autoscroll class="has-header"></div>
</body>

</html>
