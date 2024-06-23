<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Skill Route
Route::get('admin/skills',[SkillController::class,'Index'])->name('skills.index');
Route::get('admin/skill/create', [SkillController::class, 'SkillCreate'])->name('skill.create');
Route::post('admin/skill/store', [SkillController::class, 'SkillStore'])->name('skill.store');
Route::get('admin/skill/edit/{skill}', [SkillController::class, 'SkillEdit'])->name('skill.edit');
Route::put('admin/skill/update/{skill}', [SkillController::class, 'SkillUpdate'])->name('skill.update');
Route::delete('admin/skill/delete/{skill}', [SkillController::class, 'SkillDelete'])->name('skill.delete');

// Project Route

Route::get('admin/projects',[ProjectController::class,'Index'])->name('projects.index');
Route::get('admin/project/create', [ProjectController::class, 'ProjectCreate'])->name('project.create');
Route::post('admin/project/store', [ProjectController::class, 'ProjectStore'])->name('project.store');
Route::get('admin/project/edit/{project}', [ProjectController::class, 'ProjectEdit'])->name('project.edit');
Route::put('admin/project/update/{project}', [ProjectController::class, 'ProjectUpdate'])->name('project.update');
Route::delete('admin/project/delete/{project}', [ProjectController::class, 'ProjectDelete'])->name('project.delete');

require __DIR__.'/auth.php';
