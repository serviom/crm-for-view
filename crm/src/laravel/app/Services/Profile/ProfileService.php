<?php
namespace App\Services\Profile;

use App\Models\User;
use App\Services\Users\UsersService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public $fields;

    public function __construct()
    {
        $this->fields = [
            'name',
            'email',
            'phoneNumber',
        ];
    }

    public function getItem()
    {
        return (new User)->getItem(Auth::guard()->user()->getAuthIdentifier());
    }

    public function updateItem($request)
    {
        $userModel = new User();
        $user = $userModel->getItem(Auth::guard()->user()->getAuthIdentifier());
        $user->update($request->only($this->fields));

        if ($request->has('avatar') && $request->file('avatar')) {
            $path = $request->file('avatar')->store(UsersService::AVATAR_PATH);
            $user->avatar = basename($path);
            $user->save();
        }

        if ($request->has('password') && $request->get('password')) {
            $user->password = $request->get('password');
            $user->save();
        }

        return $user->refresh();
    }

    public function deleteAvatar() { //ToDo: check
        $userModel = new User();
        $user = $userModel->getItem(Auth::guard()->user()->getAuthIdentifier());
        Storage::delete(UsersService::AVATAR_PATH . DIRECTORY_SEPARATOR . $user->avatar);
        $user->avatar = null;
        $user->save();

        return $user->refresh();
    }

}
