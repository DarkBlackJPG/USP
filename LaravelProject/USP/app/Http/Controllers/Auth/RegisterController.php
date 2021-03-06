<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
        $messages = [
            'name.required'=>'Ovo polje je obavezno',
            'name.string'=>'Polje mora biti niz karaktera',
            'name.max'=>'Korisničko ime mora da bude manje od :max karaktera',
            'email.required' => 'Ovo polje je obavezno',
            'email.string' => 'Polje mora biti niz karaktera',
            'email.email' => 'E-mail nije pravilne forme',
            'email.max' => 'E-mail ne sme biti duži od :max karaktera',
            'email.unique' => 'E-mail već postoji',
            'password.required' => 'Ovo polje je obavezno',
            'password.string' => 'Polje mora biti niz karaktera',
            'password.min' => 'Lozinka ne može biti manja od :min karaktera',
            'password.confirmed' => 'Lozinke moraju biti iste',
        ];
        return Validator::make($data, $rules, $messages);
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
            'password' => Hash::make($data['password']),
        ]);
    }
}
