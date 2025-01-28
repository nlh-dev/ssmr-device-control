<div class="p-4 sm:ml-64">
    <div class="p-4 mt-14">
        <?php
        $userID = $instanceLogin->cleanRequest($url[1]);
        //BREADCRUMB LINKS
        if ($userID == $_SESSION['ID']) {
            include "./app/views/includes/components/breadcrumbProfile.php";
        } else {
            include "./app/views/includes/components/breadcrumbUsers.php";
        } ?>
        <hr class="my-4">

        <?php
        //SELECT USER DATA FROM DATABASE
        $userdata = $instanceLogin->selectData("Unique", "users", "user_ID", $userID);

        if ($userdata->rowCount() == 1) { 
            $userdata = $userdata -> fetch();
            ?>

            <form action="<?= APPURL ?>app/ajax/userAjax.php" class="AjaxForm" method="POST" autocomplete="off">

                <input type="hidden" name="userModule" id="userModule" value="updateUser">
                <input type="hidden" name="user_ID" id="user_ID" value="<?= $userdata['user_ID']?>">

                <div class="grid mb-6 sm:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-5">
                    <div>
                        <div>
                            <h1 class="flex items-center justify-center mb-3 text-strong text-xl font-bold text-gray-800">Perfil del Usuario</h1>
                        </div>
                        <div class="flex items-center justify-center mb-3">
                            <p class="font-medium text-lg">Nombre y Apellido</p>
                        </div>
                        <div class="flex items-center justify-center mb-3">
                            <p class="text-gray-500"><?= $userdata['user_FirstName']?> <?= $userdata['user_LastName']?></p>
                        </div>
                        <div class="flex items-center justify-center mb-3">
                            <p class="font-medium text-lg">Nombre de Usuario</p>
                        </div>
                        <div class="flex items-center justify-center mb-3">
                            <p class="text-gray-500"><?= $userdata['user_userName']?></p>
                        </div>
                        <div class="flex items-center justify-center mb-3">
                            <p class="font-medium text-lg">Contraseña</p>
                        </div>
                        <div class="flex items-center justify-center mb-3">
                            <p class="text-gray-500"><?= $userdata['user_Password']?></p>
                        </div>
                    </div>
                    <div>
                        <div>
                            <h1 class="flex items-center justify-center mb-4 text-strong text-xl font-bold text-gray-800">Actualizar</h1>
                        </div>
                        <div class="relative mb-4">
                            <input type="text" id="firstName" name="firstName" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" value="<?= $userdata['user_FirstName']?>"/>
                            <label class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Nombre</label>
                        </div>

                        <div class="relative mb-4">
                            <input type="text" id="lastName" name="lastName" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value=" <?= $userdata['user_LastName']?>"/>
                            <label class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Apellido</label>
                        </div>

                        <div class="relative mb-4">
                            <input type="text" id="userName" name="userName" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value=" <?= $userdata['user_userName']?>"/>
                            <label class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Nombre de Usuario</label>
                        </div>

                        <div class="relative">
                            <input type="password" id="userPassword" name="userPassword" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " value=" <?= $userdata['user_Password']?>"/>
                            <label class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Contraseña</label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center sm:col-span-1 lg:col-span-2 xl:col-span-3 gap-3">
                    <?php include "./app/views/includes/components/buttonBack.php"; ?>
                    <button type="submit" id="submitButton" name="submitButton" class="sm:mb-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        Actualizar
                    </button>
                </div>
            </form>
        <?php } else { ?>
            <div id="alert-additional-content-2" class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <div class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <h3 class="text-lg font-medium">¡Error!</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    No se pudo obtener la información del usuario solicitado
                </div>
                <div class="flex">
                    <a type="button" href="<?= APPURL?>users/" class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        Regresar
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>