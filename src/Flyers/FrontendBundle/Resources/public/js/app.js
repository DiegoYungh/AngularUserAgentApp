'use strict';


// Declare app level module which depends on filters, and services
angular.module('myApp', ['myApp.filters', 'myApp.services', 'myApp.directives', 'myApp.controllers', 'ngTable', 'geolocation']).
  config(['$routeProvider', function($routeProvider) {
    $routeProvider.when('/reports', {templateUrl: '/bundles/frontend/partials/reports.html', controller: 'ReportController'});
    $routeProvider.when('/agents', {templateUrl: '/bundles/frontend/partials/agents.html', controller: 'AgentListController'});
    $routeProvider.when('/agent/:agentId', {templateUrl: '/bundles/frontend/partials/agent.html', controller: 'AgentDetailController'});
    $routeProvider.otherwise({redirectTo: '/agents'});
  }]);
