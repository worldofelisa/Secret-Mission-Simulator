<?php

class Dice
{
    function diceForRolling($dice)
    {
        switch($dice)
        {
            case "d4":
                return rand(1, 4);
            case "d6":
                return rand(1, 6);
            case "d8":
                return rand(1, 8);
            case "d10":
                return rand(1, 10);
            case "d12":
                return rand(1, 12);
            case "d20":
                return rand(1, 20);
            case "d100":
                return rand(1, 100);
        }
    }
}

class Characters
{

}


class User extends Characters
{
    private $name;

    /**
     * @return void
     */
    public function setName()
    {
        echo "What is your name, agent?\n";
        $this->name = readline(">> ");
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->name;
    }
}

class Team extends Characters
{
    public $team = [];


    public function createTeam()
    {
        $rollTheDice = new Dice();
        $diceValue = $rollTheDice->diceForRolling("d4");
        if (array_key_exists($diceValue, $this->team))
        {
            echo "No one else wants to work with you. Let's move on.\n";
            return false;

        }
        switch($diceValue)
        {
            case 1:
                $teamMemberName = "Alec";
                echo "Meet Alec Aldis, tech wizard extraordinaire. Having him inside with you will definitely help.\n";
                $this->team[$diceValue] = $teamMemberName;
                break;
            case 2:
                $teamMemberName = "Mary";
                echo "Meet Mary Monroe. Whatever you need: distractions, fighting, aerialist skills, she can do it.\n";
                $this->team[$diceValue] = $teamMemberName;
                break;
            case 3:
                $teamMemberName = "Kane";
                echo "Meet Kane Spencer. No one has gone up against his fists and walked away. No one.\n";
                $this->team[$diceValue] = $teamMemberName;
                break;
            case 4:
                $teamMemberName = "AJ";
                echo "Meet AJ. Wanted by countless worldwide agencies for various... misunderstandings. You're lucky to have them.\n";
                $this->team[$diceValue] = $teamMemberName;
                break;
        }
        return true;
    }

    public function countTeam()
    {
        $teamNumber = count($this->team);
        return $teamNumber;
    }
}

class Story
{

    public $teamMembers;
    public $teamSize;
    private $vaultCode = [];
    const MAX_VAULT_CODE = 9;

    /**
     * Sets up the vault numbers to be three random numbers and stores them into the private array.
     * @return void
     */
    public function __construct()
    {
        for ($a = 0; $a < 3; $a++) {
            $this->vaultCode = [rand(1, self::MAX_VAULT_CODE), rand(1, self::MAX_VAULT_CODE), rand(1, self::MAX_VAULT_CODE)];
        }
    }

    /**
     * Starts the mission, calls to User class for name then starts the mission.
     * @return void
     */
    public function startMission()
    {
        $username = new User();
        $username->setName();
        $name = $username->index();
        echo "Welcome, Agent $name. Are you ready to start your mission?\nRespond yes or no:\n";
        $response = readline(">> ");
        if ($response !== "yes") {
            exit("I see. On your way then.\n");
        } else {
            echo "Good. Let's get started.\n";
            echo "You will be breaking into Currency Keepers, one of the biggest banks in the city.\n";
            echo "Given your reputation, this shouldn't be hard for you. Now, shall we go meet the team?\n";
        }
    }

    public function meetTheTeam()
    {
        $pickTeam = new Team();
        echo "There are four potential team members. At least one will work with you.\n";
        echo "Roll the die to see how many team members you will get.\n";
        echo "To roll, type roll in now:\n";
        $response = readline(">> ");

        if ($response != "roll") {
            exit("We only send in teams. Maybe you aren't right for this job after all.\n");
        } else
        {
            $moreTeam = false;
           do
           {
               $team = $pickTeam->createTeam();
               if (!$team)
               {
                   $moreTeam = false;
                   continue;
               }

               echo "Do you want another teammate? Type yes or no in now:\n";
               $extraMember = readline(">> ");

               if ($extraMember == "no") {
                   $moreTeam = false;
                   return;
               } else
               {
                   $moreTeam = true;
               }
           } while ($moreTeam);

        }

        $teamNumber = $pickTeam->countTeam();
        $this->teamMembers = $teamNumber;
        $this->teamSize = $teamNumber + 1;
        echo "You have $this->teamMembers members in your team.\nHopefully the $this->teamSize of you can do it.\n";
        echo "Now that you have your team, let's go break into a bank!\n";
    }
}



$story = new Story();
$story->startMission();
$story->meetTheTeam();