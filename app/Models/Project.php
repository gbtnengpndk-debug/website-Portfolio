<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Project extends Model
{
    /**
     * Folder gambar di public/ untuk penyimpanan lokal.
     */
    public const LOCAL_IMAGE_DIR = 'uploads/projects';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'github_url',
        'demo_url',
        'featured',
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];

    /**
     * Pakai Supabase Storage kalau kredensialnya tersedia,
     * kalau tidak simpan gambar di public/uploads/projects.
     */
    public static function usesCloudStorage(): bool
    {
        return filled(config('filesystems.disks.s3.key'))
            && filled(config('filesystems.disks.s3.secret'))
            && filled(config('filesystems.disks.s3.bucket'));
    }

    /**
     * Simpan file gambar dan kembalikan nilai untuk kolom `image`.
     */
    public static function storeImage(UploadedFile $file): string
    {
        $filename = Str::uuid() . '.' . $file->extension();

        // Kondisi 1: Supabase Storage
        if (static::usesCloudStorage()) {

            $path = Storage::disk('s3')->putFileAs(
                '',
                $file,
                $filename,
                'public'
            );

            if (!$path) {
                throw ValidationException::withMessages([
                    'image' => 'Gagal upload gambar ke Supabase Storage. Periksa konfigurasi AWS_* / Supabase.',
                ]);
            }

            return $path;
        }

        // Kondisi 2: penyimpanan lokal di public/uploads/projects
        $file->move(public_path(static::LOCAL_IMAGE_DIR), $filename);

        return static::LOCAL_IMAGE_DIR . '/' . $filename;
    }

    /**
     * Hapus file gambar dari tempat penyimpanannya (lokal atau Supabase).
     */
    public static function deleteImage(?string $image): void
    {
        if (!$image) {
            return;
        }

        // Gambar yang berada di public/uploads/projects
        if (str_starts_with($image, static::LOCAL_IMAGE_DIR . '/')) {

            $path = public_path($image);

            if (is_file($path)) {
                @unlink($path);
            }

            return;
        }

        // Gambar yang berada di Supabase Storage
        Storage::disk('s3')->delete($image);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes) {
                $image = $attributes['image'] ?? null;

                if (!$image) {
                    return null;
                }

                // Gambar lokal di public/uploads/projects
                if (str_starts_with($image, static::LOCAL_IMAGE_DIR . '/')) {
                    return asset($image);
                }

                // Gambar dari Supabase Storage
                $base = config('filesystems.disks.s3.public_url')
                    ?: config('filesystems.disks.s3.url');

                if (!$base) {
                    return null;
                }

                return rtrim($base, '/') . '/' . ltrim($image, '/');
            },
        );
    }
}
