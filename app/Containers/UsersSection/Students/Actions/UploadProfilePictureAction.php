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
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::transaction(function () use ($request, $student) {
            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/profile_pictures', $imageName);

                $student->profile_picture = $imageName;
                $student->save();
            }
        });

        return $student;
    }
}
