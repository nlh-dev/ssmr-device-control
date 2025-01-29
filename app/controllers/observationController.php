<?php
    namespace app\controllers;
    use app\models\mainModel;

class observationController extends mainModel{
    
    public function addObservationcontroller(){
        
        // STORING DATA SENT BY THE FORM
        $observationReason = $this->cleanRequest($_POST['observationReason']);
        $observationText = $this->cleanRequest($_POST['observationText']);
        $observationDate = $this->cleanRequest($_POST['observationDate']);
        
        
        // VERIFYING IF THE DATA IS EMPTY
        if (empty($observationReason) || empty($observationText) || empty($observationDate)) {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Algunos campos se encuentran vacíos!",
            ];
            echo json_encode($alert);
            exit();
        }
        // ARRAY TO STORE DATA FROM FORM FIELD TO DATABASE
        $userName = $this -> cleanRequest($_POST['userName']);
        $observationRegisterData = [
            [
                "db_FieldName" => "observation_user",
                "db_ValueName" => ":userName",
                "db_realValue" => $userName
            ],
            [
                "db_FieldName" => "observation_reason",
                "db_ValueName" => ":Reason",
                "db_realValue" => $observationReason
            ],
            [
                "db_FieldName" => "observation_text",
                "db_ValueName" => ":Text",
                "db_realValue" => $observationText
            ],
            [
                "db_FieldName" => "observation_creationDate",
                "db_ValueName" => ":creationDate",
                "db_realValue" => $observationDate
            ],
        ];

        $addObservation = $this->saveData("observations", $observationRegisterData);
        if ($addObservation->rowCount() >= 1) {
            $alert = [
                "type" => "clean",
                "icon" => "success",
                "title" => "¡Operación Realizada!",
                "text" => "¡Observación registrada exitosamente!",
            ];
        } else {
            $alert = [
                "type" => "simple",
                "icon" => "error",
                "title" => "¡Error!",
                "text" => "¡Error al registrar observación!",
            ];
        }
        return json_encode($alert);
    }

    public function observationListController(){
        
    }
}
?>