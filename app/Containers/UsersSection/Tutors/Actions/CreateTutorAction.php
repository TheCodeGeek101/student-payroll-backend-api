<?php

namespace App\Containers\UsersSection\Tutors\Actions;

use App\Models\User;
use App\Ship\Actions\Action;
use App\Containers\UsersSection\Tutors\Data\Models\Tutor;
use Illuminate\Support\Facades\DB;
use App\Containers\UsersSection\Tutors\Requests\StoreTutorRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CreateTutorAction extends Action
{
    public function run(StoreTutorRequest $request): Tutor
    {
        $tutor = null;

        DB::transaction(function () use ($request, &$tutor) {
            Log::info('Starting transaction for creating a tutor.');

            $tutorName = $request->validated()['first_name'] . ' ' . ucfirst($request->validated()['last_name']);

            $user = User::create([
                'name' => $tutorName,
                'email' => $request->validated()['email'],
                'password' => Hash::make('SecuredKey@2024'),
                'role' => 'tutor',
            ]);

            Log::info('User created: ', ['user' => $user]);

            $tutor = Tutor::create(array_merge(
                $request->validated(),
                ['user_id' => $user->id, 'registered_by' => 1]
            ));

            Log::info('Tutor created: ', ['tutor' => $tutor]);
        });

        Log::info('Transaction completed.');
        return $tutor;
    }

}
