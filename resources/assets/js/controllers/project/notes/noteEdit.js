angular.module('app.controllers')
    .controller('ProjectNotesEditController',
        ['$scope', 'ProjectNote', '$routeParams', '$location',
            function ($scope, ProjectNote, $routeParams, $location) {
                $scope.note = new ProjectNote.get({id: $routeParams.id, idNote: $routeParams.idNote});

                $scope.save = function () {
                    if ($scope.form.$valid) {
                        $scope.note.project_id = $routeParams.id;
                        ProjectNote.update(
                            {id: $routeParams.id,idNote: $scope.note.id},
                            $scope.note, function () {
                            $location.path('/project/' + $routeParams.id + '/notes');
                        });
                    }
                }
            }]);