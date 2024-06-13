<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class Skill extends Model
{
    protected $fillable = ['skillName', 'image'];

    public function projects(){
        return $this->hasMany(Project::class);
    }
}
