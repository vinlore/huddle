angular.module( 'customDirs', [] )
.directive( 'ngVisible', function() {
    return function( scope, elm, attr ) {
        scope.$watch( attr.ngVisible, function( visible ) {
            elm[visible ? 'removeClass' : 'addClass']('invisible');;
        });
    };
})

.directive('errSrc', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            element[0].onerror = function () {
                element[0].className = element[0].className + " image-error";
                element[0].removeAttribute('ng-src');
                element[0].removeAttribute('src');
            };
        }
    }
})