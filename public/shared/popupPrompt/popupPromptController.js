angular.module('popupPromptCtrl', [])
.controller('popupPromptController', function( $scope, $uibModalInstance, content ) {
	
	$scope.content = content;

	$scope.ok = function () {
		$uibModalInstance.close( true );
	};

	$scope.cancel = function () {
		$uibModalInstance.close( false );
	};

})