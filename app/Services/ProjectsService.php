<?php

namespace App\Services;
use App\Models\Projects;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProjectsService.
 */
class ProjectsService
{
    public function getProjects()
    {
        $projects = Projects::all();

        return $projects;
    }

    private function storeImage($image)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('images/projects', $imageName, 'public');

        return $imagePath;
    }


    public function storeProject(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->storeImage($data['image']);
        }

        Projects::create($data);
    }

    public function getProjectById($id)
    {
        $project = Projects::findOrFail($id);

        return $project;
    }

    private function updateImage(Projects $project, $image = null)
    {
        if ($image && $image->isValid()) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/images/projects', $imageName);

            if ($project->image) {
                Storage::delete('public/' . $project->image);
            }

            $project->image = str_replace('public/', '', $imagePath);
        }
    }

    public function updateProject(Projects $project, array $data)
    {
        $project->title = $data['title'] ?? $project->title;

        $this->updateImage($project, $data['image'] ?? null);

        $project->description = $data['description'] ?? $project->description;
        $project->githublink = $data['githublink'] ?? $project->weblink;
        $project->weblink = $data['weblink'] ?? $project->weblink;


        $project->save();

        return $project;
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            Storage::delete('public/' . $imagePath);
        }
    }

    public function deleteProject(Projects $project)
    {
        $this->deleteImage($project->image);

        $project->delete();
    }
}
