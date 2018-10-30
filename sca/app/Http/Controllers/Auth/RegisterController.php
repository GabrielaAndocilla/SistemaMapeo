<?php

namespace Udla\Http\Controllers\Auth;

use Udla\Model\User;
use Udla\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;
use Udla\Model\Career;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/usuarios';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => array( 'getLogout')]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
      return Validator::make($data, [
  				'name' => 'required|max:255',
  				'email' => 'required|email|max:255|unique:users',
  				'password' => 'required|confirmed|min:6',
          'tipo' => 'required'
  		]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
      return User::create([
					'name' => $data['name'],
					'email' => $data['email'],
					'password' => bcrypt($data['password']),
          'type' => $data['tipo'],
          'career' => $data['career']
			]);
    }

    /**
  	 * Handle a registration request for the application.
  	 *
  	 * @param  \Illuminate\Http\Request  $request
  	 * @return \Illuminate\Http\Response
  	 */
  	public function register(Request $request)
  	{
      $validator = $this->validator($request->all());

      if ($validator->fails()) {
          $this->throwValidationException(
              $request, $validator
          );
      }
      $this->create($request->all());
  		return redirect($this->redirectPath());
  	}

    public function showRegistrationForm()
    {
      if(Auth::guest()){
        return redirect('auth/login');
      }
        else{
          $carreras = Career::all();
          return view('auth.register')->with('carreras',$carreras);
        }
    }
}
