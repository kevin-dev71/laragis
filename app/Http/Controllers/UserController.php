<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
  // Show register/create form
  public function create()
  {
    return view('users.register');
  }

  // Create new user
  public function store(Request $request)
  {
    $formFields = $request->validate([
      'name' => ['required', 'min:3'],
      'email' => ['required', 'email', Rule::unique('users', 'email')],
      'password' => ['required', 'confirmed', 'min: 6'],
    ]);

    // Hash Password
    $formField['password'] = bcrypt($formFields['password']);
    $user = User::create($formFields);

    // Login
    auth()->login($user);

    return redirect('/')->with('message', 'You are now logged in!');
  }

  // logout
  public function logout(Request $request)
  {
    auth()->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('message', 'You are now logged out');
  }

  // show login form
  public function login(Request $request)
  {
    return view('users.login');
  }

  // Authenticate user
  public function authenticate(Request $request)
  {
    $formFields = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required', 'min: 6'],
    ]);

    if (auth()->attempt($formFields)) {
      $request->session()->regenerate();

      return redirect('/')->with('message', 'You are now logged in!');
    }

    return back()
      ->withErrors(['email' => 'Invalid credentials'])
      ->onlyInput('email');
  }
}
