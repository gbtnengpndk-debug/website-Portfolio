<section id="home" class="hero">
    <div class="container">
        <div class="hero-content">

            <div class="hero-avatar">

                @if ($profilePhoto)

                    <img
                        src="{{ $profilePhoto }}"
                        alt="Foto profil Andhika Wicaksana"
                        loading="eager"
                    >

                @else

                    <span class="hero-avatar-placeholder" aria-hidden="true">
                        <i class="fa-solid fa-user"></i>
                    </span>

                @endif

            </div>

            <p class="hero-greeting">
                👋 Halo, saya
            </p>

            <h1>
                Andhika <span>Wicaksana</span>
            </h1>

            <p class="hero-description">
                Seorang developer yang sedang belajar dan
                membangun berbagai project menggunakan Laravel,
                PHP, database, dan teknologi web modern.
            </p>

            <a href="#projects" class="button">
                Lihat Project
            </a>

        </div>
    </div>
</section>
