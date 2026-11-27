<section id="skills" class="section skills">

    <div class="container">

        <div class="section-heading">

            <p class="section-label">
                Keahlian
            </p>

            <h2>
                Skills <span>Saya</span>
            </h2>

        </div>

        @if ($skills->isNotEmpty())

            <div class="skills-marquee" data-skills-marquee>
                <div class="skills-track" data-skills-track>

                    <div class="skills-group">

                        @foreach ($skills as $skill)
                            <div class="skill-card">

                                @if ($skill->icon)
                                    <div class="skill-icon">
                                        <i class="fa-brands fa-{{ $skill->icon }}"></i>
                                    </div>
                                @endif

                                <h3>
                                    {{ $skill->name }}
                                </h3>

                                @if ($skill->category)
                                    <p class="skill-category">
                                        {{ $skill->category }}
                                    </p>
                                @endif

                            </div>
                        @endforeach

                    </div>

                    {{-- Salinan kedua agar perulangan terlihat tanpa putus --}}
                    <div class="skills-group" aria-hidden="true">

                        @foreach ($skills as $skill)
                            <div class="skill-card">

                                @if ($skill->icon)
                                    <div class="skill-icon">
                                        <i class="fa-brands fa-{{ $skill->icon }}"></i>
                                    </div>
                                @endif

                                <h3>
                                    {{ $skill->name }}
                                </h3>

                                @if ($skill->category)
                                    <p class="skill-category">
                                        {{ $skill->category }}
                                    </p>
                                @endif

                            </div>
                        @endforeach

                    </div>

                </div>
            </div>

        @else

            <p class="skills-empty">
                Belum ada skill.
            </p>

        @endif

    </div>

</section>
