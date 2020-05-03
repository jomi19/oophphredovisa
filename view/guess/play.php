<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<div class="game">
<h1>Play the game</h1>
<p>Guess a number between 1 and 100, you have <?=$_SESSION["guessgame"]->tries() ?> guesses left.</p>
<form method="post" action="process">
    <input type="number" name="guessnumb" value="1" required>
    <button type="submit" name="option" value="guess" <?=$_SESSION["disabled"] ?>>Make a guess</button>
    <button type="submit" name="option" value="reset">Reset the game</button>
    <button type="submit" name="option" value="cheat" class="cheat" <?=$_SESSION["disabled"] ?>>Cheat!</button>
</form>
<div class="message"><?= $message ?></div>
<div class="guesses"><?=  $guesses ?></div>
</div>