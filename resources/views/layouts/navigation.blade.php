<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold">
                    CRM Laravel
                </a>
            </div>


            <!-- Menu -->
            <div class="flex items-center space-x-6">

                <a href="{{ route('dashboard') }}"
                   class="text-gray-700 hover:text-blue-600">
                    Dashboard
                </a>


                <a href="{{ route('contacts.index') }}"
                   class="text-gray-700 hover:text-blue-600">
                    Contacts
                </a>


                @role('Super Admin')
                <a href="{{ route('users.index') }}"
                   class="text-gray-700 hover:text-blue-600">
                    Utilisateurs
                </a>

                <a href="{{ route('roles.index') }}"
                   class="text-gray-700 hover:text-blue-600">
                    Rôles
                </a>
                @endrole


                <!-- Profil -->
                <a href="{{ route('profile.edit') }}"
                   class="text-gray-700 hover:text-blue-600">
                    Profil
                </a>


                <!-- Déconnexion -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="text-red-600 hover:text-red-800">
                        Déconnexion
                    </button>

                </form>

            </div>

        </div>
    </div>
</nav>