<?php

namespace app\models;

class viewsModel
{

    // Model to obtain views from controller
    protected function obtainViewsModel($views)
    {

        $viewsList = [
        "home", 
        "logout",
        "devicePanel", 
        "addDevice", 
        "deviceStorage",
        "deviceDescription",
        "withdrawDevice",
        "updateDevices",
        "observations",
        "addObservation",
        "observationDescription",
        "updateObservations",
        "users",
        "addUsers",
        "updateUsers",
        "departments",
        "addDepartments",
        ];

        if (in_array($views, $viewsList)){
            if (is_file("./app/views/content/".$views."-view.php")) {
                $content = "./app/views/content/".$views."-view.php";
            }else {
                $content = "404";
            }
        }elseif ($views == "login" || $views == "index") {
            $content = "login";
        }else {
            $content = "404";
        }

        return $content;
    }
}
