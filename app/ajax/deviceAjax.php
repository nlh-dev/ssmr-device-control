<?php
    require_once "../../config/app.php";
    require_once "../views/includes/sessions_start.php";
    require_once "../../autoload.php";

    use app\controllers\deviceController;

    if (isset($_POST['deviceModule'])) {
        
        $instanceDevice = new deviceController();

        if ($_POST['deviceModule'] == "addDevice") {
            echo $instanceDevice -> addDevicecontroller();
        }
    } else {
        session_destroy();
        header("Location: " . APPURL . "login/");
    }