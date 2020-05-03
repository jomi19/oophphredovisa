<p>Guess a number between 1 and 100, you have <?=$_SESSION["guessgame"]->tries() ?> guesses left.</p>
<form method="post" action="process.php">
    <input type="number" name="guessnumb" value="1" required>
    <button type="submit" name="option" value="guess" <?=$_SESSION["disabled"] ?>>Make a guess</button>
    <button type="submit" name="option" value="reset">Reset the game</button>
    <button type="submit" name="option" value="cheat" class="cheat" <?=$_SESSION["disabled"] ?>>Cheat!</button>
</form>