<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/contact.php";

    session_start();
    if(empty($_SESSION["list_of_contacts"])) {
        $_SESSION["list_of_contacts"] = array();
    }

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        "twig.path" => __DIR__."/../views"
    ));

    $app->get("/", function() use ($app) {
        return $app["twig"]->render("home.html.twig", array("contacts" => Contact::getAll()));
    });

    $app->post("/form_submit", function() use ($app) {
        $newContact = new Contact($_POST['input-name'], $_POST['input-phone'], $_POST['input-address']);
        $newContact->save();
        return $app["twig"]->render("create_contact.html.twig", array("contacts" => Contact::getAll()));
    });

    $app->get("/clear_list", function() use ($app) {
        Contact::deleteAll();
        return $app["twig"]->render("delete_contacts.html.twig");
    });
 ?>
