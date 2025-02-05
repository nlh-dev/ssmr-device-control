<!-- NAVIGATION BAR -->
<nav class="fixed left-0 top-0 z-50 w-full bg-gray-900">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <a href="<?= APPURL ?>home" class="flex ms-2 md:me-24">
                    <img src="<?= APPURL ?>app/views/images/ssmr-2.ico" class="h-8 me-3" alt="">
                    <span class="self-center text-white text-lg font-semibold sm:text-2xl whitespace-nowrap">Entrega de Dispositivos</span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <svg class="w-8 h-8 rounded-full text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm" id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900" role="none">
                                <?= $_SESSION['firstName']; ?>
                                <?= $_SESSION['lastName']; ?>
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                Rol: <?= $_SESSION['roleName']; ?>
                            </p>
                        </div>
                        <ul class="py-1 px-2" role="none">
                            <div class="">
                                <li class="mt-2">
                                    <a href="<?= APPURL ?>updateUsers/<?= $_SESSION['ID'] ?>/" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-700 hover:text-white rounded-lg transition duration-100">Perfil</a>
                                </li>
                                <li class="mb-2">
                                    <a href="<?= APPURL ?>logout/" id="logoutButton" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-700 hover:text-white rounded-lg transition duration-100">
                                        Cerrar Sesión
                                    </a>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- SIDEBAR -->
<aside id="logo-sidebar" class="fixed left-0 top-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-gray-900 border-r border-gray-200 sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-gray-900">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="<?= APPURL ?>home/" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group transition duration-100">
                    <svg class="w-7 h-7 text-gray-500 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    <span class="ms-3">Inicio</span>
                </a>
            </li>
            <li>
                <a href="<?= APPURL; ?>devicePanel/" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 transition duration-100 group">
                    <svg class="w-7 h-7 text-gray-500 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-3 8a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H9Zm2 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H9Z" clip-rule="evenodd" />
                    </svg>

                    <span class="ms-3">Control de Entrega</span>
                </a>
            </li>
            <li>
                <div class="mb-3">
                    <a href="<?= APPURL ?>deviceStorage/" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 transition duration-100 group">
                        <svg class="w-7 h-7 text-gray-500 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd" />
                        </svg>
                        <span class="ms-3">Entregas Previas</span>
                    </a>
                </div>
            </li>

            <li>
                <div class="mb-3">
                    <a href="<?= APPURL ?>observations/" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 transition duration-100 group">
                        <svg class="w-7 h-7 text-gray-500 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.133 12.632v-1.8a5.406 5.406 0 0 0-4.154-5.262.955.955 0 0 0 .021-.106V3.1a1 1 0 0 0-2 0v2.364a.955.955 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C6.867 15.018 5 15.614 5 16.807 5 17.4 5 18 5.538 18h12.924C19 18 19 17.4 19 16.807c0-1.193-1.867-1.789-1.867-4.175ZM8.823 19a3.453 3.453 0 0 0 6.354 0H8.823Z" />
                        </svg>


                        <span class="ms-3">Observaciones</span>
                    </a>
                </div>
            </li>
            <?php if ($_SESSION['role'] == 1) { ?>
                <li>
                    <hr class="border-t border-gray-700">
                    <div class="flex items-center mt-2">
                        <h1 class="text-sm font-bold text-gray-700">Opciones</h1>
                    </div>
                    <div class="mt-2">
                        <a href="<?= APPURL ?>departments/" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 transition duration-100 group">
                            <svg class="w-7 h-7 text-gray-500 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M4 4a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2v14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2V5a1 1 0 0 1-1-1Zm5 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-1Zm-5 4a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1h-1Zm-3 4a2 2 0 0 0-2 2v3h2v-3h2v3h2v-3a2 2 0 0 0-2-2h-2Z" clip-rule="evenodd" />
                            </svg>
                            <span class="ms-3">Departamentos</span>
                        </a>
                    </div>
                </li>

                <li>
                    <div class="mt-2">
                        <a href="<?= APPURL ?>users/" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 transition duration-100 group">
                            <svg class="w-7 h-7 text-gray-500 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd" />
                            </svg>

                            <span class="ms-3">Usuarios</span>
                        </a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
    <!-- SIDEBAR ENDS -->

    <!-- USER INFO FOOTER -->
    <div class="absolute bottom-0 left-0 right-0 p-4 bg-gray-800 text-white">
        <div class="flex items-center">
            <span class="">Bienvenido(a):<br>
                <p class="font-medium uppercase">
                    <?= $_SESSION['firstName']; ?>
                    <?= $_SESSION['lastName']; ?>
                </p>
            </span>
        </div>
    </div>

</aside>