<?php

namespace App\Services;

use App\Models\Hero;

/**
 * Class HeroService.
 */
class HeroService
{
    public function getHeroes()
    {
        $heroes = Hero::with('skill')->orderby('id', 'desc')->get();

        return $heroes;
    }

    public function storeHero(array $data)
    {
        Hero::create($data);
    }

    public function getHeroById($id)
    {
        $hero = Hero::findOrFail($id);

        return $hero;
    }

    public function updateHero(Hero $hero, array $data)
    {
        $hero->title = $data['title'] ?? $hero->title;
        $hero->description = $data['description'] ?? $hero->description;
        $hero->about = $data['about'] ?? $hero->about;

        $hero->save();

        return $hero;
    }

    public function deleteHero(Hero $hero)
    {
        $hero->delete();
    }
}
