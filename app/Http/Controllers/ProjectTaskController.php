<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    /**
     * @var ProjectTaskRepository
     */
    private $repository;

    /**
     * @var ProjectTaskService
     */
    private $service;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
    {
        $this->repository = $repository;
        $this->service = $service;

        $this->middleware('CheckProjectPermissions');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        return $this->repository->findWhere(['project_id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        try {
            return $this->service->create($request->all());
        } catch(\Exception $e) {
            return [ 'error' => true, 'message' => 'Ocorreu algum erro ao salvar a tarefa do projeto.' ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $projectId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($projectId, $id) {
        try {
            return $this->repository
                ->with('project')
                ->findWhere(['project_id' => $projectId, 'id' => $id]);
        } catch(ModelNotFoundException $e) {
            return [ 'error' => true, 'message' => 'Tarefa do projeto não encontrada.' ];
        } catch(\Exception $e) {
            return [ 'error' => true, 'message' => 'Ocorreu algum erro ao exibir a tarefa do projeto.' ];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $projectId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $projectId, $id) {
        try {
            return $this->service->update($request->all(), $id);
        } catch(ModelNotFoundException $e) {
            return [ 'error' => true, 'message' => 'Tarefa do projeto não encontrada.' ];
        } catch(\Exception $e) {
            return [ 'error' => true, 'message' => 'Ocorreu algum erro ao atualizar a tarefa do projeto.' ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $projectId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($projectId, $id) {
        try {
            $this->repository->delete($id);
            return [ 'error' => false, 'message' => 'Tarefa do projeto deletada com sucesso.' ];
        } catch(ModelNotFoundException $e) {
            return [ 'error' => true, 'message' => 'Tarefa do projeto não encontrada.' ];
        } catch(\Exception $e) {
            return [ 'error' => true, 'message' => 'Ocorreu algum erro ao deletar a tarefa do projeto.' ];
        }
    }
}