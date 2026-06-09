@props(['user' => null, 'notifications' => []])

<div class="bg-white shadow-sm border-b border-gray-200">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button
                        type="button"
                        class="bg-white p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                        onclick="toggleSidebar()"
                    >
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>

                <!-- Search -->
                <div class="flex-1 flex items-center justify-center px-2 lg:ml-6 lg:justify-end">
                    <div class="max-w-lg w-full lg:max-w-xs">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input
                                id="search"
                                name="search"
                                class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-2xl leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm"
                                placeholder="Search..."
                                type="search"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center">
                <!-- Notifications -->
                @if(!empty($notifications))
                    <div class="ml-4 relative" x-data="{ open: false }">
                        <button
                            @click="open = !open"
                            class="bg-white p-2 rounded-2xl text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                        >
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.868 12.683A17.925 17.925 0 0112 21c7.962 0 12-1.21 12-2.683m-12 2.683a17.925 17.925 0 01-7.132-8.317M12 21V9m0 0a3 3 0 110-6 3 3 0 010 6z"/>
                            </svg>
                            <x-notification-badge :count="count($notifications)" class="absolute -top-1 -right-1"/>
                        </button>

                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="origin-top-right absolute right-0 mt-2 w-80 rounded-3xl shadow-2xl bg-white ring-1 ring-slate-200 ring-opacity-50 z-10"
                        >
                            <div class="py-2">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                                </div>
                                @foreach(array_slice($notifications, 0, 5) as $notification)
                                    <a href="{{ $notification['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50">
                                        <p class="text-sm text-gray-900">{{ $notification['title'] }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $notification['message'] }}</p>
                                    </a>
                                @endforeach
                                @if(count($notifications) > 5)
                                    <div class="px-4 py-2 border-t border-gray-200">
                                        <a href="#" class="text-sm text-blue-600 hover:text-blue-500">مشاهده همه اعلان‌ها</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Profile dropdown -->
                @if($user)
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button
                                @click="open = !open"
                                class="bg-white flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                <x-avatar :name="$user['name']" :src="$user['avatar'] ?? null" size="sm"/>
                            </button>
                        </div>

                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10"
                        >
                            <div class="py-1">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <p class="text-sm font-medium text-gray-900">{{ $user['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $user['email'] }}</p>
                                </div>

                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Your Profile
                                </a>
                                <a href="{{ route('settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Settings
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (sidebar && overlay) {
            const isOpen = sidebar.classList.contains('translate-x-0');

            if (isOpen) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
            }
        }
    }
</script>