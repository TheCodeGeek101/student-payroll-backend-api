<?php

namespace App\Containers\UsersSection\Students;

use App\Containers\UsersSection\Students\Data\Models\Student;
use App\Ship\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadProfilePictureAction extends Action
{
    public function run(Request $request, Student $student)
    {
        // Validate image input
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::transaction(function () use ($request, $student) {
            if ($request->hasFile('profile_picture')) {
                // Retrieve the uploaded image
                $image = $request->file('profile_picture');
                
                // Generate a unique name for the image
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                
                // Delete the old profile picture if it exists
                if ($student->profile_picture) {
                    Storage::delete('public/profile_pictures/' . $student->profile_picture);
                }

                // Store the new image in the public disk
                $image->storeAs('public/profile_pictures', $imageName);

                // Update the student profile_picture field in the database
                $student->profile_picture = $imageName;
                $student->save(); // Submit the update to the database
            }
        });

        // Return the updated student object
        return $student;
    }
}
