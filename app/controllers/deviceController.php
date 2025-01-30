<?php

namespace app\controllers;

use app\models\mainModel;

class deviceController extends mainModel
{

    public function getDepartmentsController()
    {
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

        $checkControl = $this -> dbRequestExecute("SELECT device_serialCode FROM devices WHERE device_serialCode = '$itemCode'");
        if ($checkControl -> rowCount() >= 1) {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Este dispositivo ya fue entregado anteriormente!",
            ];
            return json_encode($alert);
            exit();
        }

        $userDeliver = $this->cleanRequest($_POST['userDeliver']);
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
}
