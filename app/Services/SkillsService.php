<?php

namespace App\Services;

use App\Models\Skills;
use Illuminate\Support\Facades\Storage;

/**
 * Class SkillsService.
 */
class SkillsService
{
    public function getSkills()
    {
        $skills = Skills::select(['id', 'skill', 'description', 'image'])->orderBy('id', 'DESC')->get();

        return $skills;
    }

    private function storeImage($image)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('images/skills', $imageName, 'public');

        return $imagePath;
    }

    public function storeSkill(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->storeImage($data['image']);
        }

        Skills::create($data);
    }

    public function getSkillById($id)
    {
        $skill = Skills::findOrFail($id);

        return $skill;
    }

    private function updateImage(Skills $skill, $image = null)
    {
        if ($image && $image->isValid()) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/images/skills', $imageName);

            if ($skill->image) {
                Storage::delete('public/' . $skill->image);
            }

            $skill->image = str_replace('public/', '', $imagePath);
        }
    }

    public function updateSkill(Skills $skill, array $data)
    {
        $skill->skill = $data['skill'] ?? $skill->skill;
        $skill->description = $data['description'] ?? $skill->description;

        $this->updateImage($skill, $data['image'] ?? null);

        $skill->save();

        return $skill;
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            Storage::delete('public/' . $imagePath);
        }
    }

    public function deleteSkill(Skills $skill)
    {
        $this->deleteImage($skill->image);

        $skill->delete();
    }
}
