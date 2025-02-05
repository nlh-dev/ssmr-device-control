<div class="flex-grow p-4 sm:ml-64">
    <div class="p-4 mt-14">
    

        <!-- BREADCRUMB LINKS -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="<?= APPURL ?>home/" class="inline-flex items-center text-lg font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-5 h-5 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Inicio
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="<?= APPURL ?>observations/" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2">Observaciones</a>
                    </div>
                </li>
            </ol>
        </nav>

        <hr class="my-4 border-gray-300">

        <div class="w-full flex justify-end items-center my-4">
            <a href="<?= APPURL ?>addObservation/" class="block text-white bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                <div class="flex items-center justify-center">
                    <svg class="w-6 h-6 text-white mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd" />
                    </svg>
                    <span>Añadir Observación</span>
                </div>
            </a>
        </div>

        <?php

        use app\controllers\observationController;
        $instanceUsers = new observationController();

        echo $instanceUsers->observationsListController($url[1], 5, $url[0], "");

        ?>

    </div>
</div>