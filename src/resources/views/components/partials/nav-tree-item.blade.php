<a class="collapse-item {{ request()->route()->getName() == "{$route}" ? 'active ' . ($bg ?? '') : '' }}"
    href="{{ route("{$route}") }}" wire:navigate>{{ strtoupper($label) }}</a>
