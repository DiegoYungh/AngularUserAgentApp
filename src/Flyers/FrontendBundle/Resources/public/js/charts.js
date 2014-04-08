function renderDesktopChart(target, browserData, versionsData){
	$(target).highcharts({
	    chart: {
	        type: 'pie'
	    },
	    title: {
	        text: 'User Agents - Browser/Version'
	    },
	    yAxis: {
	        title: {
	            text: ''
	        }
	    },
	    plotOptions: {
	        pie: {
	            shadow: false,
	            center: ['50%', '50%']
	        }
	    },
	    tooltip: {
	        valueSuffix: ''
	    },
	    series: [{
	        name: 'Browsers',
	        data: browserData,
	        size: '60%',
	        dataLabels: {
	            formatter: function() {
	                return this.y > 5 ? this.point.name : null;
	            },
	            color: 'white',
	            distance: -30
	        }
	    }, {
	        name: 'Versions',
	        data: versionsData,
	        size: '80%',
	        innerSize: '60%',
	        dataLabels: {
	            formatter: function() {
	                // display only if larger than 1
	                return this.y > 1 ? '<b>'+ this.point.name +':</b> '+ this.y  : null;
	            }
	        }
	    }]
	});
}

function renderMobileChart(target, browser_name, versionsData){
	$(target).highcharts({
	    chart: {
	        plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
	    },
	    title: {
	        text: browser_name + '/Version'
	    },
	    yAxis: {
	        title: {
	            text: ''
	        }
	    },
	    plotOptions: {
	        pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                },
                showInLegend: true
            }
	    },
	    tooltip: {
	        valueSuffix: ''
	    },
	    series: [{
            type: 'pie',
            name: 'Users',
            data: versionsData
        }]
	});
}