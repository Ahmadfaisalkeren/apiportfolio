<?php

namespace App\Http\Controllers\API;

use App\Models\Projects;
use App\Services\ProjectsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\ProjectStoreRequest;
use App\Http\Requests\Projects\ProjectUpdateRequest;

class ProjectsController extends Controller
{
    protected $projectService;

    public function __construct(ProjectsService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        $projects = $this->projectService->getProjects();

        return response()->json([
            'message' => 'Projects Fetched Successfully',
            'projects' => $projects,
        ]);
    }

    public function store(ProjectStoreRequest $request)
    {
        $this->projectService->storeProject($request->validated());

        return response()->json(
            [
                'status' => 200,
                'message' => 'Project Created Successfully',
            ],
            200,
        );
    }

    public function edit($id)
    {
        $project = Projects::findOrFail($id);

        return response()->json(
            [
                'project' => $project,
                'status' => 200,
                'message' => 'Project Fetched Successfully',
            ],
            200,
        );
    }

    public function update(ProjectUpdateRequest $request, $id)
    {
        $project = Projects::findOrFail($id);

        $this->projectService->updateProject($project, $request->validated());

        return response()->json(
            [
                'message' => 'Project Updated Successfully',
                'status' => 200,
                'project' => $project,
            ],
            200,
        );
    }

    public function destroy($id)
    {
        $project = Projects::findOrFail($id);
        $this->projectService->deleteProject($project);

        return response()->json(
            [
                'status' => 200,
                'message' => 'Project Deleted Successfully',
            ],
            200,
        );
    }
}
