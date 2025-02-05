<div class="p-4 sm:ml-64">
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
                        <a href="<?= APPURL ?>observations/" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2">Control de Entrega</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2">Ver</a>
                    </div>
                </li>
            </ol>
        </nav>
        <!-- BREADCRUMB ENDS -->
        <hr class="my-4 border-gray-300">

        <?php
        //SELECT OBSERVATION DATA FROM DATABASE
        $deviceID = $instanceDevices->cleanRequest($url[1]);
        $deviceData = $instanceDevices->dbRequestExecute("SELECT * FROM devices JOIN departments 
        ON devices.device_department_ID = departments.department_ID WHERE device_ID = $deviceID");

        if ($deviceData->rowCount() == 1) {
            $deviceData = $deviceData->fetch(); ?>
            <div class="mb-4 flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-800 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd" />
                    </svg>
                    <h1 class="text-strong text-xl font-bold text-gray-800">Información de Entrega de Dispositivo</h1>
                </div>
                <div>
                    <button type="reset" class="ml-2 text-white bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11H11Zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626H12Zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2h-2Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="grid mb-6 sm:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-5">

                <div class="items-center">
                    <p class="font-bold mr-1">Entregado por: </p>
                    <?= $deviceData['device_userFullName'] ?>
                </div>

                <div class="items-center">
                    <p class="font-bold mr-1">Recibido por: </p>
                    <?= $deviceData['device_recievedByName'] ?>
                </div>
                <div class="items-center">
                    <p class="font-bold mr-1">Fecha de Entrega: </p>
                        <?= $deviceData['device_deliveryDate'] ?>
                </div>
                <div class="items-center">
                    <p class="font-bold mr-1">Descripción de Articulo: </p>
                    <?= $deviceData['device_Description'] ?>
                </div>
                <div>
                    <p class="font-bold mr-1">Número de Serial: </p>
                    <?= $deviceData['device_serialCode'] ?>
                </div>
                <div>
                    <p class="font-bold mr-1">Departamento: </p>
                    <p class="uppercase">
                        <?= $deviceData['department_Name'] ?>
                    </p>
                </div>
                <div>
                    <p class="font-bold mr-1">Código de Habitación: </p>
                    <?= $deviceData['device_RoomCode'] ?>
                </div>
                <div>
                    <p class="font-bold mr-1">Estado: </p>
                    <?php if ($deviceData['device_isDelivered'] != true) { ?>
                        <span class="bg-red-700 text-white text-sm font-medium me-2 px-2.5 py-0.5 rounded-md">Dispositivo Retirado</span>
                    <?php } else { ?>
                        <span class="bg-green-700 text-white text-sm font-medium me-2 px-2.5 py-0.5 rounded-md">Dispositivo Entregado</span>
                    <?php } ?>
                </div>
            </div>

            <div class="flex justify-end items-center sm:col-span-1 lg:col-span-2 xl:col-span-3 gap-3 mt-5">
                <?php include "./app/views/includes/components/returnButton.php"; ?>
            </div>

        <?php } else { ?>
            <div id="alert-additional-content-2" class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
                <div class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <h3 class="text-lg font-medium">¡Error!</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    No se pudo obtener el dispositivo solicitado
                </div>
                <div class="flex">
                    <a type="button" href="<?= APPURL ?>devicePanel/" class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center">
                        Regresar
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>