<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {




        // Felhasználónevet és jelszót lekérjük a kérésből
        $username = $request->input('username');
        $password = $request->input('password');

        // Guzzle HTTP kliens inicializálása
        $client = new Client();

        // Az API-hoz intézett kérés a felhasználó autentikációjához
        $response = $client->post(url('/api/auth'), [
            'form_params' => [
                'grant_type'    => 'password',
                'client_id'     => 'your-client-id',
                'client_secret' => 'your-client-secret',
                'username'      => $username,
                'password'      => $password,
                'scope'         => '',
            ],
        ]);

        // Az API válaszának feldolgozása
        $data = json_decode((string)$response->getBody(), true);

        // Ellenőrizzük, hogy a válaszban van-e hiba
        if (isset($data['error'])) {
            // Hiba történt az autentikáció során
            return redirect()->back()->withInput()->withErrors(['error' => $data['error']]);
        }

        // A token-t itt lehet használni a további kérésekhez
        $accessToken = $data['access_token'];

        // További kód a token használatával

        return redirect()->to('/home'); // Az átirányítás a sikeres bejelentkezés után
    }

    public function showRegistrationForm()
    {
        return view('login.register');
    }

    public function register(Request $request)
    {
        // Add your registration logic here
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
