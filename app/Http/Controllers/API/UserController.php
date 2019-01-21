<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\User;
use Mockery\CountValidator\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class UserController extends ApiController
{
    /**
     * Return all users
     *
     * @return void
     */
    public function index()
    {
        return $this->respond($this->usersCache());
    }
    /**
     * Return your user
     *
     * @return void
     */
    public function show($id)
    {
        $user = $this->usersCache()->find($id);

        if ($user) {
            return $this->respond($user);
        }

        return $this->respondNotFound('User not found!');
    }
    /**
     * Create a new user
     *
     * @return void
     */
    public function store(UserStoreRequest $request)
    {
        try {
            $user = (new User())->createUser($request->all());

            return $this->clearCache()->respond($user);
        } catch (Exception $e) {
            return $this->setStatusCode(400)
                ->respondWithError('Could not complete this operation!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->usersCache()->find($id);
        $this->authorize('update', $user);

        try {
            $user->update($request->all());

            return $this->clearCache()->respond($user);
        } catch (\Exception $e) {
            return $this->setStatusCode(400)
                ->respondWithError('Could not be update the content!');
        }
    }

    /**
     * Remove user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->usersCache()->find($id);
        $this->authorize('delete', $user);

        try {
            $user->delete();

            return $this->clearCache()->respond('User deleted!');
        } catch (\Exception $e) {
            return $this->respondWithError('Cannot delete user!');
        }
    }
    /**
     * Return all users in cache
     *
     * @return void
     */
    protected function usersCache()
    {
        $minutes = Carbon::now()->addMinutes(10);

        return Cache::remember('api::users', $minutes, function () {
            return User::all();
        });
    }
    /**
     * Clear Cache Users
     *
     * @return void
     */
    protected function clearCache()
    {
        Cache::forget('api::users');
        return $this;
    }
}
