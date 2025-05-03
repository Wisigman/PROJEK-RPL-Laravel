<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input tanpa foto
        $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255',
                function ($attribute, $value, $fail) {
                    $forbiddenWords = ['admin', 'root', 'fuck', 'bitch', 'shit', 'god', 'owner'];

                    // Cek apakah nama mengandung kata terlarang
                    foreach ($forbiddenWords as $word) {
                        if (stripos($value, $word) !== false) {
                            $fail("The $attribute contains forbidden words like \"$word\".");
                            return;
                        }
                    }
                }
            ],
            'username' => [
                'required', 
                'string', 
                'max:255', 
                'unique:users,username', 
                function ($attribute, $value, $fail) {
                    // Cek karakter yang diizinkan
                    if (!preg_match('/^[a-zA-Z0-9-_]+$/', $value)) {
                        $fail("The $attribute can only contain letters, numbers, dashes, and underscores.");
                    }
                }
            ],
            'email' => ['required', 'string', 'email', 'lowercase', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user,supplier,admin'],
            'kode_pendaftaran' => ['required', 'string'],
        ]);

        // Validasi kode pendaftaran berdasarkan role
        $kodeValid = match ($request->role) {
            'user' => env('KODE_PENDAFTARAN_USER'),
            'supplier' => env('KODE_PENDAFTARAN_SUPPLIER'),
            'admin' => env('KODE_PENDAFTARAN_ADMIN'),
            default => null,
        };

        if ($request->kode_pendaftaran !== $kodeValid) {
            return back()->withErrors(['kode_pendaftaran' => 'Kode pendaftaran salah untuk role yang dipilih!']);
        }

        // Buat pengguna baru tanpa foto
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Trigger event pendaftaran jika diperlukan
        event(new Registered($user));

        // Login otomatis setelah registrasi
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', "Berhasil mendaftar sebagai {$user->role}!");
    }
}