<?php
namespace Joakim\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */
    private $number;
    private $tries;
    private $guesses;


    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */
    public function __construct(int $number = -1, int $tries = 6)
    {
        if ($number === -1) {
            $number = rand(1, 100);
        }
        $this->number = $number;
        $this->tries = $tries;
        $this->guesses = [];
    }




    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */
    public function random()
    {
        $this->tries = 6;
        $this->guesses = (array) null;
        $this->number = rand(1, 100);
    }




    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */
    public function tries()
    {
        return $this->tries;
    }

    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */
    public function number()
    {
        return $this->number;
    }


    /**
     * Gets the guesses array
     *
     * @return array with you previus guesses
     */
    public function guesses()
    {
        return $this->guesses;
    }



    /**
     * Make a guess, cheking so its an unique guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */
    public function makeGuess($number)
    {
        if ($number < 1 or $number > 100) {
            throw new GuessException("Your guess needs to be between or 1 and 100");
        }
        if (!in_array($number, $this->guesses)) {
            array_push($this->guesses, $number);
            
            if ($number === $this->number) {
                return "Correct guess";
            } else if ($this->tries === 1) {
                $this->tries = $this->tries - 1;
                return "You are out of guesses, correct answer were {$this->number}";
            } else if ($number > $this->number) {
                $this->tries = $this->tries - 1;
                return "Your guess was to high";
            } else {
                $this->tries = $this->tries - 1;
                return "Your guess was to low";
            }
        } else {
            return "You have guessed on {$number} before.";
        }
    }
}
