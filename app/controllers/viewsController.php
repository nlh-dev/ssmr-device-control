<?php

    namespace app\controllers;
    use app\models\viewsModel;

    // Controller to obtain views from Model
    class viewsController extends viewsModel{
        
        public function obtainViews($views){
            
            if ($views != "") {
                $response = $this -> obtainViewsModel($views);
            } else {
                $response = "login";
            }
            return $response;
        }
    }