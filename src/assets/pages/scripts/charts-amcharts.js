var ChartsAmcharts = function() {
    var initChartSample1 = function() {
        var chart = AmCharts.makeChart("chart_1", {
            "type": "serial",
            "theme": "light",
            "fontFamily": 'Open Sans',            
            "color":    '#888',
            
            "legend": {
                "equalWidths": true,
                "useGraphSettings": true,
                "valueAlign": "left",
                "valueWidth": 100
            },
            "dataProvider": [{
                "bln": "Jan",
                "aju": 48,
                "apv": 18,
                "rjt": 30,
            }, {
                "bln": "Feb",
                "aju": 36,
                "apv": 26,
                "rjt": 10,
            }, {
                "bln": "Mar",
                "aju": 30,
                "apv": 11,
                "rjt": 19,
            }, {
                "bln": "Apr",
                "aju": 39,
                "apv": 11,
                "rjt": 28,
            }, {
                "bln": "Mei",
                "aju": 44,
                "apv": 11,
                "rjt": 33,
            }, {
                "bln": "Jun",
                "aju": 34,
                "apv": 19,
                "rjt": 15,
            }, {
                "bln": "Jul",
                "aju": 23,
                "apv": 13,
                "rjt": 10,
            }, {
                "bln": "Agu",
                "aju": 56,
                "apv": 33,
                "rjt": 23,
            }, {
                "bln": "Sep",
                "aju": 30,
                "apv": 11,
                "rjt": 19,
            }, {
                "bln": "Okt",
                
            }, {
                "bln": "Nov",
                
            }, {
                "bln": "Des",
                
            }],
            "valueAxes": [{
                "stackType": "regular",
                "axisAlpha": 0,
                "position": "left",
                "title": "Jumlah",
            }],
            "startDuration": 0.5,
            "graphs": [{
                "alphaField": "alpha",
                "balloonText": "<span style='font-size:13px;'>[[title]] bulan [[category]]:<b>[[value]]</b> [[additional]]</span>",
                "dashLengthField": "dashLengthColumn",
                "labelText": "[[value]]",
                "color": "#FFFFFF",
                "fillAlphas": 0.9,
                "title": "Pengajuan Kredit",
                "fillColors":"#32c5d2",
                "lineColor":"#32c5d2",
                "type": "column",
                "valueField": "aju"
            }, {
                "alphaField": "alpha",
                "balloonText": "<span style='font-size:13px;'>[[title]] bulan [[category]]:<b>[[value]]</b> [[additional]]</span>",
                "dashLengthField": "dashLengthColumn",
                "labelText": "[[value]]",
                "color": "#000000",
                "fillAlphas": 0.9,
                "title": "Kredit Diterima",
                "fillColors":"#5aff00",
                "lineColor":"#5aff00",
                "type": "column",
                "newStack": true,
                "valueField": "apv"
            }, {
                "alphaField": "alpha",
                "balloonText": "<span style='font-size:13px;'>[[title]] bulan [[category]]:<b>[[value]]</b> [[additional]]</span>",
                "dashLengthField": "dashLengthColumn",
                "labelText": "[[value]]",
                "color": "#000000",
                "fillAlphas": 0.5,
                "title": "Kredit Ditolak",
                "fillColors":"#555555",
                "lineColor":"#555555",
                "type": "column",
                "valueField": "rjt"
            }],
            "chartCursor": {
                "categoryBalloonblnFormat": "DD",
                "cursorAlpha": 0.1,
                "cursorColor": "#000000",
                "fullWidth": true,
                "valueBalloonsEnabled": false,
                "zoomable": false
            },
            "categoryField": "bln",
            "categoryAxis": {
                "axisColor": "#555555",
                "gridAlpha": 0.1,
                "gridColor": "#FFFFFF",
            },
            "export": {
                "enabled": true,  
                "menu": [ {
                    "class": "export-main",
                    "menu": [ {
                    "label": "Download as image",
                    "menu": [ "PNG", "JPG", "SVG" ]
                    }]
                }]
            }
        });

        $('#chart_1').closest('.portlet').find('.fullscreen').click(function() {
            chart.invaliblnSize();
        });
    }

    var initChartSample2 = function() {
        var chart = AmCharts.makeChart("chart_2", {
            "type": "serial",
            "theme": "light",
            "fontFamily": 'Open Sans',
            "color":    '#888888',

            "legend": {
                "equalWidths": false,
                "useGraphSettings": true,
                "valueAlign": "left",
            },
            "dataProvider": [{
                "bln": "Jan",
                "cbg1": 52,
                "cbg2": 71,
                "cbg3": 47,
                "cbg4": 41,
            }, {
                "bln": "Feb",
                "cbg1": 75,
                "cbg2": 64.5,
                "cbg3": 58.5,
                "cbg4": 71,
            }, {
                "bln": "Mar",
                "cbg1": 43,
                "cbg2": 72,
                "cbg3": 34,
                "cbg4": 48,
            }, {
                "bln": "Apr",
                "cbg1": 34,
                "cbg2": 41,
                "cbg3": 30,
                "cbg4": 55,
            }, {
                "bln": "Mei",
                "cbg1": 48,
                "cbg2": 35,
                "cbg3": 45,
                "cbg4": 83,
            }, {
                "bln": "Jun",
                "cbg1": 78,
                "cbg2": 37,
                "cbg3": 34,
                "cbg4": 38,
            }, {
                "bln": "Jul",
                "cbg1": 34,
                "cbg2": 30,
                "cbg3": 49,
                "cbg4": 48,
            }, {
                "bln": "Agu",
                "cbg1": 63,
                "cbg2": 86,
                "cbg3": 100,
                "cbg4": 68,
            }, {
                "bln": "Sep",
                "cbg1": 45,
                "cbg2": 49.5,
                "cbg3": 39,
                "cbg4": 75,
            }, {
                "bln": "Okt",
                
            }, {
                "bln": "Nov",
                
            }, {
                "bln": "Des",
                
            }],
            "valueAxes": [{
                "stackType": "regular",
                "axisAlpha": 0,
                "position": "left",
                "title": "Jumlah Pencairan",
                "unit": "jt",
            }],
            "startDuration": 0.5,
            "graphs": [{
                "alphaField": "alpha",
                "balloonText": "<span style='font-size:13px;'>[[title]] bulan [[category]]: <b>[[value]]</b> jt</span>",
                "dashLengthField": "dashLengthColumn",
                "labelText": "[[value]]",
                "color": "#FFFFFF",
                "fillAlphas": 0.8,
                "title": "Cabang Buahbatu",
                "type": "column",
                "valueField": "cbg1"
            }, {
                "alphaField": "alpha",
                "balloonText": "<span style='font-size:13px;'>[[title]] bulan [[category]]: <b>[[value]]</b> jt</span>",
                "dashLengthField": "dashLengthColumn",
                "labelText": "[[value]]",
                "color": "#FFFFFF",
                "fillAlphas": 0.8,
                "title": "Cabang Ujung Berung",
                "type": "column",
                "valueField": "cbg2"
            }, {
                "alphaField": "alpha",
                "balloonText": "<span style='font-size:13px;'>[[title]] bulan [[category]]: <b>[[value]]</b> jt</span>",
                "dashLengthField": "dashLengthColumn",
                "labelText": "[[value]]",
                "color": "#FFFFFF",
                "fillAlphas": 0.8,
                "title": "Cabang Astana Anyar",
                "type": "column",
                "valueField": "cbg3"
            }, {
                "alphaField": "alpha",
                "balloonText": "<span style='font-size:13px;'>[[title]] bulan [[category]]: <b>[[value]]</b> jt</span>",
                "dashLengthField": "dashLengthColumn",
                "labelText": "[[value]]",
                "color": "#FFFFFF",
                "fillAlphas": 0.8,
                "title": "Cabang Setiabudi",
                "type": "column",
                "valueField": "cbg4"
            }],
            "chartCursor": {
                "categoryBalloonblnFormat": "DD",
                "cursorAlpha": 0.1,
                "cursorColor": "#000000",
                "fullWidth": true,
                "valueBalloonsEnabled": false,
                "zoomable": false
            },
            "categoryField": "bln",
            "categoryAxis": {
                "axisColor": "#555555",
                "gridAlpha": 0.1,
                "gridColor": "#FFFFFF",
            },
            "export": {
                "enabled": true,  
                "menu": [ {
                    "class": "export-main",
                    "menu": [ {
                    "label": "Download as image",
                    "menu": [ "PNG", "JPG", "SVG" ]
                    }]
                }]
            }
        });

        $('#chart_2').closest('.portlet').find('.fullscreen').click(function() {
            chart.invaliblnSize();
        });
    }

    var initChartSample3 = function() {
        var chart = AmCharts.makeChart("chart_3", {
            "type": "pie",
            "theme": "light",

            "fontFamily": 'Open Sans',
            "color":    '#888',

            "dataProvider": [{
                "jenis": "Buahbaru",
                "jumlah": 24
            }, {
                "jenis": "Ujung Berung",
                "jumlah": 15
            }, {
                "jenis": "Astana Anyar",
                "jumlah": 36
            }, {
                "jenis": "Setiabudi",
                "jumlah": 19
            }],
            "valueField": "jumlah",
            "titleField": "jenis"
        });

        $('#chart_6').closest('.portlet').find('.fullscreen').click(function() {
            chart.invalidateSize();
        });
    }

    return {
        init: function() {
            initChartSample1();
            initChartSample2();
            initChartSample3();
        }
    };

}();

jQuery(document).ready(function() {    
   ChartsAmcharts.init(); 
});