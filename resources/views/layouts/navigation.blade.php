<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="/dashboard" class="text-xl font-bold">
                    CRM Laravel
                </a>
            </div>


            <!-- Menu -->
            <div class="flex items-center space-x-6">


                <a href="/dashboard"
                   class="text-gray-700 hover:text-blue-600">
                    Dashboard
                </a>


                <a href="/contacts"
                   class="text-gray-700 hover:text-blue-600">
                    Contacts
                </a>


                @role('Super Admin')

                <a href="/users"
                   class="text-gray-700 hover:text-blue-600">
                    Utilisateurs
                </a>



                @endrole



    <a href="/contacts/create" class="text-gray-700 hover:text-blue-600">
        Ajouter un contact
    </a>



                <form method="POST" action="/logout">

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