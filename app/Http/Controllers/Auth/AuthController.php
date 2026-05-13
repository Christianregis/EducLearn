<?php

namespace App\Http\Controllers\Auth;

use App\Enum\User\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('Login');
    }

    public function showRegister()
    {
        return Inertia::render('Register');
    }

    public function register(RegisterRequest $request)
    {
        $request->validated();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'student',
        ]);
        $user->assignRole(RoleEnum::STUDENT);
        return redirect()->route('showLogin')->with('success', 'Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Vous êtes connecté avec succès.');
        }

        return redirect()->back()->with('error', 'Les informations d\'identification sont incorrectes.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('showLogin')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    public function dashboard()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('showLogin')->with('error', 'Vous devez être connecté pour accéder au tableau de bord.');
        }
        if ($user->hasRole(RoleEnum::ADMIN)) {
            return redirect()->route('adminDashboard');
        } elseif ($user->hasRole(RoleEnum::TEACHER)) {
            return redirect()->route('teacherDashboard');
        } else {
            return redirect()->route('studentDashboard');
        }
    }
}
