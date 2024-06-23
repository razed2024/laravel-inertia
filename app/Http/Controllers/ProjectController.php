<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Skill;
 
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
 

class ProjectController extends Controller
{
   
    public function Index(){
        $projects = Project::with('skill')->get();
        return Inertia::render('Project/Index', compact('projects'));
    }


    public function ProjectCreate(){

        $skills = Skill::all();
        return Inertia::render('Project/Create' , compact('skills'));
    }


    public function ProjectStore(Request $request){
  
        $validator = Validator::make($request->all(), [
           'image' => ['required', 'image'],
           'projectName' => ['required', 'min:3'],
           'skill_id' => ['required', 'min:1'],
           'project_url' => ['required', 'min:3'],
       ]);
   
       if ($validator->fails()) {
        return Redirect::back()->withErrors($validator);
    }

    if ($request->hasFile('image')) {
        $project_image = $request->file('image');
        $uniqueName = time(). '-' . Str::random(10). '.' . $project_image->getClientOriginalExtension();
        $project_image->move('project_images', $uniqueName);
        
        Project::create([
           'projectName'=> $request->projectName,
           'skill_id'=> $request->skill_id,
           'project_url'=> $request->project_url,
           'image'=>'project_images/' . $uniqueName,
        ]);
        return Redirect::route('projects.index')->with('message', 'Project created successfully.');
     }

     return Redirect::back();


     }


public function ProjectEdit(Project $project){
    $skills = Skill::all();
    return Inertia::render ('Project/Edit' ,compact('skills','project'));
}

public function ProjectUpdate (Request $request, Project $project){

    $request->validate([
        'projectName' => ['required', 'min:3'],
        'skill_id' => ['required', 'min:1'],
   ]);

   // Initialize image with the current skill's image
   $image = $project->image;

   // Check if the request has a file and if it is valid
   if ($request->hasFile('image')) {
       // Delete the old image if it exists
       if ($project->image && file_exists(public_path($project->image))) {
           unlink(public_path($project->image));
       }

       // Store the new image
       $image = $request->file('image');
       $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
       $image->move(public_path('project_images'), $uniqueName);

       // Update the image path
       $image = 'project_images/' . $uniqueName;
   }

   // Update the skill
   $project->update([
      'projectName'=> $request->projectName,
      'skill_id'=> $request->skill_id,
      'project_url'=> $request->project_url,
      'image'=>'project_images/' . $uniqueName,
   ]);

   // Redirect with success message
   return Redirect::route('projects.index')->with('message', 'Project Updated Successfully');
}


public function ProjectDelete(Project $project){

    $image = $project->image;
    if (File::exists($image)) {
        File::delete($image);
    }
    $project->delete();
    return Redirect::route('projects.index')->with('message', 'Project Deleted Successfully');
    
}


}
