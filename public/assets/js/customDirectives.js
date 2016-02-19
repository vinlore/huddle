angular.module( 'customDirs', [] )
.directive( 'ngVisible', function () {
    return function ( scope, elm, attr ) {
        scope.$watch( attr.ngVisible, function ( visible ) {
            elm[visible ? 'removeClass' : 'addClass']('invisible');;
        });
    };
})