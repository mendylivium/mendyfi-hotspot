<li class="nav-item {{ request()->route()->getName() == "{$route}" ? 'active ' . ($bg ?? '') : '' }}">
    <a href="{{ route("{$route}") }}" class="nav-link {{ str_replace('.', '-', $route) ?? '' }}" wire:navigate>
        <i class="nav-icon {{ $icon }}"></i>
        <span>
            {{ strtoupper($label) }}
        </span>
    </a>
</li>
