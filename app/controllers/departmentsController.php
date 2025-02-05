<?php

namespace app\controllers;

use app\models\mainModel;

class departmentsController extends mainModel{

    public function getDepartmentsController(){
        $getDepartments_Query = "SELECT * FROM departments";
        $getDepartments_SQL = $this->dbRequestExecute($getDepartments_Query);
        $getDepartments_SQL->execute();
        return $getDepartments_SQL;
    }

    public function addDepartmentsController(){
        $departmentName = strtoupper($this->cleanRequest($_POST['departmentName']));

        if (empty($departmentName)) {
            $alert = [
                "type" => "simple",
                "icon" => "warning",
                "title" => "¡Error al crear Departamento!",
                "text" => "¡El campo se encuentra vacio!",
            ];
            return json_encode($alert);
            exit();
        }

        $checkDepartment = $this->dbRequestExecute("SELECT * FROM departments WHERE department_Name = '$departmentName'");

        if ($checkDepartment->rowCount() >= 1) {
            $alert = [
                "type" => "simple",
                "icon" => "warning",
                "title" => "¡Error al crear Departamento!",
                "text" => "¡Este Departamento ya fue registrado!",
            ];
            return json_encode($alert);
            exit();
        }

        $departmentRegisterData = [
            [
                "db_FieldName" => "department_Name",
                "db_ValueName" => ":departmentName",
                "db_realValue" => $departmentName
            ],
        ];

        $addDepartment = $this->saveData("departments", $departmentRegisterData);
        if ($addDepartment->rowCount() >= 1) {
            $alert = [
                "type" => "reload",
                "icon" => "success",
                "title" => "¡Operación Realizada!",
                "text" => "Departamento registrado exitosamente!",
            ];
        } else {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Error al registrar departamento!",
            ];
        }
        return json_encode($alert);
    }

    public function departmentsListController($page, $register, $url, $search){

        $page = $this->cleanRequest($page);
        $register = $this->cleanRequest($register);

        $url = $this->cleanRequest($url);
        $url = APPURL . $url . "/";

        $search = $this->cleanRequest($search);
        $table = "";

        $page = (isset($page) && $page > 0) ? (int) $page : 1;
        $start = ($page > 0) ? (($page * $register) - $register) : 0;

        $dataRequest_Query = "SELECT * FROM departments 
            WHERE department_Name LIKE '%$search%' 
            ORDER BY department_Name ASC LIMIT $start,$register";

        $totalData_Query = "SELECT COUNT(department_ID) FROM departments 
            WHERE department_Name LIKE '%$search%'";

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
                                        <th scope="col" class="px-6 py-3">Nombre del Departamento</th>
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
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-200">
                            <td class="px-6 py-3 uppercase"> ' . $counter . ' </td>
                            <td class="px-6 py-3 uppercase">' . $rows['department_Name'] . '</td>
                            <td class="px-6 py-3 flex items-center text-center">
                                <a href="' . APPURL . 'updateDepartment/' . $rows['department_ID'] . '/" class="bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-full text-base p-2.5 text-center inline-flex items-center me-2 transition duration-100">
                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd" />
                                        <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                
                                <form class="AjaxForm" action="' . APPURL . 'app/ajax/departmentsAjax.php" method="POST">
    
                                    <input type="hidden" name="departmentModule" value="deleteDepartment">
    
                                    <input type="hidden" name="department_ID" value="' . $rows['department_ID'] . '">
    
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
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-200" >
                            <td colspan="6">
                            <div class= "flex justify-center items-center my-4">
                                No se encontraron registros en esta pagina
                            </div>
                            <div class= "flex justify-center items-center my-4">
                                <a href="' . $url . '1/" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                    Haz click aqui para recargar
                                </a>
                            </div>
                            </td>
                        </tr>
                    ';
            } else {
                $table .= '
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-200">
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

    public function deleteDepartmentsController(){

        $departmentID = $this->cleanRequest($_POST['department_ID']);

        $checkDeleteDepartments_Query = "SELECT * FROM devices WHERE device_department_ID = '$departmentID'";
        $checkDeleteDepartments_SQL = $this->dbRequestExecute($checkDeleteDepartments_Query);
        if ($checkDeleteDepartments_SQL->rowCount() > 0) {
            $alert = [
                "type" => "simple",
                "icon" => "warning",
                "title" => "¡Departamento no Eliminado!",
                "text" => "¡No pudes eliminar este departamento!"
            ];
            return json_encode($alert);
            exit();
        }

        $deleteDepartment_Query = "DELETE FROM departments WHERE department_ID = $departmentID";
        $deleteDepartment_SQL = $this->dbRequestExecute($deleteDepartment_Query);
        if ($deleteDepartment_SQL->rowCount() == 1) {
            $alert = [
                "type" => "reload",
                "icon" => "success",
                "title" => "¡Departamento Eliminado!",
                "text" => "¡Departamento eliminado exitosamente!"
            ];
        } else {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Error al eliminar Departamento, intente nuevamente!"
            ];
        }
        return json_encode($alert);
    }

    public function updateDepartmentsController(){

    }
}
