'use strict';

/* Controllers */

angular.module('myApp.controllers', ['ngTable', 'geolocation']).
controller('AgentListController', [
    '$scope', '$location', '$filter', 'Agents', 'Cookie', 'ngTableParams', 'geolocation', 'UserInfo',
    function($scope, $location, $filter, Agents, Cookie, ngTableParams, geolocation, UserInfo) {    

        var data = [];

        // Query the first data
        Agents.query(null, function(data){
            // SUCCESS
            $scope.data = data;
            $scope.agentsTable.reload();
        }, function(){
            // ERROR
            console.log('error');
            console.log(arguments);
        });

        // Setup table
        $scope.agentsTable = new ngTableParams({
            page: 1,
            count: 10,
            ordering: {
                'created_at': 'desc'
            }
        }, {
            total: data.length,
            getData: function($defer, params){
                var data = $scope.data;
                // use build-in angular filter
                var filteredData = params.filter() ?
                        $filter('filter')(data, params.filter()) :
                        data;
                var orderedData = params.sorting() ?
                        $filter('orderBy')(filteredData, params.orderBy()) :
                        filteredData;
                params.total(orderedData.length); // set total for recalc pagination
                $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
            }
        });

        $scope.data = data;

        // Handle row click
        $scope.onAgentClick = function(agent){
            if(agent){
                var url = '/agent/' + agent.id;
                // Clear url params
                $location.path(url).replace();
                try{
                    $scope.$apply();
                }catch(exception){
                    // Apply alread in progress...
                }
            } else {
                console.log('No agent selected');
            }
        };

        // Handle Stop bother me click
        $scope.stopBotherClick = function(){
            Cookie.query();
        };

        // Handle Filter clear
        $scope.clearFilters = function(){
            
        };

        // Handle add agent
        $scope.addAgent = function(){
            Agents.save(
            {
                userAgent: new UAParser($scope.userAgent).getResult(),
                ipAddress: $scope.ipAddress,
                'screen': $scope.screen,
                isMobile: $scope.isMobile,
                isDesktop: $scope.isDesktop,
                isCrawler: $scope.isCrawler,
                country: $scope.country,
                'coords': $scope.coords,
                plugins: $scope.plugins
            },
            function(data){
                // Bugfix for hiding bootstrap modal...
                $('#promptForAgent').modal('toggle');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();  
                // Finally push agent to list, reload table and go to agents page
                if(data.agent){
                    $scope.data.push(data.agent);
                    $scope.agentsTable.reload();
                    $scope.onAgentClick({id: data.agentId});
                }
            });
        };

        // Get User Info
        UserInfo.query(null, function(userData){
            $scope.userAgent = userData.userAgentString;
            $scope.ipAddress = userData.ipAddress;
            $scope.registered = userData.registered;
            $scope.country = userData.country;
            // may be overrided by geolocation API
            $scope.coords = {
                lat: userData.latitude.toString(),
                long: userData.longitude.toString()
            };
            // Javascript detection...
            $scope.screen = {
                width: screen.width.toString(),
                height: screen.height.toString()
            };
            // Smart mobile detection...
            $scope.isMobile = WURFL.is_mobile? true : false;
            $scope.isDesktop = WURFL.form_factor == 'Desktop';
            $scope.isCrawler = false;
            $scope.Devicename = WURFL.device_name || '-';
            $scope.formFactor = WURFL.form_factor || '-';
            // Plugin detection
            $scope.plugins = {
                flash_enabled : pluginlist.indexOf("Flash") != -1? true: false,
                wmp_enabled : pluginlist.indexOf("Windows Media Player") != -1? true: false,
                java_enabled : pluginlist.indexOf("Java") != -1? true : false,
                shockwave_enabled : pluginlist.indexOf("Shockwave") != -1? true : false,
                real_player_enabled : pluginlist.indexOf("RealPlayer") != -1? true : false,
                quicktime_enabled : pluginlist.indexOf("QuickTime") != -1? true : false,
                acrobat_reader_enabled : pluginlist.indexOf("Acrobat Reader") != -1? true : false,
                svg_enabled : pluginlist.indexOf("SVG Viewer") != -1? true : false
            }
            // Location
            geolocation.getLocation().then(function(data){
              $scope.coords = {lat:data.coords.latitude, long:data.coords.longitude};
            });

            // Modal
            if(!userData.registered || userData.registered == null || userData.registered == 0 || userData.registered == '0'){
                $('#promptForAgent').modal('show');
            }

        });

    }])
.controller('AgentDetailController', ['$scope', '$routeParams', 'Agent', function($scope, $routeParams, Agent) {
        // Load Agents with secured connection
        $scope.agent = Agent.query({'id': $routeParams.agentId});
        $scope.agentId = $routeParams.agentId;
    }])
.controller('ReportController', ['$scope', 'Report', function($scope, Report) {
        // Load Agents with secured connection
    
        Report.query(null, function(reportData){
            // BUGFIX for resource return
            reportData = reportData[0];

            /* PARSE DATA FOR DESKTOP MULTI LEVEL CHART */
            var colors = Highcharts.getOptions().colors,
                browserData = [],
                versionsData = [],
                name = 'Browsers';
            var _i = 0,
                _j = 0,
                _totalShare = 0,
                __browser = {};
            angular.forEach(reportData, function(browser, key){
                _totalShare = 0;
                // BROWSER_NAME
                __browser = {
                    name: key, y: 0, color: colors[_i]};

                // BROWSER_VERSION
                _j = 0;
                angular.forEach(browser, function(version, versionKey){
                    var _share = parseInt(version),
                        _name = (key + ' ' + versionKey),
                        _brightness = (0.2 - ((_j / Object.keys(this).length) / 5)),
                        __version = {
                            name: _name,
                            y: _share,
                            color: Highcharts.Color(colors[_i]).brighten(_brightness).get()
                        };
                    //
                    versionsData.push(__version);
                    _totalShare += _share;
                    _j++;
                }, browser);
                // Total share
                __browser.y = _totalShare;
                // Finally
                browserData.push(__browser);
                _i++;
            });

            // Render Desktop Chart
            renderDesktopChart('#desktopChart', browserData, versionsData);

            /* PARSE/RENDER MOBILE CHARTS */
            // yes I can use the previous loop to get both information but on this case lets use 2 loops
            // to show the proccess
            angular.forEach(reportData, function(browser, key){
                $('.mobile-charts').append(
                    '<div id="' + key + 'mobileChart" class="visible-xs" style="min-width: 200px; height: 300px; margin: 0 auto"></div>');
                
                var _versionData = [];
                angular.forEach(browser, function(version, versionKey){
                    _versionData.push([
                        versionKey,
                        parseInt(version)
                    ]);
                });

                renderMobileChart('#' + key + 'mobileChart', key, _versionData);
            });

        });


    }]);