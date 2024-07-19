<?php

namespace App\Containers\UsersSection\Tutors\Actions;

use App\Ship\Actions\Action;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;

class GetTutorSubjectsAction extends Action
{
    public function run(Tutor $tutor)
    {
        // Find the tutor by ID and load the subjects
        $tutor = Tutor::with('subjects')->find($tutor->id);

        if (!$tutor) {
            // Handle the case where the tutor is not found
            return response()->json(['error' => 'Tutor not found'], 404);
        }

        // Return the subjects
        return $tutor->subjects;
    }
}
