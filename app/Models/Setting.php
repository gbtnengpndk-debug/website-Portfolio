<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Setting extends Model
{
    /**
     * Folder foto profil di public/.
     */
    public const PROFILE_PHOTO_DIR = 'uploads/profile';

    /**
     * Key untuk menyimpan path foto profil.
     */
    public const PROFILE_PHOTO_KEY = 'profile_photo';

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Ambil nilai setting berdasarkan key.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        return static::query()->where('key', $key)->value('value') ?? $default;
    }

    /**
     * Simpan (atau perbarui) nilai setting.
     */
    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Path foto profil yang tersimpan, atau null jika belum ada.
     */
    public static function profilePhoto(): ?string
    {
        $photo = static::get(static::PROFILE_PHOTO_KEY);

        return $photo ?: null;
    }

    /**
     * URL foto profil, atau null jika belum ada.
     * Sama seperti gambar project: Supabase jika terkonfigurasi, selain itu lokal.
     */
    public static function profilePhotoUrl(): ?string
    {
        $photo = static::profilePhoto();

        if (! $photo) {
            return null;
        }

        // Foto lokal di public/uploads/profile
        if (str_starts_with($photo, static::PROFILE_PHOTO_DIR . '/')) {

            $path = public_path($photo);

            if (! is_file($path)) {
                return null;
            }

            return asset($photo) . '?v=' . filemtime($path);
        }

        // Foto dari Supabase Storage
        $base = config('filesystems.disks.s3.public_url')
            ?: config('filesystems.disks.s3.url');

        if (! $base) {
            return asset($photo);
        }

        return rtrim($base, '/') . '/' . ltrim($photo, '/');
    }

    /**
     * Simpan file foto profil dan kembalikan nilai untuk setting.
     */
    public static function storeProfilePhoto(UploadedFile $file): string
    {
        $filename = Str::uuid() . '.' . $file->extension();

        // Supabase Storage jika kredensialnya tersedia
        if (Project::usesCloudStorage()) {

            $path = Storage::disk('s3')->putFileAs(
                static::PROFILE_PHOTO_DIR,
                $file,
                $filename,
                'public'
            );

            if (! $path) {
                throw ValidationException::withMessages([
                    'photo' => 'Gagal upload foto ke Supabase Storage. Periksa konfigurasi AWS_* / Supabase.',
                ]);
            }

            return $path;
        }

        // Penyimpanan lokal di public/uploads/profile
        $file->move(public_path(static::PROFILE_PHOTO_DIR), $filename);

        return static::PROFILE_PHOTO_DIR . '/' . $filename;
    }

    /**
     * Hapus file foto profil dari tempat penyimpanannya (lokal atau Supabase).
     */
    public static function deleteProfilePhoto(?string $photo): void
    {
        if (! $photo) {
            return;
        }

        if (str_starts_with($photo, static::PROFILE_PHOTO_DIR . '/')) {

            $path = public_path($photo);

            if (is_file($path)) {
                @unlink($path);
            }

            return;
        }

        Storage::disk('s3')->delete($photo);
    }
}
