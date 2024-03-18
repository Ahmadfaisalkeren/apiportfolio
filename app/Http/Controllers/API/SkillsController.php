<?php

namespace App\Http\Controllers\API;

use App\Models\Skills;
use Illuminate\Http\Request;
use App\Services\SkillsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Skills\SkillStoreRequest;
use App\Http\Requests\Skills\SkillUpdateRequest;

class SkillsController extends Controller
{
    protected $skillService;

    public function __construct(SkillsService $skillService)
    {
        $this->skillService = $skillService;
    }

    public function index()
    {
        $skills = $this->skillService->getSkills();

        return response()->json([
            'message' => 'Skills Fetched Successfully',
            'skills' => $skills,
        ]);
    }

    public function store(SkillStoreRequest $request)
    {
        $this->skillService->storeSkill($request->validated());

        return response()->json(
            [
                'status' => 200,
                'message' => 'Skill Created Successfully',
            ],
            200,
        );
    }

    public function edit($id)
    {
        $skill = Skills::findOrFail($id);

        return response()->json(
            [
                'skill' => $skill,
                'status' => 200,
                'message' => 'Skill Fetched Successfully',
            ],
            200,
        );
    }

    public function update(SkillUpdateRequest $request, $id)
    {
        $skill = Skills::findOrFail($id);

        $this->skillService->updateSkill($skill, $request->validated());

        return response()->json(
            [
                'message' => 'Skill Updated Successfully',
                'status' => 200,
                'skill' => $skill,
            ],
            200,
        );
    }

    public function destroy($id)
    {
        $skill = Skills::findOrFail($id);
        $this->skillService->deleteSkill($skill);

        return response()->json(
            [
                'status' => 200,
                'message' => 'Skill Deleted Successfully',
            ],
            200,
        );
    }
}
