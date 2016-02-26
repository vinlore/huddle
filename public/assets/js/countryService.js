angular.module( 'countryService', [] )
.factory( 'Countries' , function( $resource ) {
    
    var countries = $resource( 'assets/js/countries.json' ).query();
    return countries;

})