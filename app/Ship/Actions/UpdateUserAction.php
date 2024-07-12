<?php

namespace App\Ship\Actions;

use App\Ship\Actions\Action;
use  App\Models\User;
use App\Http\Requests\UpdateUserRequest;
class UpdateUserAction extends Action
{
        public function execute(UpdateUserRequest $request, User $user){
            $user->update($request->validated());
            return $user;
        }
}
