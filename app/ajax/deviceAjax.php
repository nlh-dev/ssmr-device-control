<?php
    require_once "../../config/app.php";
    require_once "../views/includes/sessions_start.php";
    require_once "../../autoload.php";

    use app\controllers\observationController;

    if (isset($_POST['deviceModule'])) {
        
        $instanceUser = new observationController();

        if ($_POST['deviceModule'] == "addObservation") {
            echo $instanceUser->addObservationcontroller();
        }
    
        
    } else {
        session_destroy();
        header("Location: " . APPURL . "login/");
    }