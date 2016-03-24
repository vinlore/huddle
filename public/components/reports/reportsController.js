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

})
