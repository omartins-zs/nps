<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{
     // Redireciona o usuário para o Google
     public function googleLogin()
     {
         return Socialite::driver('google')->redirect();
     }

     // Recebe a resposta do Google e faz o login
     public function handleGoogleCallback()
     {
         $googleUser = Socialite::driver('google')->user();

         // Verifica se o usuário já existe
         $user = User::where('email', $googleUser->getEmail())->first();

         if (!$user) {
             // Se o usuário não existir, cria um novo
             $user = User::create([
                 'name' => $googleUser->getName(),
                 'email' => $googleUser->getEmail(),
                 'google_id' => $googleUser->getId(),
                 'avatar' => $googleUser->getAvatar(),
                 'password' => bcrypt(str_random(16)), // Cria uma senha aleatória
             ]);
         }

         // Autentica o usuário
         Auth::login($user);

         // Grava os dados do usuário na sessão
         session(['UserLogado' => $user]);

         // Redireciona para o índice do NPSController
         return redirect()->route('dashboard');
     }
}
