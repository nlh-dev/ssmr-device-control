<?php

require_once "./config/app.php";
require_once "./app/views/includes/sessions_start.php";
require_once "./autoload.php";

if (isset($_GET['views'])) {
    $url = explode("/", $_GET['views']);
} else {
    $url = ["login"];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- HEAD IMPORTS -->
    <?php require_once "./app/views/includes/head.php" ?>
</head>

<body>
    <?php

    use app\controllers\observationController;
    use app\controllers\loginController;
    use app\controllers\viewsController;

    $instanceObservations = new observationController();

    $instanceLogin = new loginController();

    $viewsController = new viewsController();
    $views = $viewsController->obtainViews($url[0]);

    if ($views == "login" || $views == "404") {
        require_once "./app/views/content/" . $views . "-view.php";
    } else {
        //LOG OUT SESSION
        if((!isset($_SESSION['ID']) || $_SESSION['ID'] == "") || (!isset($_SESSION['userName']) || $_SESSION['userName'] == "")){
            $instanceLogin->singOutController();
            
        }
        require_once $views;
        require_once "./app/views/layouts/sidebar.php";
    }

    require_once "./app/views/includes/script.php";
    ?>
</body>

</html>