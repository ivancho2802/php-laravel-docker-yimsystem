<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\UserNotFoundException;
use DateTime;
use Illuminate\Http\Response;

class UserController extends Controller
{

    public function login()
    {
        return view('session/login-session');
    }
    /**
     * get: Returns se authentified user data
     * @return Response
     */
    public function show(Request $request)
    {
        /** @var User $user */

        //return $request->user();

        $user = auth()->user();
        //->makeVisible(['id'])
        //->append('nps_show', 'is_full', 'is_invited', 'is_invited_user', 'has_company_contract', 'survey_show', 'rating_store_show'

        /* $user->load([
            'wallets', 'vehicles', 'restrictions',
            'parking' => function($query){
                $query->select('id', 'name');
            }
        ]);

        $user->vehicles->each->append("entry_exists");

        if ($userCustomer = $user->getCustomerByName(strtoupper(config('app.DEFAULT_CUSTOMER')), $this->scope)) {
            $user->customer = [
                'id' => $userCustomer->id,
                'key' => $userCustomer->sharedkey
            ];
        }

        $user->append('permission');

         */
        return response()->json(["status" => true, 'data' => $user], 201);
    }

    /**
     * update: Updates a current identified user data UpdateRequest
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            throw new UserNotFoundException();
        }

        if ($user->update($request->all())) {
            return $this->success();
        } else {
            return $this->failure(__('appark.user.error.updating'), 500, 500);
        }
    }

    /**
     * remove: Removes a current identified user
     * @return Response
     */
    public function remove()
    {
        $user = auth()->user();
        $user->currentAccessToken()->delete();
        return $this->success();
    }


    /**
     * Return user notifications
     */
    public function notifications(Request $request)
    {
        /* return $this->success(
            auth()->user()->notifications()
                ->filter($request)
                ->order($request)
                ->paginateData($request)
        ); */
    }

    /**
     * Returns server timestamp
     * @return Response
     */
    public function timestamp()
    {
        return $this->success([
            'status' => true,
            'timestamp' => (new DateTime())->getTimestamp()
        ]);
    }

    /**
     * get user config
     * @return Response
     */
    public function getConfig(): Response
    {
        return $this->success(
            auth()->user()->extras->getConfig()
        );
    }

    /**
     * Save user config
     * @param Request $request
     * @return Response
     */
    public function storeConfig(Request $request): Response
    {
        /**
         * @var \App\Classes\UserExtras $extras
         * @var \App\Models\User $user
         */

        $user = auth()->user();
        $extras = $user->extras;

        $extras->setConfig(
            Config::fromObject($request->all())
        );

        $user->update(compact('extras'));

        return $this->success();
    }

    public function exampleUserManager()
    {
        return view('laravel-examples/user-management');
    }
    public function exampleFixedPlugin()
    {
        return view('laravel-examples/fixed-plugin');
    }
    public function exampleTables()
    {
        return view('tables');
    }
    public function exampleVirtualReality()
    {
        return view('virtual-reality');
    }
    public function exampleStaticSignIn()
    {
        return view('static-sign-in');
    }
    public function exampleStaticSignUp()
    {
        return view('static-sign-up');
    }
}
