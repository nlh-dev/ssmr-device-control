<?php

    namespace app\controllers;
    use app\models\mainModel;

class userController extends mainModel{

    // CONTROLLER TO GET USER'S ROLE
    public function getUsersRoleController(){
        $getRoles_Query = "SELECT * FROM roles";
        $getRoles_SQL = $this -> dbRequestExecute($getRoles_Query);
        $getRoles_SQL -> execute();
        return $getRoles_SQL;
    }

    // CONTROLLER TO ADD USERS
    public function addUserController(){

        // STORING THE DATA SENT BY THE FORM
        $firstName = $this->cleanRequest($_POST['firstName']);
        $lastName = $this->cleanRequest($_POST['lastName']);
        $userName = $this->cleanRequest($_POST['userName']);
        $userPassword = $this->cleanRequest($_POST['userPassword']);
        $userRole = $this->cleanRequest($_POST['userRole']);

        // VERIFYING IF THE DATA IS EMPTY
        if (empty($firstName) || empty($lastName) || empty($userName) || empty($userPassword) || empty($userRole)) {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Algunos campos se encuentran vacios!",
            ];
            return json_encode($alert);
            exit();
        }

        // VERIFYING PATTERNS FROM FIRST AND LAST NAME
        if ($this->verifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $firstName)) {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Formato de nombre invalido!",
            ];
            return json_encode($alert);
            exit();
        }

        if ($this->verifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $lastName)) {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Formato de apellido invalido!",
            ];
            return json_encode($alert);
            exit();
        }

        // VERIFYING USER ON DATABASE
        $checkUser = $this->dbRequestExecute("SELECT user_userName FROM users WHERE user_userName = '$userName'");
        if ($checkUser->rowCount() > 0) {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡El usuario ingresado ya se encuentra registrado!",
            ];
            return json_encode($alert);
            exit();
        }

        // ARRAY TO STORE DATA FROM FORM FIELD TO DATABASE
        $userRegisterData = [
            [
                "db_FieldName" => "user_FirstName",
                "db_ValueName" => ":FirstName",
                "db_realValue" => $firstName
            ],
            [
                "db_FieldName" => "user_LastName",
                "db_ValueName" => ":LastName",
                "db_realValue" => $lastName
            ],
            [
                "db_FieldName" => "user_userName",
                "db_ValueName" => ":User",
                "db_realValue" => $userName
            ],
            [
                "db_FieldName" => "user_Password",
                "db_ValueName" => ":Password",
                "db_realValue" => $userPassword
            ],
            [
                "db_FieldName" => "user_role_ID",
                "db_ValueName" => ":Role",
                "db_realValue" => $userRole
            ],
        ];

        $addUsers = $this->saveData("users", $userRegisterData);
        if ($addUsers->rowCount() >= 1) {
            $alert = [
                "type" => "clean",
                "icon" => "success",
                "title" => "¡Operación Realizada!",
                "text" => "Usuario " . $firstName . " " . $lastName . " creado exitosamente",
            ];
        } else {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡El usuario no pudo ser registrado!",
            ];
        }
        return json_encode($alert);
    }

    // USER LIST CONTROLLER
    public function userListController($page, $register, $url, $search){

        $page = $this->cleanRequest($page);
        $register = $this->cleanRequest($register);

        $url = $this->cleanRequest($url);
        $url = APPURL . $url . "/";

        $search = $this->cleanRequest($search);
        $table = "";

        $page = (isset($page) && $page > 0) ? (int) $page : 1;
        $start = ($page > 0) ? (($page * $register) - $register) : 0;

        if (isset($search) && $search != "") {

            $dataRequest_Query = "SELECT * FROM users WHERE ((user_ID!='" . $_SESSION['ID'] . "' AND user_ID!='1') AND (user_FirstName LIKE '%$search%' OR user_LastName LIKE '%$search%' OR user_userName LIKE '%$search%')) ORDER BY user_FirstName ASC LIMIT $start,$register";

            $totalData_Query = "SELECT COUNT(user_ID) FROM users WHERE ((user_ID!='" . $_SESSION['ID'] . "' AND user_ID!='1') AND (user_FirstName LIKE '%$search%' OR user_LastName LIKE '%$search%' OR user_userName LIKE '%$search%'))";
        } else {

            $dataRequest_Query = "SELECT * FROM users JOIN roles ON users.user_role_ID = roles.role_ID WHERE user_ID!='" . $_SESSION['ID'] . "' AND user_ID!='1' ORDER BY user_FirstName ASC LIMIT $start,$register";

            $totalData_Query = "SELECT COUNT(user_ID) FROM users JOIN roles ON users.user_role_ID = roles.role_ID WHERE user_ID!='" . $_SESSION['ID'] . "' AND user_ID!='1'";
        }

        $data = $this->dbRequestExecute($dataRequest_Query);
        $data = $data->fetchAll();

        $total = $this->dbRequestExecute($totalData_Query);
        $total = (int) $total->fetchColumn();

        $numPages = ceil($total / $register);

        $table .= '<div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-3">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-base text-white uppercase bg-gray-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nombre y Apellido
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Usuario
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Contraseña
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Rol de Usuario
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>';

        if ($total >= 1 && $page <= $numPages) {
            $counter = $start + 1;
            $startPage = $start + 1;
            foreach ($data as $rows) {
                $table .= '
                    <tr class="bg-white border-b hover:bg-gray-200">
                        <td class="px-6 py-3 uppercase"> ' . $counter . ' </td>
                        <td class="px-6 py-3 font-medium text-gray-900 uppercase">' . $rows['user_FirstName'] . ' ' . $rows['user_LastName'] . ' </td>
                        <td class="px-6 py-3">' . $rows['user_userName'] . '</td>
                        <td class="px-6 py-3">' . $rows['user_Password'] . '</td>
                        <td class="px-6 py-3">' . $rows['role_Name'] . '</td>
                        <td class="px-6 py-3 text-center">
                            <div class="flex justify-center items-center">
                            <a href="' . APPURL . 'updateUsers/' . $rows['user_ID'] . '/" class="bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-full text-base p-2.5 text-center inline-flex items-center me-2">
                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            
                            <form class="AjaxForm" action="' . APPURL . 'app/ajax/userAjax.php" method="POST">

                                <input type="hidden" name="userModule" value="deleteUser">

                                <input type="hidden" name="user_ID" value="' . $rows['user_ID'] . '">

                                <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-base p-2.5 text-center inline-flex items-center me-2">
                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                            </div>
                        </td>
                    </tr>
                ';
                $counter++;
            }
            $finalPage = $counter - 1;
        } else {
            if ($total >= 1) {
                $table .= '
                    <tr class="bg-white border-b hover:bg-gray-200" >
                        <td colspan="6">
                        <div class= "flex justify-center items-center my-4">
                            No se encontraron registros en esta pagina
                        </div>
                        <div class= "flex justify-center items-center my-4">
                            <a href="' . $url . '1/" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                Haz click aqui para recargar
                            </a>
                        </div>
                        </td>
                    </tr>
                ';
            } else {
                $table .= '
                    <tr class="bg-white border-b hover:bg-gray-200">
                        <td colspan="6">
                        <div class= "flex justify-center items-center my-4">
                            No se encontraron registros
                        </div>
                        </td>
                    </tr>
                ';
            }
        }
        $table .= '</tbody></table></div>';


        if ($total > 0 && $page <= $numPages) {
            $table .= '<div class="flex justify-end items-center">
                            <p class="has-text-right">
                                Mostrando de <strong>' . $startPage . '</strong> a <strong>' .  $finalPage . ' </strong> de un total de <strong> ' . $total . '</strong> registros
                            </p>
                        </div>';

            $table .= $this->paginationData($page, $numPages, $url, 1);
        }

        return $table;
    }

    // CONTROLLER TO DELETE USERS
    public function deleteUserController(){

        $userID = $this->cleanRequest($_POST['user_ID']);

        if ($userID == 1) {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "No podemos eliminar el Usuario Administrador"
            ];
            return json_encode($alert);
            exit();
        }

        $userData = $this->dbRequestExecute("SELECT * FROM users WHERE user_ID = '$userID'");
        if ($userData->rowCount() <= 0) {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "Usuario no Encontrado"
            ];
            return json_encode($alert);
            exit();
        } else {
            $userData = $userData->fetch();
        }

        $deleteUser = $this->dbRequestExecute("DELETE FROM users WHERE user_ID = '$userID'");
        if ($deleteUser->rowCount() == 1) {
            $alert = [
                "type" => "reload",
                "icon" => "success",
                "title" => "¡Usuario Eliminado!",
                "text" => "Usuario " . $userData['user_FirstName'] . " " . $userData['user_LastName'] . " eliminado exitosamente"
            ];
        } else {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "Usuario " . $userData['user_FirstName'] . " " . $userData['usuario_apellido'] . " no eliminado, intente nuevamente"
            ];
        }
        return json_encode($alert);
    }

    public function updateUserController(){

        $userID = $this -> cleanRequest($_POST['user_ID']);
        $userData = $this -> dbRequestExecute("SELECT * FROM users WHERE user_ID = '$userID'");
        if($userData -> rowCount() <= 0){
            $alert=[
                "tipo"=>"simple",
                "titulo"=>"¡Error!",
                "texto"=>"Usuario no encontrado",
                "icono"=>"error"
            ];
            return json_encode($alert);
            exit();
        }else{
            $userData=$userData->fetch();
        }

        
        $firstName=$this->cleanRequest($_POST['firstName']);
        $lastName=$this->cleanRequest($_POST['lastName']);
        $userName=$this->cleanRequest($_POST['userName']);
        $userPassword=$this->cleanRequest($_POST['userPassword']);

        
        if($firstName=="" || $lastName=="" || $userName==""){
            $alert=[
                "type"=>"simple",
                "icon"=>"error",
                "title"=>"¡Error!",
                "text"=>"¡Algunos campos se encuentran vacios!",
            ];
            return json_encode($alert);
            exit();
        }

        # Verificando integridad de los datos #
        if($this->verifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$firstName)){
            $alert=[
                "type"=>"simple",
                "icon"=>"error",
                "title"=>"¡Error!",
                "text"=>"Formate de Nombre Invalido",
            ];
            return json_encode($alert);
            exit();
        }

        if($this->verifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$lastName)){
            $alert=[
                "type"=>"simple",
                "icon"=>"error",
                "title"=>"¡Error!",
                "text"=>"Formato de Apellido Invalido",
            ];
            return json_encode($alert);
            exit();
        }

        if($this->verifyData("[a-zA-Z0-9]{4,20}",$userName)){
            $alert=[
                "type"=>"simple",
                "icon"=>"error",
                "title"=>"¡Error!",
                "text"=>"Formato de Nombre de Usuario Invalido",
            ];
            return json_encode($alert);
            exit();
        }


        $userDataUpdate=[
            [
                "db_FieldName" => "user_FirstName",
                "db_ValueName" => ":FirstName",
                "db_realValue" => $firstName
            ],
            [
                "db_FieldName" => "user_LastName",
                "db_ValueName" => ":LastName",
                "db_realValue" => $lastName
            ],
            [
                "db_FieldName" => "user_userName",
                "db_ValueName" => ":User",
                "db_realValue" => $userName
            ],
            [
                "db_FieldName" => "user_Password",
                "db_ValueName" => ":Password",
                "db_realValue" => $userPassword
            ],
        ];

        $userCondition=[
            "condition_FieldName" => "user_ID",
            "condition_ValueName" => ":ID",
            "condition_realValue" => $userID
        ];

        if($this->updateData("users", $userDataUpdate, $userCondition)){

            if($userID==$_SESSION['ID']){
                $_SESSION['firstName'] = $firstName;
                $_SESSION['lastName'] = $lastName;
                $_SESSION['userName'] = $userName;
            }

            $alert=[
                "type"=>"reload",
                "icon"=>"success",
                "title"=>"¡Operacion Realizada!",
                "text"=>"Usuario ".$userData['user_FirstName']." ".$userData['user_LastName']." actualizado exitosamente",
            ];
        }else{
            $alert=[
                "type"=>"simple",
                "icon"=>"error",
                "title"=>"¡Error!",
                "text"=>"El Usuario ".$userData['user_FirstName']." ".$userData['user_LastName']." no pudo ser actualizado, intente nuevamente",
            ];
        }
        return json_encode($alert);
    }
}
