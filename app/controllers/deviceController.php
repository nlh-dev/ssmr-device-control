<?php

namespace app\controllers;

use app\models\mainModel;

class deviceController extends mainModel{

    public function getDepartmentsController(){
        $getDepartments_Query = "SELECT * FROM departments";
        $getDepartments_SQL = $this->dbRequestExecute($getDepartments_Query);
        $getDepartments_SQL->execute();
        return $getDepartments_SQL;
    }

    public function addDeviceController(){
        $recievedByName = $this->cleanRequest($_POST['recievedByName']);
        $itemDescription = $this->cleanRequest($_POST['itemDescription']);
        $itemCode = $this->cleanRequest($_POST['itemCode']);
        $departmentName = $this->cleanRequest($_POST['departmentName']);
        $roomCode = $this->cleanRequest($_POST['roomCode']);
        $deliveryDate = $this->cleanRequest($_POST['deliveryDate']);

        $recievedByName = strtoupper($recievedByName);
        $itemDescription = strtoupper($itemDescription);
        $itemCode = strtoupper($itemCode);
        $roomCode = strtoupper($roomCode);

        if (empty($recievedByName) || empty($itemDescription) || empty($departmentName) || empty($itemCode) || empty($roomCode) || empty($deliveryDate)) {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Algunos campos se encuentran vacios!",
            ];
            return json_encode($alert);
            exit();
        }

        $checkControl = $this -> dbRequestExecute("SELECT device_isDelivered 
        FROM devices 
        WHERE device_isDelivered = 1 
        AND device_serialCode = '$itemCode'");
        
        if ($checkControl -> rowCount() >= 1) {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Este dispositivo ya fue entregado!",
            ];
            return json_encode($alert);
            exit();
        }

        $userDeliver = $this->cleanRequest($_POST['userDeliver']);
        $userDeliver = strtoupper($userDeliver);
        // ARRAY TO STORE DATA FROM FORM FIELD TO DATABASE
        $deviceRegisterData = [
            [
                "db_FieldName" => "device_userFullName",
                "db_ValueName" => ":fullName",
                "db_realValue" => $userDeliver
            ],
            [
                "db_FieldName" => "device_recievedByName",
                "db_ValueName" => ":recievedbyName",
                "db_realValue" => $recievedByName
            ],
            [
                "db_FieldName" => "device_deliveryDate",
                "db_ValueName" => ":Role",
                "db_realValue" => $deliveryDate
            ],
            [
                "db_FieldName" => "device_Description",
                "db_ValueName" => ":Description",
                "db_realValue" => $itemDescription
            ],
            [
                "db_FieldName" => "device_serialCode",
                "db_ValueName" => ":serialCode",
                "db_realValue" => $itemCode
            ],
            [
                "db_FieldName" => "device_department_ID ",
                "db_ValueName" => ":Department",
                "db_realValue" => $departmentName
            ],
            [
                "db_FieldName" => "device_RoomCode",
                "db_ValueName" => ":roomCode",
                "db_realValue" => $roomCode
            ],
            [
                "db_FieldName" => "device_isDelivered",
                "db_ValueName" => ":isDelivered",
                "db_realValue" => 1
            ],
        ];

        $addDevices = $this->saveData("devices", $deviceRegisterData);
        if ($addDevices->rowCount() >= 1) {
            $alert = [
                "type" => "clean",
                "icon" => "success",
                "title" => "¡Operación Realizada!",
                "text" => "Dispositivo entregado y registrado exitosamente!",
            ];
        } else {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Dispositivo no registrador, intente nuevamente!",
            ];
        }
        return json_encode($alert);
    }

    public function deviceListController($page, $register, $url, $search){

        $page = $this->cleanRequest($page);
        $register = $this->cleanRequest($register);

        $url = $this->cleanRequest($url);
        $url = APPURL . $url . "/";

        $search = $this->cleanRequest($search);
        $table = "";

        $page = (isset($page) && $page > 0) ? (int) $page : 1;
        $start = ($page > 0) ? (($page * $register) - $register) : 0;

        $dataRequest_Query = "SELECT * FROM devices 
        JOIN departments 
        ON devices.device_department_ID = departments.department_ID 
        WHERE (device_userFullName LIKE '%$search%' 
        OR device_recievedByName LIKE '%$search%' 
        OR device_Description LIKE '%$search%' 
        OR device_serialCode LIKE '%$search%' 
        OR device_RoomCode LIKE '%$search%' 
        OR device_department_ID LIKE '%$search%' 
        OR device_deliveryDate LIKE '%$search%')
        AND device_isDelivered = 1
        ORDER BY device_ID
        ASC LIMIT $start,$register";

        $totalData_Query = "SELECT COUNT(device_ID) FROM devices 
        JOIN departments 
        ON devices.device_department_ID = departments.department_ID 
        WHERE (device_userFullName LIKE '%$search%' 
        OR device_recievedByName LIKE '%$search%' 
        OR device_Description LIKE '%$search%' 
        OR device_serialCode LIKE '%$search%' 
        OR device_RoomCode LIKE '%$search%' 
        OR device_department_ID LIKE '%$search%' 
        OR device_deliveryDate LIKE '%$search%')
        AND device_isDelivered = 1";

        $data = $this->dbRequestExecute($dataRequest_Query);
        $data = $data->fetchAll();

        $total = $this->dbRequestExecute($totalData_Query);
        $total = (int) $total->fetchColumn();

        $numPages = ceil($total / $register);

        $table .= '<div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-3">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-base text-white uppercase bg-gray-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3">#</th>
                                    <th scope="col" class="px-6 py-3">Articulo</th>
                                    <th scope="col" class="px-6 py-3">Serial</th>
                                    <th scope="col" class="px-6 py-3">Entregado por</th>
                                    <th scope="col" class="px-6 py-3 text-center">Ver</th>
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
                        <td class="px-6 py-3 font-medium text-gray-900 uppercase">' . $rows['device_Description'] . '</td>
                        <td class="px-6 py-3">' . $rows['device_serialCode'] . '</td>
                        <td class="px-6 py-3">' . $rows['device_userFullName'] . '</td>
                        <td class="px-6 py-3 text-center">
                        <a href="' . APPURL . 'deviceDescription/' . $rows['device_ID'] . '/" class="bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-base p-2.5 text-center inline-flex items-center me-2 transition duration-100">
                            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd"/>
                            </svg>

                        </a>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <div class="flex justify-center items-center">
                                <a href="' . APPURL . 'withdrawDevice/' . $rows['device_ID'] . '/" class="bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300  rounded-full text-base p-2.5 text-center inline-flex items-center me-2 transition duration-100">
                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                                </svg>
                            </a>
                            <a href="' . APPURL . 'updateDevices/' . $rows['device_ID'] . '/" class="bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-full text-base p-2.5 text-center inline-flex items-center me-2 transition duration-100">
                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            
                            <form class="AjaxForm" action="' . APPURL . 'app/ajax/deviceAjax.php" method="POST">

                                <input type="hidden" name="deviceModule" value="deleteDevice">

                                <input type="hidden" name="device_ID" value="' . $rows['device_ID'] . '">

                                <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-base p-2.5 text-center inline-flex items-center me-2 transition duration-100">
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

    public function updateDeviceController(){
        $deviceID = $this -> cleanRequest($_POST['device_ID']);
        $deviceData = $this -> dbRequestExecute("SELECT * FROM devices WHERE device_ID = '$deviceID'");
        
        if($deviceData -> rowCount() <= 0){
            $alert=[
                "tipo"=>"simple",
                "titulo"=>"¡Error!",
                "texto"=>"Dispositivo no encontrado",
                "icono"=>"error"
            ];
            return json_encode($alert);
            exit();
        }else{
            $deviceData=$deviceData->fetch();
        }
        
        $recievedByName = $this->cleanRequest($_POST['recievedByName']);
        $itemDescription = $this->cleanRequest($_POST['itemDescription']);
        $itemCode = $this->cleanRequest($_POST['itemCode']);
        $departmentName = $this->cleanRequest($_POST['departmentName']);
        $roomCode = $this->cleanRequest($_POST['roomCode']);
        $deliveryDate = $this->cleanRequest($_POST['deliveryDate']);

        $recievedByName = strtoupper($recievedByName);
        $itemDescription = strtoupper($itemDescription);
        $itemCode = strtoupper($itemCode);
        $roomCode = strtoupper($roomCode);

        if (empty($recievedByName) || empty($itemDescription) || empty($departmentName) || empty($itemCode) || empty($roomCode) || empty($deliveryDate)) {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Algunos campos se encuentran vacios!",
            ];
            return json_encode($alert);
            exit();
        }
        
        $userDeliver = $this->cleanRequest($_POST['userDeliver']);
        $userDeliver = strtoupper($userDeliver);
        $deviceDataUpdate = [
            [
                "db_FieldName" => "device_userFullName",
                "db_ValueName" => ":fullName",
                "db_realValue" => $userDeliver
            ],
            [
                "db_FieldName" => "device_recievedByName",
                "db_ValueName" => ":recievedbyName",
                "db_realValue" => $recievedByName
            ],
            [
                "db_FieldName" => "device_deliveryDate",
                "db_ValueName" => ":Role",
                "db_realValue" => $deliveryDate
            ],
            [
                "db_FieldName" => "device_Description",
                "db_ValueName" => ":Description",
                "db_realValue" => $itemDescription
            ],
            [
                "db_FieldName" => "device_serialCode",
                "db_ValueName" => ":serialCode",
                "db_realValue" => $itemCode
            ],
            [
                "db_FieldName" => "device_department_ID ",
                "db_ValueName" => ":Department",
                "db_realValue" => $departmentName
            ],
            [
                "db_FieldName" => "device_RoomCode",
                "db_ValueName" => ":roomCode",
                "db_realValue" => $roomCode
            ],
            [
                "db_FieldName" => "device_isDelivered",
                "db_ValueName" => ":isDelivered",
                "db_realValue" => true
            ],
        ];

        $deviceCondition=[
            "condition_FieldName" => "device_ID",
            "condition_ValueName" => ":ID",
            "condition_realValue" => $deviceID
        ];

        if($this->updateData("devices", $deviceDataUpdate, $deviceCondition)){
            $alert=[
                "type"=>"reload",
                "icon"=>"success",
                "title"=>"¡Operacion Realizada!",
                "text"=>"Dispisitvo actualizado exitosamente",
            ];
        }else{
            $alert=[
                "type"=>"simple",
                "icon"=>"error",
                "title"=>"¡Error!",
                "text"=>"Error al actualizar dispositivo, intente nuevamente",
            ];
        }
        return json_encode($alert);
    }
    
    public function withdrawDeviceController(){
        $deviceID = $this -> cleanRequest($_POST['device_ID']);
        $deviceData = $this -> dbRequestExecute("SELECT * FROM devices WHERE device_ID = '$deviceID'");
        
        if($deviceData -> rowCount() <= 0){
            $alert=[
                "tipo"=>"simple",
                "titulo"=>"¡Error!",
                "texto"=>"Dispositivo no encontrado",
                "icono"=>"error"
            ];
            return json_encode($alert);
            exit();
        }else{
            $deviceData=$deviceData->fetch();
        }
        
        
        $withdrawDate = strtoupper($this->cleanRequest($_POST['withdrawDate']));
        $returnedByName = strtoupper($this->cleanRequest($_POST['returnedByName']));


        if (empty($withdrawDate) || empty($returnedByName)) {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Algunos campos se encuentran vacios!",
            ];
            return json_encode($alert);
            exit();
        }
        
        $userWithdraw = $this->cleanRequest($_POST['userWithdraw']);
        $userWithdraw = strtoupper($userWithdraw);
        $deviceDataUpdate = [
            [
                "db_FieldName" => "device_withdrawByName",
                "db_ValueName" => ":userWithdraw",
                "db_realValue" => $userWithdraw
            ],
            [
                "db_FieldName" => "device_returnedByName",
                "db_ValueName" => ":returnedByName",
                "db_realValue" => $returnedByName
            ],
            [
                "db_FieldName" => "device_withdrawalDate",
                "db_ValueName" => ":withdrawDate",
                "db_realValue" => $withdrawDate
            ],
            [
                "db_FieldName" => "device_isDelivered",
                "db_ValueName" => ":isDelivered",
                "db_realValue" => false            
            ],
        ];

        $deviceCondition=[
            "condition_FieldName" => "device_ID",
            "condition_ValueName" => ":ID",
            "condition_realValue" => $deviceID
        ];

        if($this->updateData("devices", $deviceDataUpdate, $deviceCondition)){
            $alert=[
                "type"=>"reload",
                "icon"=>"success",
                "title"=>"¡Operacion Realizada!",
                "text"=>"Dispisitvo retirado exitosamente",
            ];
        }else{
            $alert=[
                "type"=>"simple",
                "icon"=>"error",
                "title"=>"¡Error!",
                "text"=>"Error al retirar dispositivo, intente nuevamente",
            ];
        }
        return json_encode($alert);
    }

    public function deleteDevicecontroller(){
        
        $deviceID = $this->cleanRequest($_POST['device_ID']);

        $deleteDevice_Query = "DELETE FROM devices WHERE device_ID = '$deviceID'";
        $deleteDevice_SQL = $this->dbRequestExecute($deleteDevice_Query );
        if ($deleteDevice_SQL->rowCount() == 1) {
            $alert = [
                "type" => "reload",
                "icon" => "success",
                "title" => "Control Eliminado!",
                "text" => "¡Control eliminado exitosamente!"
            ];
        } else {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Error al eliminar Control, intente nuevamente!"
            ];
        }
        return json_encode($alert);
    }
}
