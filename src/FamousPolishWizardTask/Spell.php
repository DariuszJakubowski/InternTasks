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

    }

    public function getSpell()
    {
        return $this->spell;
    }

    public function setSpell($spell)
    {
        $this->spell = $this->splitSpell($spell);
    }

    public function splitSpell()
    {
        return false;
    }
}
