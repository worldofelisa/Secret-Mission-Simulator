<?php

class Dice
{
    function diceForRolling($dice)
    {
        switch($dice)
        {
            case "d4":
                return rand(1,4);
            case "d6":
                return rand(1,6);
            case "d8":
                return rand(1,8);
            case "d10":
                return rand(1,10);
            case "d12":
                return rand(1,12);
            case "d20":
                return rand(1,20);
            case "d100":
                return rand(1,100);
        }
    }
}

class Story
{
    private $team = [];
    private $vaultCode = [];
    private $name;

    const MAX_VAULT_CODE = 3;

    public function __construct()
{
    for ($a = 0; $a < 3; $a++)
    {
        $this->vaultCode = [rand(1, self::MAX_VAULT_CODE), rand(1,self::MAX_VAULT_CODE), rand(1,self::MAX_VAULT_CODE)];
    }
}

    /**
     * @return void
     */
    public function setName()
    {
        echo "What is your name, agent?\n";
        $this->name = readline(">> ");
    }

    /**
     * @return void
     */
    public function startMission()
    {
        echo "Welcome, Agent $this->name. Are you ready to start your mission? \nRespond yes or no:\n";
        $response = readline("\n" . ">> " );
        if ($response == "no")
        {
            exit("I see. On your way then.\n");
        } else
        {
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
        $rollTheDice = new Dice();
        echo "There are four potential team members. At least one will work with you.\n";
        echo "Roll the die to see how many team members you will get.\n";
        echo "To roll, type roll in now:\n";
        $response = readline(">> ");

        if($response != "roll")
        {
            exit("We only send in teams. Maybe you aren't right for this job after all.\n");
        } else
        {
            $diceValue = $rollTheDice->diceForRolling("d4");
            if (array_key_exists($diceValue, $this->team))
            {
                echo "No one else wants to work with you. Let's move on.\n";
                return;
            } else
            {
                echo " ";
            }
            if ($diceValue == 1)
            {
                echo "Meet Alec Aldis, tech wizard extraordinaire. Having him inside with you will definitely help.\n";
                $this->addTeamMember($diceValue, "Alec");
            } elseif ($diceValue == 2)
            {
                echo "Meet Mary Monroe. Whatever you need: distractions, fighting, aerialist skills, she can do it.\n";
                $this->addTeamMember($diceValue, "Mary");
            }elseif ($diceValue == 3)
            {
                echo "Meet Kane Spencer. No one has gone up against his fists and walked away. No one.\n";
                $this->addTeamMember($diceValue, "Kane");
            }elseif ($diceValue == 4)
            {
                echo "Meet AJ. Wanted by countless worldwide agencies for various... misunderstandings. You're lucky to have them.\n";
                $this->addTeamMember($diceValue, "AJ");
            }
        }
    }

    /**
     * @param $teamMemberValue
     * @param $teamMemberName
     * @return void
     */
    private function addTeamMember($teamMemberValue, $teamMemberName)
    {
        echo "Do you want another teammate? Type yes or no in now:\n";
        $extraMember = readline(">> ");
        if ($extraMember == "no") {
            echo "Well, now that you have your team, let's go break into a bank!\n";
        } else {
            if (array_key_exists($teamMemberValue, $this->team)) {
                echo "No one else wants to work with you. Time to get going then.\n";
            } else {
                $this->team[$teamMemberValue] = $teamMemberName;
                $this->meetTheTeam();
            }
        }
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
            exit("The bank is closed. Go home.");
        } else
        {
            $diceResult = $rollTheDice->diceForRolling("d100");
        }

        if ($diceResult <= 25)
        {
            exit("Heist unsuccessful.\nThe gun fell out of your pocket as you entered the bank.\nThe guards noticed and arrested you and your team immediately.\nYou are now in jail... and you may need some protection!\n");
        } elseif ($diceResult <= 50)
        {
            exit("Heist unsuccessful.\nThe guards found you suspicious. You and your team left the bank for fear of being caught. Try again another time.\n");
        } elseif ($diceResult <= 100)
        {
            echo "You're in. Well done! You tricked the guards, who are none the wiser. Now let's see if you can get to the vault.\n";
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
       if ($diceResult >= 10)
       {
           echo ("Your team member successfully distracts the staff. You are able to slip into a back door and make your way to the vault.\n");
       }else
       {
           exit("The staff were suspicious and hit the alarm. You and your team made it out... barely. Try again another time.\n");
       }
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
            if ($vaultGuess != $this->vaultCode[$passCode-1])
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

    /**
     * @return void
     */
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
            exit("Your team member was sent out too early. They run into cops on their break as they try to leave and you are all arrested.\nHeist unsuccessful.");
        }else
        {
            $result =$rollTheDice->diceForRolling("d10");
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
        } else
        {
            echo "Good. Your teammate leaves to go start the get away car.\nYou manage to get a bit more money into the bag before you follow after them.\n";
            return;
        }

        $total = $result * 1000 + $money * 1000;
        exit("As you go to leave the bank with your \$" . $total . " you realize no one prepped the get away car.\nAs you climb inside you find yourself surrounded by the police, who have by now been alerted by the bank manager.\nHeist unsuccessful.\nEnjoy prison!");
    }

    /**
     * @return void
     */
    public function leaveSafely()
    {
        $rollTheDice = new Dice();
        echo "While you finish in the bank, your teammate attempts to start the car. Roll to see how successful they are:\n";
        start:
        $response = readline(">> ");
        if ($response == "roll")
        {
            $result = $rollTheDice->diceForRolling("d4");
            if ($result == 1 || $result == 2)
            {
                echo "The car does not start. As you hear the alarm inside the bank begin you sound, you both get out and flee on foot, agreeing to meet up at base.\n";
                goto end;
            } else
            {
                echo "The car starts and you drive away.\nYou go back to base, where you count up your prize.\n";
                $total = $rollTheDice->diceForRolling("d10")+$rollTheDice->diceForRolling("d10")+$rollTheDice->diceForRolling("d4");
                echo "You manage to get away with \$" . $total . ",000.";
                exit("Well done, Agent $this->name. We look forward to working with you again in the future.\nNow take your money and go.\n");
            }
        } else
        {
            echo "This is no time to play around! Roll now!";
            goto start;
            end:
        }
    }

    public function footRace()
    {
        $rollTheDice = new Dice();
        echo "The police begin to chase you. You now need to roll off against the police to see if you escape. Type roll in now:\n";
        $response = readline(">> ");
        if($response != "roll")
        {
            exit("You didn't even try to escape... but it didn't make the judge any less sympathetic. Enjoy prison!\n");
        } else
        {
            $userRoll = $rollTheDice->diceForRolling("d20");
            $policeRoll = $rollTheDice->diceForRolling("d20");

            if ($userRoll > $policeRoll)
            {
                echo "You escape to the rendezvous spot and count out the money.";
                $total = $rollTheDice->diceForRolling("d10")+$rollTheDice->diceForRolling("d10")+$rollTheDice->diceForRolling("d4");
                echo "You manage to get away with \$" . $total . ",000.";
                exit("Well done, Agent $this->name. We look forward to working with you again in the future.\nNow take your money and go.\n");
            } elseif ($userRoll < $policeRoll)
            {
                exit("The police are faster than you. They manage to tackle you to the ground, wrestling the money away. You are arrested... better luck next time!\n");
            }elseif ($userRoll == $policeRoll)
            {
                echo "The police close the distance. You throw the money at them, as a diversion. It works, and they stop to collect that, leaving you time to get away.\n";
                exit("You may have failed to get money, but at least you are free. You lay low for a while, biding your time until you can try again.\nBetter luck next time.\n");
            }
        }
    }
}

$rollTheDice = new Dice();
$story = new Story();
$story->setName();
$story->startMission();
$story->meetTheTeam();
$story->trickTheGuards();
$story->timeToStart();
$story->openVault();
$story->getMoney();
$story->leaveSafely();
$story->footRace();
