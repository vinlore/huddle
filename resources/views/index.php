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
  <link rel="stylesheet" href="assets/css/header.css">
  <link rel="stylesheet" href="components/home/home.css">
  <link rel="stylesheet" href="components/admin/admin.css">
  <link rel="stylesheet" href="components/conference/conference.css">
  <link rel="stylesheet" href="components/login/login.css">
  <link rel="stylesheet" href="assets/libs/angular-google-places-autocomplete/dist/autocomplete.min.css">
  <link rel="stylesheet" href="components/createConference/createConference.css">
  <link rel="stylesheet" href="components/userReg/userReg.css">
  <link rel="stylesheet" href="shared/header/header.css">
  <link rel="stylesheet" href="components/profile/profile.css">
  <link rel="stylesheet" href="components/signupConference/signupConference.css">
  <link rel="stylesheet" href="components/signupEvent/signupEvent.css">

  <!-- LIBRARIES -->
  <script src="assets/libs/angular/angular.min.js"></script>
  <script src="assets/libs/angular-route/angular-route.min.js"></script>
  <script src="assets/libs/angular-animate/angular-animate.min.js"></script>
  <script src="assets/libs/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
  <script src="assets/libs/angular-resource/angular-resource.min.js"></script>
  <script src="assets/libs/satellizer/satellizer.min.js"></script>
  <script src="assets/libs/angular-google-places-autocomplete/dist/autocomplete.min.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1Pmv3HdlO7MufSCHtByXYIfiuRzhc1mg&libraries=places"></script>

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
  <script src="shared/popupPrompt/popupPromptController.js"></script>
  <script src="components/manageAccounts/manageAccountsController.js"></script>
  <script src="components/signupConference/signupConferenceController.js"></script>
  <script src="components/signupEvent/signupEventController.js"></script>

  <!-- SERVICES -->
  <script src="assets/js/conferenceService.js"></script>
  <script src="assets/js/eventService.js"></script>
  <script src="assets/js/mapService.js"></script>
  <script src="assets/js/countryService.js"></script>
  <script src="assets/js/apiService.js"></script>

  <!-- DIRECTIVES -->
  <script src="assets/js/customDirectives.js"></script>

  <!-- FILTERS -->
  <script src="assets/js/customFilters.js"></script>

  <!-- APP.JS -->
  <script src="app.js"></script>
</head>

<body>
  <div ng-include="'shared/header/header.html'" ng-controller="headerController"></div>
  <div class="has-header" ng-view autoscroll></div>
</body>

</html>
