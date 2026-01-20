<a href="{{ route('profile.edit') }}"
    class="group flex items-center gap-x-4 px-2 py-3 text-sm font-semibold leading-6 text-secondary-900 hover:bg-secondary-50 rounded-md transition-colors">
    <img class="h-8 w-8 rounded-full bg-secondary-50 object-cover ring-2 ring-transparent group-hover:ring-brand-200"
        src="{{ Auth::user()->avatar_url }}" alt="">
    <span class="sr-only">Your profile</span>
    <span aria-hidden="true">{{ Auth::user()->name }}</span>
</a>