angular.module('app.services')
    .service('ProjectTask', ['$resource', 'appConfig', function($resource, appConfig) {
        return $resource(appConfig.baseUrl + '/project/:id/task/:idTask', {
            id: '@id',
            idTask: '@idTask'
        }, {
            update: {
                method: 'PUT'
            }
        });
    }])
