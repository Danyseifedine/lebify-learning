@props(['image', 'name', 'role' => null, 'rating', 'text'])

<div class="testimonial-card">
    <div class="glass-effect"></div>
    <div class="card-content">
        <div class="quote-icon">
            <i class="bi bi-quote fs-1 text-white"></i>
        </div>
        <p class="testimonial-text">{{ $text }}</p>
        <div class="user-info">
            <div class="user-avatar">
                <img src="{{ asset($image) }}" alt="{{ $name }}">
                <div class="avatar-glow"></div>
            </div>
            <div>
                <div class="name-role">
                    <h4>{{ $name }}</h4>
                    @isset($role)
                        <span class="user-role">{{ $role }}</span>
                    @endisset
                </div>
                <div class="user-rating">
                    @for ($i = 0; $i < floor($rating); $i++)
                        <i class="bi bi-star-fill text-warning"></i>
                    @endfor
                    @if ($rating - floor($rating) > 0)
                        <i class="bi bi-star-half text-warning"></i>
                    @endif
                    <span>{{ $rating }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
