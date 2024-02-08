<?php

namespace App\Http\Controllers;

use App\Models\Skills;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    public function index()
    {
        $skill = Skills::all();

        return view('imageview', compact('skill'));
    }
}
