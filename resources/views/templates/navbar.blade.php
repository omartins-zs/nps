<!-- resources/views/templates/navbar.blade.php -->
<!-- Navbar -->
<nav class="bg-blue-700 border-gray-200 dark:bg-gray-900">
    <div class="max-w-full flex flex-wrap items-center justify-between mx-auto p-4">
        <div class="flex gap-3">
            <!-- Botão para abrir o sidebar -->
            <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar"
                aria-controls="default-sidebar" type="button"
                class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                    </path>
                </svg>
            </button>

            <!-- Logo e nome -->
            <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold text-white whitespace-nowrap dark:text-white">NPS</span>
            </a>

        </div>
        <div class="flex-1 text-center text-yellow-400 text-xl font-semibold">
            Casas Andre Luiz
        </div>
        <!-- Menu e ícones -->
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

            <!-- Botão Sistemas -->
            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                class="flex items-center justify-between w-full py-2 px-3 text-white bg-blue-700 rounded transition-all duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 dark:focus:ring-blue-600 mr-2">
                Sistemas
                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="dropdownNavbar"
                class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                    @foreach ($sistemas as $sistema)
                        <li>
                            <a href="{{ $sistema['link'] }}" target="_blank"
                                class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                <i class="{{ $sistema['icone'] }} text-blue-500 mr-2"></i> <!-- Ícone do sistema -->
                                {{ $sistema['descricao'] }} <!-- Descrição do sistema -->
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="py-1">
                    <a href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
                        out</a>
                </div>
            </div>

            <button type="button"
                class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                data-dropdown-placement="bottom">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full" src="https://avatar.iran.liara.run/public" alt="user photo">
            </button>
            <!-- Dropdown do usuário -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">Bonnie Green</span>
                    <span class="block text-sm text-gray-500 truncate dark:text-gray-400">name@flowbite.com</span>
                </div>
                <ul class="py-2" aria-labelledby="user-menu-button">
                    <li><a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                    </li>
                    <li><a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
                    </li>
                    <li><a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Earnings</a>
                    </li>
                    <li><a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
                            out</a></li>
                </ul>
            </div>
        </div>
        <!-- Navbar Links -->
        {{-- <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
            <ul
                class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="#"
                        class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500"
                        aria-current="page">Home</a>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500"
                        aria-current="page">About</a>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500"
                        aria-current="page">Services</a>
                </li>
            </ul>
        </div> --}}
    </div>
</nav>

<!-- Segunda linha com selects e botão de pesquisa -->
<div class="bg-white py-1 border-t border-gray-200">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 flex justify-end items-center space-x-3">
        <!-- Select de Mês -->
        <div>
            <select id="selectedMonth" name="selectedMonth"
                class="form-control w-full py-2 px-3 border border-gray-300 rounded-md">
                @foreach ($meses as $mes => $nomeMes)
                    <option value="{{ $mes }}" {{ $month == $mes ? 'selected' : '' }}>
                        {{ $nomeMes }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Select de Ano  -->
        <div class="w-20">
            <input type="number" id="selectedYear" name="selectedYear"
                class="form-control w-full py-2 px-2 border border-gray-300 rounded-md" value="{{ $year }}">
        </div>

        <!-- Botão de Pesquisa -->
        <button type="button"
            class="ml-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center">
            <i class="fas fa-search mr-2"></i>
            Consultar
        </button>
    </div>
</div>
