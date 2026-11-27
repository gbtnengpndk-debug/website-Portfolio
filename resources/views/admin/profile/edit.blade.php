@extends('layouts.admin')

@section('title', 'Admin - Profil')

@section('content')

<div class="admin-container">

    <div class="admin-page-header">

        <div>
            <h1>Foto Profil</h1>
            <p>Foto ini tampil di bagian hero pada halaman portfolio.</p>
        </div>

        <a href="{{ url('/') }}" class="admin-back" target="_blank">
            ← Lihat Portfolio
        </a>

    </div>

    @if(session('success'))

        <div class="admin-alert admin-alert-success">
            {{ session('success') }}
        </div>

    @endif

    @if ($errors->any())

        <div class="admin-alert admin-alert-error">

            <strong>Terjadi kesalahan:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    <div class="admin-form-card">

        <form
            action="{{ route('admin.profile.update') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div class="admin-form-group">

                <label for="photo">
                    Foto Profil
                </label>

                @if ($photo)

                    <img
                        src="{{ $photo }}"
                        alt="Foto profil saat ini"
                        class="admin-profile-preview"
                    >

                @else

                    <div class="admin-profile-preview admin-profile-preview-empty">
                        <span>Belum ada foto</span>
                    </div>

                @endif

                <input
                    type="file"
                    id="photo"
                    name="photo"
                    accept="image/jpeg,image/png,image/webp"
                >

                <small>
                    Pilih foto baru untuk mengganti foto saat ini.
                    JPG, PNG, atau WebP. Maksimal 4 MB.
                </small>

            </div>

            @if ($photo)

                <div class="admin-checkbox">

                    <label>

                        <input
                            type="checkbox"
                            name="remove_photo"
                            value="1"
                        >

                        <span>
                            Hapus foto profil saat ini
                        </span>

                    </label>

                </div>

            @endif

            <div class="admin-form-actions">

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="admin-button-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="admin-button"
                >
                    Simpan Foto
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
