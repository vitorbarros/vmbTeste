<?php
namespace VmbTest\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use VmbTest\Models\User;
use Validator;
use VmbTest\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '/app/sintegra';

    protected $loginPath = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return array|\Illuminate\Http\RedirectResponse|Response
     */
    public function postLogin(Request $request, Response $response)
    {
        $this->validate($request, array(
            'username' => 'required',
            'password' => 'required'
        ));

        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return array('redirect' => $this->redirectPath());
        }

        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        $response->setStatusCode(401);
        $response->setContent(array('messages' => 'Usuário ou senha incorretos'));
        return $response;
    }
}
