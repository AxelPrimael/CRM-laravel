<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/dashboard" class="text-xl font-bold text-blue-600">
                    CRM Laravel
                </a>
            </div>

            <!-- Menu Desktop (Caché sur mobile) -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                <a href="/dashboard" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Dashboard</a>
                <a href="/contacts" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Contacts</a>

                @role('Super Admin')
                    <a href="/users" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Utilisateurs</a>
                @endrole

                @can('contact.create')
                    <a href="/contacts/create" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Ajouter un contact</a>
                @endcan

                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 px-3 py-2 text-sm font-medium">
                        Déconnexion
                    </button>
                </form>
            </div>

            <!-- Bouton Hamburger (Visible uniquement sur mobile) -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu Mobile (Affiché/Caché via Alpine.js) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            <a href="/dashboard" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-blue-600 hover:text-blue-600 text-base font-medium">Dashboard</a>
            <a href="/contacts" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-blue-600 hover:text-blue-600 text-base font-medium">Contacts</a>

            @role('Super Admin')
                <a href="/users" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-blue-600 hover:text-blue-600 text-base font-medium">Utilisateurs</a>
            @endrole

                <a href="/contacts/create" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-blue-600 hover:text-blue-600 text-base font-medium">Ajouter un contact</a>
  

            <div class="border-t border-gray-200 pt-2">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 text-red-600 hover:bg-red-50 font-medium">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>