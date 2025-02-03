<?php
    require_once "../../config/app.php";
    require_once "../views/includes/sessions_start.php";
    require_once "../../autoload.php";

    use app\controllers\departmentsController;

    if (isset($_POST['departmentModule'])) {
        
        $instanceUser = new departmentsController();

        if ($_POST['departmentModule'] == "addDepartment") {
            echo $instanceUser->addDepartmentsController();
        }
        
        if ($_POST['departmentModule'] == "deleteDepartment") {
            echo $instanceUser->deleteDepartmentsController();
        }
        
        if ($_POST['departmentModule'] == "updateDepartment") {
            echo $instanceUser->updateDepartmentsController();
        }
    
        
    } else {
        session_destroy();
        header("Location: " . APPURL . "login/");
    }