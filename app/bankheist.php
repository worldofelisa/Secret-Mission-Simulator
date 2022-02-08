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

class User
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

class Team
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
    public $agentName;
    public $teamMembers;
    public $teamSize;
    public $moneyTotal;
    private $vaultCode = [];
    const MAX_VAULT_CODE = 3;

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
        $this->agentName = $username->index();
        echo "Welcome, Agent $this->agentName. Are you ready to start your mission?\nRespond yes or no:\n";
        $response = readline(">> ");
        if ($response !== "yes") {
            exit("I see. On your way then.\n");
        } else {
            echo "Good. Let's get started.\n";
            echo "You will be breaking into Currency Keepers, one of the biggest banks in the city.\n";
            echo "Given your reputation, this shouldn't be hard for you. Now, shall we go meet the team?\n";
        }
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function trickTheGuards()
    {
        echo "Time to move inside the bank. Let's see if you can make it past the guards.\n";
        echo "Roll a die to see if you can evade the guards. To roll, type roll in now:\n";
        $rollTheDice = new Dice();
        $response = readline(">> ");

        if ($response != "roll")
        {
            exit("The bank is closed. Go home.\n");
        } else
        {
            $rollResult = $rollTheDice->diceForRolling("d100");
        }

        if ($this->teamSize == 5)
        {
            $disadvantage = $rollTheDice->diceForRolling("d100");
            $newResult = min($rollResult, $disadvantage);
            $diceResult = $newResult;
        } elseif ($this->teamSize == 4)
        {
            $diceResult = $rollResult - 10;
        }elseif ($this->teamSize == 2)
        {
            $diceResult = $rollResult + 10;
        } else
        {
            $diceResult = $rollResult;
        }

        switch (true)
        {
            case $diceResult <= 25:
                exit("Heist unsuccessful.\nThe gun fell out of your pocket as you entered the bank.\nThe guards noticed and arrested you and your team immediately.\nYou are now in jail... and you may need some protection!\n");
                break;
            case $diceResult <= 50:
                exit("Heist unsuccessful.\nThe guards found you suspicious. You and your team left the bank for fear of being caught. Try again another time.\n");
                break;
            case $diceResult <= 100:
                echo "You're in. Well done! You tricked the guards, who are none the wiser. Now let's see if you can get to the vault.\n";
                break;

        }
    }

    /**
     * @return void
     */
    public function timeToStart()
    {
        echo "You and your team need to distract the staff so you can sneak down to the vault.\n";
        echo "Roll to see how distracting your team is. Type roll in now:\n";
        $rollTheDice = new Dice();
        $response = readline(">> ");

        if ($response != "roll")
        {
            exit("Heist Unsuccessful. You and your team members begin to argue over who is meant to distract the staff. The guards hear you and arrest you. Good luck explaining this one!\n");
        } else
        {
            $diceResult = $rollTheDice->diceForRolling("d20");
        }

        if ($diceResult >= 15)
        {
            echo ("Your team member successfully distracts the staff. You are able to slip into a back door and make your way to the vault.\n");
        } elseif ($diceResult >= 5)
        {
            echo "The staff are suspicious. Do you want to sacrifice a teammate to succeed?\nRespond yes or no:";
            $response = readline(">> ");
            if ($response != "yes")
            {
                exit("Well... you stuck with your team... and the police were called.\nLet's hope chivalry is rewarded in prison, because it did you no good this time.\n");
            }else
            {
                $this->teamMembers = $this->teamMembers - 1;
                $this->teamSize = $this->teamSize -1;
                echo "You give up one of your team members, and successfully make it past the staff.\nHopefully this won't come back to bite you.\n";
            }

        }else
        {
            exit("The staff were suspicious and hit the alarm. You and your team made it out... barely. Try again another time.\n");
        }

        echo "You currently have $this->teamMembers in your team.\nThis puts your team size at $this->teamSize.\nKeep that in mind for the future.\n";
    }

    /**
     * @return void
     */
    public function openVault()
    {
        echo "You get past the vault, you will have to guess the code.\n";
        echo "There are three numbers in the lock combination between 1-" . self::MAX_VAULT_CODE . ". You must correctly guess all three for the lock to open.\n";
        echo "Be warned - you will only have three chances at each number before the vaults secondary locks are activated and the alarm is triggered.\n";
        echo "Good luck Agent. Begin your guesses now:\n";

        $yes = "Congratulations, you got it!\n";
        $no = "Incorrect passcode. Please try again.\n";
        $passCode = 1;
        $codeAttempt = 1;

        while ($passCode <= count($this->vaultCode))
        {
            $vaultGuess = readline(">> ");
            if ($vaultGuess != $this->vaultCode[$passCode - 1])
            {
                $codeAttempt++;
                echo $no;

                if ($codeAttempt > 3)
                {
                    exit("Too many incorrect passcodes. Vault is now locked. You run as the alarm begins to sound, straight into the arms of the guards.\nHeist unsuccessful.\nBetter luck next time.\n");
                }
            } else
            {
                unset($codeAttempt);
                $codeAttempt = 1;
                echo $yes;
                $result[] = $vaultGuess;
                $passCode++;

                if (count($result) == 3)
                {
                    echo "You successfully guessed $result[0], $result[1], $result[2] and have cracked the code. Well done Agent $this->name!\n";
                    break;
                }
            }
        }
    }

    public function getMoney()
    {
        $rollTheDice = new Dice();
        echo "The vault is open. Do you want to leave now?\n";
        $response = readline(">> ");

        if ($response == "yes")
        {
            exit("You got away... but you forgot to take money with you. So much for a heist. We'll hire better people next time.\n");
        } else
        {
            echo "Let's grab the money then!\n";
        }

        echo "You are grabbing the money. Do you want to send your team member out now?\n";
        $response = readline(">> ");

        if ($response == "yes")
        {
            echo "Your team member was sent out too early. They run into cops on their break as they try to leave and you are all arrested.\n";
            if ($this->teamSize > 1)
            {
                echo "Do you want to sacrifice your team member to continue?\n Type yes or no in now:\n";
                $response = readline(">> ");
                if ($response != "yes")
                {
                    exit("Heist unsuccessful.\n");
                } else
                {
                    $this->teamSize = $this->teamSize - 1;
                    $this->teamMembers = $this->teamMembers - 1;
                    echo "Your teammate has been successfully arrested but is none the wiser to your plan.\nLet's continue.\n";
                }
            }
        } else
        {
            $result = $rollTheDice->diceForRolling("d10");
            echo "With the help of your partner you acquire \$" . $result . ",000.";
        }

        echo "Do you want to send your team member out now?\n";
        $response = readline(">> ");

        if ($response == "no")
        {
            echo "Roll the die to see how much more money you get. Type roll in now:\n";
            readline(">> ");
            $money = $rollTheDice->diceForRolling("d10");
            echo "You have an extra \$" . $money . ",000 in your stash now!";
            $total = $result * 1000 + $money * 1000;
            exit("As you go to leave the bank with your \$" . $total . " you realize no one prepped the get away car.\nAs you climb inside you find yourself surrounded by the police, who have by now been alerted by the bank manager.\nHeist unsuccessful.\nEnjoy prison!");
        } else
        {
            $money = $rollTheDice->diceForRolling("d4");
            $this->moneyTotal = $result * 1000 + $money * 1000;
            echo "Good. Your teammate leaves to go start the get away car.\nYou manage to get a bit more money into the bag before you follow after them.\n";
        }
    }

    public function leaveSafely()
    {
        $rollTheDice = new Dice();
        echo "While you finish in the bank, your teammate attempts to start the car. Roll to see how successful they are:\n";
        start:
        $response = readline(">> ");

        if ($response == "roll")
        {
            $result = $rollTheDice->diceForRolling("d4");
            switch ($result)
            {
                case 1:
                    echo "The car does not start. As you hear the alarm inside the bank begin to sound, you both get out and flee on foot, agreeing to meet up at base.\n";
                    $footrace = new Ending();
                    $footrace->footRace();
                    echo "You arrive at the rendezvous spot and count the money.\nYou manage to get away with $this->moneyTotal\n";
                    exit("Well done, Agent $this->agentName. We look forward to working with you again in the future.\nNow take your money and go.\n");
                    break;
                case 2:
                    if ($this->teamMembers > 1)
                    {
                        echo "The car does not start. Your teammate looks at you, offering themselves up as bait for the police.\nDo you send them out?\nRespond yes or no:";
                        $response = readline(">> ");
                        if ($response != "yes")
                        {
                            exit("As you argue with them about being a martyr, the police close in on the car.\nYou are both arrested, and the money is returned to the bank.\nBetter luck next time!");
                        }else
                        {
                            $this->teamMembers = $this->teamMembers - 1;
                            $this->teamSize = $this->teamSize - 1;
                            echo "You let your teammate run out of the car, successfully distracting the police.\n";
                            echo "Your team is now $this->teamSize and you currently have $this->teamMembers team members";
                            echo "The car starts and you drive away.\nYou go back to base, where you hand over your prize.\n You manage to get away with $this->moneyTotal";
                            exit("Well done, Agent $this->agentName. We look forward to working with you again in the future.\nNow take your money and go.\n");
                        }
                    }else
                    {
                        echo "The car does not start. As you hear the alarm inside the bank begin to sound, you get out and flee on foot, trying to make it back to the base.\n";
                        $footrace = new Ending();
                        $footrace->footRace();
                        echo "You arrive at the rendezvous spot and count the money.\nYou manage to get away with $this->moneyTotal\n";
                        exit("Well done, Agent $this->agentName. We look forward to working with you again in the future.\nNow take your money and go.\n");
                    }
                    break;
                case 3:
                    echo "You car is idling as you leave the bank.\n You hop in and begin to drive away, but the police close in on you and begin to give chase.\n";
                    $carChase = new Ending();
                    $carChase->carChase();
                    echo "You arrive at the rendezvous spot and count the money.\nYou manage to get away with $this->moneyTotal\n";
                    exit("Well done, Agent $this->agentName. We look forward to working with you again in the future.\nNow take your money and go.\n");
                    break;
                case 4:
                    echo "The car is idling as you leave the bank. You hop in and drive away.\nYou go back to base, where you hand over your prize.\n You manage to get away with $this->moneyTotal";
                    exit("Well done, Agent $this->agentName. We look forward to working with you again in the future.\nNow take your money and go.\n");
                    break;
            }
        } else
        {
            echo "This is no time to play around! Roll now!";
            goto start;
        }
    }
}

class Ending
{
    public function footRace()
    {
        $rollTheDice = new Dice();
        echo "The police begin to chase you. You now need to roll off against the police to see if you escape. Type roll in now:\n";
        $response = readline(">> ");

        if ($response != "roll")
        {
            exit("You didn't even try to escape... but it didn't make the judge any less sympathetic. Enjoy prison!\n");
        } else
        {
            $userRoll = $rollTheDice->diceForRolling("d20");
            $policeRoll = $rollTheDice->diceForRolling("d20");

            if ($userRoll > $policeRoll)
            {
                echo "You escape to the rendezvous spot and count out the money.";
                return;
            } elseif ($userRoll < $policeRoll)
            {
                exit("The police are faster than you. They manage to tackle you to the ground, wrestling the money away. You are arrested... better luck next time!\n");
            } elseif ($userRoll == $policeRoll)
            {
                echo "The police close the distance. You throw the money at them, as a diversion. It works, and they stop to collect that, leaving you time to get away.\n";
                exit("You may have failed to get money, but at least you are free. You lay low for a while, biding your time until you can try again.\nBetter luck next time.\n");
            }
        }
    }

    public function carChase()
    {
        $rollTheDice = new Dice();
        echo "The police are hot on your heels. You now need to roll off against the police to see if you escape. Type roll in now:\n";
        $response = readline(">> ");

        if ($response != "roll")
        {
            exit("You didn't even try to escape... but it didn't make the judge any less sympathetic. Enjoy prison!\n");
        } else
        {
            $userRoll = $rollTheDice->diceForRolling("d20");
            $policeRoll = $rollTheDice->diceForRolling("d20");

            if ($userRoll > $policeRoll)
            {
                echo "You escape to the rendezvous spot and count out the money.";
                return;
            } elseif ($userRoll < $policeRoll)
            {
                echo "You were too focused on the police and not focused enough on the car. You crash into a wall. Roll to see if you survive:\n";
                $response = readline(">> ");
                if ($response == "roll")
                {
                    $survival = $rollTheDice->diceForRolling("d20");
                    if ($survival >= 10)
                    {
                        exit("You survive, but are arrested. You are taken to the hospital, stabilised, and then put in prison.\nBetter luck next time.\n");
                    } else
                    {
                        exit("You do not survive the crash, your vision blacking out just as you crash through the windshield.\nConsider wearing a seatbelt next time.\n");
                    }
                } else
                {
                    exit("Your body was lodged in the car, and as you tried to assess the damage, you feel yourself forcibly ripped from the vehicle.\nEnjoy prison time.\n");
                }
            } elseif ($userRoll == $policeRoll)
            {
                echo "The police close the distance. To try and get away, you jump from the car as it slows on a turn, bag on money in hand.\nContinue on foot.";
                $this->footRace();
            }
        }
    }
}




$story = new Story();
$story->startMission();
$story->meetTheTeam();
$story->trickTheGuards();
$story->timeToStart();
$story->openVault();
$story->getMoney();
$story->leaveSafely();

