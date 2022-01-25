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
    /**
     * @return void
     */
    public function startMission()
    {
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

    public function timeToStart()
    {
       echo "You and your team need to distract the staff so you can sneak down to the vault.";
       echo "Roll to see how distracting your team is. Type roll in now:\n";
       $rollTheDice = new Dice();
       $response = readline(">> ");

       if ($response != "roll")
       {
           exit("Heist Unsuccessful. You and your team members begin to argue over who is meant to distract the staff. The guards hear you and arrest you. Good luck explaining this one!");
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

    public function openVault()
    {

    }
}

//sending a team member out too early alerts some police on break to the heist - fail
//not sending a team member out means the get away car isn't ready and it fails

echo "What is your name, agent?";
$name = readline("\n" . ">> ");
echo "Welcome, Agent $name. Are you ready to start your mission? \nRespond yes or no:";
$rollTheDice = new Dice();
$story = new Story();
$story->startMission();
$story->meetTheTeam();
$story->trickTheGuards();
$story->timeToStart();
$story->openVault();