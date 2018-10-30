<?php namespace Udla\Http\Controllers\Auth;

use Udla\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Auth;
use Input;
use Udla\Model\User;
use Hash;

class PasswordController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;

	/**
	 * Create a new password controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
	 * @return void
	 */
	public function __construct(Guard $auth, PasswordBroker $passwords)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;

		$this->middleware('guest',['except' => array('changePassword')]);
	}

	public function changePassword($id){
		if(Auth::user()->id == $id){
			$data = User::where('id','=',$id)->firstOrFail();
			$data->password = Hash::make(Input::get('new_password'));
			$data->save();
			return view('pages.perfil.index')->with('data', $data);
		}else{
			return view('errors.401');
		}
	}

}
