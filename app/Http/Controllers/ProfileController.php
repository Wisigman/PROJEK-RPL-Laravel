<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
    
        if ($request->action === 'update_profile') {
            // Simpan username lama untuk digunakan jika ingin kembali
            $previousUsername = $user->username;
    
            // Validasi untuk profil
            $validatedData = $request->validate([
                'name' => [
                    'required', 
                    'string', 
                    'max:255',
                    function ($attribute, $value, $fail) {
                        // Daftar kata yang dilarang
                        $forbiddenWords = ['admin', 'root', 'fuck', 'bitch', 'shit', 'god', 'owner'];

                        // Memeriksa apakah nama mengandung kata yang dilarang
                        foreach ($forbiddenWords as $word) {
                            if (stripos($value, $word) !== false) { // stripos untuk case-insensitive
                                $fail('The ' . $attribute . ' contains forbidden words like "' . $word . '".');
                                return;
                            }
                        }
                    }
                ],
                'username' => [
                    'required', 
                    'string', 
                    'max:255', 
                    'unique:users,username,' . $user->id, // Memastikan validasi username unik kecuali untuk user yang sedang diperbarui
                    function ($attribute, $value, $fail) use ($user) {
                        // Memastikan hanya karakter yang diizinkan (huruf, angka, -, dan _)
                        if (!preg_match('/^[a-zA-Z0-9-_]+$/', $value)) {
                            $fail('Ensure your ' . $attribute . ' only contains letters, numbers, dashes, and underscores, with no spaces.');
                        }

                        // Ganti spasi menjadi underscore dan update nilai username
                        $user->username = str_replace(' ', '_', $value);

                        // Opsional: Memperbarui database jika diperlukan
                        // $user->save();
                    }
                ],            
                'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:4096', function ($attribute, $value, $fail) {
                    // Cek jika ukuran file lebih dari 4 MB (4096 KB)
                    if ($value && $value->getSize() > 4096 * 1024) {
                        $fail('The ' . $attribute . ' must be less than 4 MB.');
                    }
                }],
                'birth_date' => ['nullable', 'date'],
                'about' => ['nullable', 'string', 'max:500'],
            ], [
                'username.unique' => 'Username sudah digunakan. Silakan pilih yang lain.',
                'email.unique' => 'Email sudah terdaftar. Silakan gunakan yang lain.',
            ]);
    
            // Cek apakah pengguna ingin kembali ke username sebelumnya
            if ($request->input('restore_username') && $previousUsername !== $request->input('username')) {
                // Pastikan username yang ingin dipulihkan tidak digunakan oleh orang lain
                $existingUser = User::where('username', $previousUsername)->first();
                if ($existingUser) {
                    // Kembalikan username ke yang lama
                    $validatedData['username'] = $previousUsername;
                } else {
                    return Redirect::route('profile.edit')->withErrors([
                        'username' => 'Username sebelumnya sudah digunakan oleh pengguna lain.'
                    ]);
                }
            }
    
            // Update data pengguna
            $user->update($validatedData);
    
            // Jika email diperbarui, set email_verified_at menjadi null
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }
    
            // Update foto
            if ($request->hasFile('foto')) {
                // Hapus foto lama
                if ($user->foto) {
                    Storage::disk('public')->delete($user->foto);
                }
    
                // Simpan foto baru
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $fotoPath = $file->storeAs('photos', $filename, 'public');
                $user->foto = $fotoPath;
            }
    
            // Simpan perubahan
            $user->save();
    
            return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
        }
    
        if ($request->action === 'update_password') {
            // Validasi untuk pembaruan password
            $validatedData = $request->validate([
                'current_password' => ['required'],
                'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
    
            // Cek password lama
            if (!Hash::check($validatedData['current_password'], $user->password)) {
                return Redirect::route('profile.edit')->withErrors([
                    'current_password' => 'Password lama salah.'
                ]);
            }
    
            // Update password
            $user->password = Hash::make($validatedData['new_password']);
            $user->save();
    
            return Redirect::route('profile.edit')->with('status', 'Password berhasil diperbarui.');
        }
    
        return Redirect::route('profile.edit')->withErrors(['action' => 'Aksi tidak valid.']);
    }    

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}