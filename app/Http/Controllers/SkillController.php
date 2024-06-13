<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Skill;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
   public function Index()
   {
      $skills = Skill::orderBy('updated_at', 'desc')->paginate(10);
      return Inertia::render('Skill/Index', [
          'skills' => $skills
      ]);
   }

   public function SkillCreate(){
      return Inertia::render('Skill/Create');
   }

   public function SkillStore(Request $request){

      $validator = Validator::make($request->all(), [
         'image' => ['required', 'image'],
         'skillName' => ['required', 'min:3'],
     ]);
 
      if ($validator->fails()) {
         return Redirect::back()->withErrors($validator);
     }
 
      if ($request->hasFile('image')) {
         $image = $request->file('image');
         $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
         $image->move('skill_images', $uniqueName);
         
         Skill::create([
            'skillName' => $request->skillName,
            'image' => 'skill_images/' .$uniqueName
        ]);

         return Redirect::route('skills.index')->with('success', 'Skill created successfully.');
      }

      return Redirect::back();

   }

   public function SkillEdit( Skill $skill){
      // dd($skill);
      return Inertia::render('Skill/Edit',[
          'skill' => $skill,
      ]);  
   }

   // update skill 
   public function SkillUpdate(Request $request, Skill $skill) {
      $request->validate([
          'skillName' => ['required', 'min:3'],
      ]);
  
      // Initialize image with the current skill's image
      $image = $skill->image;
  
      // Check if the request has a file and if it is valid
      if ($request->hasFile('image')) {
          // Delete the old image if it exists
          if ($skill->image && file_exists(public_path($skill->image))) {
              unlink(public_path($skill->image));
          }
  
          // Store the new image
          $image = $request->file('image');
          $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
          $image->move(public_path('skill_images'), $uniqueName);
  
          // Update the image path
          $image = 'skill_images/' . $uniqueName;
      }
  
      // Update the skill
      $skill->update([
          'skillName' => $request->skillName,
          'image' => $image
      ]);
  
      // Redirect with success message
      return Redirect::route('skills.index');
  }

  public function SkillDelete( Skill $skill){

   $image = $skill->image;
   if (File::exists($image)) {
       File::delete($image);
   }
   $skill->delete();
   return Redirect::route('skills.index');
  }





}

