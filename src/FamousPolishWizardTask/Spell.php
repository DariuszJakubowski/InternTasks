<?php

namespace Clearcode\FamousPolishWizardTask;

class Spell
{
    private $spell;
    private $powerOfSubspells;

    function __construct(string $crudeSpell = null)
    {
        $this->spell = $this->splitSpell($crudeSpell);
        $this->powerOfSubspells = ['dai' => 5, 'ain' => 3, 'jee' => 3, 'je' => 2, 'ne' => 2, 'ai' => 2, 'fe' => 1];

    }

    public function getSpell()
    {
        return $this->spell;
    }

    public function setSpell($spell)
    {
        $this->spell = $this->splitSpell($spell);
    }

    /**
     * @param $crudeSpell
     * @return mixed Returns false if string is incorrect, returns filtered string when it is correct
     */
    public function splitSpell($crudeSpell)
    {
        //'fe' can occur only once
        if(preg_match_all('/fe/', $crudeSpell, $matches) != 1) {
            return false;
        }

        preg_match_all('/fe(\w)*ai/', $crudeSpell, $matches);
        //get last 'ai'
        $match = end($matches[0]);

        return $match;
    }

    /**
     * @return int
     */
    public function calculateDamage()
    {
        $damage = 0;
        $spell = $this->spell;

        while (strlen($spell) > 0) {
            if (preg_match("/(dai|ain|jee|je|ne|ai|fe)$/", $spell, $match)) {
                //remove last phrase (strongest matched subspell)
                $spell = substr($spell, 0, 0 - strlen($match[0]));
                $damage += $this->powerOfSubspells[$match[0]];
            } else {
                //if any subspell doesn't match, remove last letter and decrease 1 point of damage
                $spell = substr($spell, 0, -1);
                $damage--;
            }
        }
        if($damage < 0) {
            $damage = 0;
        }

        return $damage;
    }

}
