<?php
    require_once "../../config/app.php";
    require_once "../views/includes/sessions_start.php";
    require_once "../../autoload.php";

    use app\controllers\observationController;

    if (isset($_POST['observationModule'])) {
        
        $instanceUser = new observationController();

        if ($_POST['observationModule'] == "addObservation") {
            echo $instanceUser->addObservationcontroller();
        }
        
        if ($_POST['observationModule'] == "deleteObservation") {
            echo $instanceUser->deleteObservationcontroller();
        }
        
        if ($_POST['observationModule'] == "updateObservation") {
            echo $instanceUser->updateObservationcontroller();
        }

        if ($_POST['observationModule'] == "checkObservation") {
            echo $instanceUser->checkObservationcontroller();
        }
    
        
    } else {
        session_destroy();
        header("Location: " . APPURL . "login/");
    }