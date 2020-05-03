<?php
/**
 * Create routes using $app programming style.
 */

/**
 * Init the game and redirect to play.
 */
$app->router->get("guess/start", function () use ($app) {

    // Init the game
    $_SESSION["guessgame"] = new Joakim\Guess\Guess();
    $_SESSION["guesses"] = [];
    $_SESSION["disabled"] = "";

    return $app->response->redirect("guess/play");
});

/**
 * Play the guessing game.
 */
$app->router->get("guess/play", function () use ($app) {
    $g_array = $_SESSION["guessgame"]->guesses();
    $guesses = "";
    if (count($g_array) > 0) {
        foreach ($g_array as $guess) {
            $guesses = $guesses . $guess . ", " ;
        }
        $guesses = rtrim($guesses, ", ");
    }


    $data = [
        "title" => "Gissa nummret",
        "guesses" => $guesses,
        "message" => $_SESSION["message"] ?? null
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render();
});



/**
 * Prossesing data from guess game.
 */
$app->router->post("guess/process", function () use ($app) {
    if (isset($_POST["guessnumb"])) {
        $option = $_POST["option"];
        $guess = intval($_POST["guessnumb"]);
        if ($option === "cheat") {
            $message = $_SESSION["guessgame"]->number();
        } else if ($option === "reset") {
            $_SESSION["guessgame"]->random();
            $_SESSION["disabled"] = "";
            $message = "Game reseted";
        } else if ($option === "guess") {
            try {
                $message = $_SESSION["guessgame"]->makeGuess($guess);
            } catch (GuessException $e) {
                $message = $e->getMessage();
            }
        }
    
    
        //Disables the buttons if you guess correct or are out of guesses
        if ($_SESSION["guessgame"]->tries() === 0 or $message === "Correct guess") {
            $_SESSION["disabled"] = "disabled";
        }
        $_SESSION["option"] = $option;
        $_SESSION["message"] = $message;
    }
    return $app->response->redirect("guess/play");
});
