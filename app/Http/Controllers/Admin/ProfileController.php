<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman pengaturan foto profil.
     */
    public function edit()
    {
        $photo = Setting::profilePhotoUrl();

        return view('admin.profile.edit', compact('photo'));
    }

    /**
     * Perbarui (atau hapus) foto profil.
     */
    public function update(Request $request)
    {
        $request->validate([
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_photo' => ['nullable', 'boolean'],
        ]);

        $oldPhoto = Setting::profilePhoto();

        // Hapus foto profil
        if ($request->boolean('remove_photo')) {

            Setting::deleteProfilePhoto($oldPhoto);
            Setting::set(Setting::PROFILE_PHOTO_KEY, null);

            return redirect()
                ->route('admin.profile.edit')
                ->with('success', 'Foto profil berhasil dihapus.');
        }

        // Ganti foto profil
        if ($request->hasFile('photo')) {

            $newPhoto = Setting::storeProfilePhoto($request->file('photo'));

            Setting::deleteProfilePhoto($oldPhoto);
            Setting::set(Setting::PROFILE_PHOTO_KEY, $newPhoto);

            return redirect()
                ->route('admin.profile.edit')
                ->with('success', 'Foto profil berhasil diperbarui.');
        }

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Tidak ada perubahan.');
    }
}
