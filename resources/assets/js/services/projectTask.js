angular.module('app.services')
    .service('ProjectTask', ['$resource', 'appConfig', function($resource, appConfig) {
        return $resource(appConfig.baseUrl + '/project/:id/task/:idTask', {
            id: '@id',
            idTask: '@idTask'
        }, {
            update: {
                method: 'PUT'
            },
            get: {
                method: 'GET',
                transformResponse: function(data, headers) {
                    var o = appConfig.utils.transformResponse(data, headers);
                    if (angular.isObject(o) && o.hasOwnProperty('due_date') && o.due_date != null) {
                        var arrayDate = o.due_date.split('-'),
                            month = parseInt(arrayDate[1]) - 1;
                        o.due_date = new Date(arrayDate[0], month, arrayDate[2]);
                    } 
                    if (angular.isObject(o) && o.hasOwnProperty('start_date') && o.due_date != null) {
                        var arrayDate = o.start_date.split('-'),
                            month = parseInt(arrayDate[1]) - 1;
                        o.start_date = new Date(arrayDate[0], month, arrayDate[2]);
                    }
                    return o;
                }
            }
        });
    }])
