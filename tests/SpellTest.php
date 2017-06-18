<?php

use Clearcode\FamousPolishWizardTask\Spell;

class SpellTest extends PHPUnit_Framework_TestCase
{
    private $spell;

    protected function setUp()
    {
        $this->spell = new Spell();
    }

    protected function tearDown()
    {
        $this->spell = null;
    }

    public function testToFilterSpell()
    {
        $this->assertEquals(false, $this->spell->splitSpell('toMany fe fe fe qwerty ai'), 'Incorrect string (because to many \'fe\') should return false');
        $this->assertEquals(false, $this->spell->splitSpell('fe lack of require subspell'), 'Incorrect string (because lack of \'ai\') should return false');
        $this->assertEquals(false, $this->spell->splitSpell('fe@#$not!letters!!1ai'), 'Occurring non-letters should return false');
        $this->assertEquals('fejejeeaindaiyaiai', $this->spell->splitSpell('fejejeeaindaiyaiai'));
        $this->assertEquals('feaineai', $this->spell->splitSpell('feaineain'));
        $this->assertEquals('feaineaiaiaiai', $this->spell->splitSpell('xxxfeaineaiaiaiaiaeehehe'));
        $this->assertEquals('fejejeeaindaiyaiai', $this->spell->splitSpell('ojojojfejejeeaindaiyaiai'));
    }

    public function testToCalculateHowManyDamageGivesOneSpell()
    {
        //1+2
        $this->spell->setSpell('feai');
        $this->assertEquals(3, $this->spell->calculateDamage());
        //1+5+2
        $this->spell->setSpell('fedaiai');
        $this->assertEquals(8, $this->spell->calculateDamage());

        $this->spell->setSpell('fexxxxxai');
        $this->assertEquals(0, $this->spell->calculateDamage(), 'Damage equals -2 ( = 1 - 5 + 2), but you can\'t gives -2 damage, so damage should by 0.');
        //1+2+2+2
        $this->spell->setSpell('feaineai');
        $this->assertEquals(7, $this->spell->calculateDamage());
        //setSpell() should return false and calculateDamage() should convert it on 0
        $this->spell->setSpell('fefefefefeaiaiaiaiai');
        $this->assertEquals(0, $this->spell->calculateDamage());
        //1-1-1+2
        $this->spell->setSpell('fdafafeajain');
        $this->assertEquals(1, $this->spell->calculateDamage());
    }
}
