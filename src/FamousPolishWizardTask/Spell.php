<?php
/**
 * Created by PhpStorm.
 * User: bruto
 * Date: 6/17/17
 * Time: 12:11 AM
 */

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

    public function splitSpell($crudeSpell)
    {
        //'fe' can occur only once
        if(preg_match_all('/fe/', $crudeSpell, $matches) != 1) {
            return false;
        }

        preg_match_all('/fe(\w)*ai/', $crudeSpell, $matches);
        // last 'ai'
        $match = end($matches[0]);

        return $match;
    }
}
