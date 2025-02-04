<?php
    require_once "../../config/app.php";
    require_once "../views/includes/sessions_start.php";
    require_once "../../autoload.php";

    use app\controllers\departmentsController;

    if (isset($_POST['departmentModule'])) {
        
        $instanceDepartments = new departmentsController();

        if ($_POST['departmentModule'] == "addDepartment") {
            echo $instanceDepartments->addDepartmentsController();
        }
        
        if ($_POST['departmentModule'] == "deleteDepartment") {
            echo $instanceDepartments->deleteDepartmentsController();
        }
        
        if ($_POST['departmentModule'] == "updateDepartment") {
            echo $instanceDepartments->updateDepartmentsController();
        }
    
        
    } else {
        session_destroy();
        header("Location: " . APPURL . "login/");
    }