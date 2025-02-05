<?php
    require_once "../../config/app.php";
    require_once "../views/includes/sessions_start.php";
    require_once "../../autoload.php";

    use app\controllers\deviceController;

    if (isset($_POST['deviceModule'])) {
        
        $instanceDevice = new deviceController();

        if ($_POST['deviceModule'] == "addDevice") {
            echo $instanceDevice -> addDeviceController();
        }

        if ($_POST['deviceModule'] == "deleteDevice") {
            echo $instanceDevice -> deleteDeviceController();
        }

        if ($_POST['deviceModule'] == "updateDevice") {
            echo $instanceDevice -> updateDeviceController();
        }

        if ($_POST['deviceModule'] == "updateWithdrawDevice") {
            echo $instanceDevice -> updateWithdrawDeviceController();
        }
        
        if ($_POST['deviceModule'] == "withdrawDevice") {
            echo $instanceDevice -> withdrawDeviceController();
        }
        
    } else {
        session_destroy();
        header("Location: " . APPURL . "login/");
    }