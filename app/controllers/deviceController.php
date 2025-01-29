<?php

    namespace app\controllers;
    use app\models\mainModel;

    class deviceController extends mainModel{

        public function getDepartmentsController(){
            $getDepartments_Query = "SELECT * FROM departments";
            $getDepartments_SQL = $this -> dbRequestExecute($getDepartments_Query);
            $getDepartments_SQL -> execute();
            return $getDepartments_SQL;
        }
    }

?>