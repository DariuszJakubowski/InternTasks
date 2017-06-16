<?php


class SpellTest extends PHPUnit_Framework_TestCase
{

    public function testSplitSpell()
    {

        $spell = new \Clearcode\FamousPolishWizardTask\Spell();

        $this->assertEquals('fejejeeaindaiyaiai', $spell->splitSpell('fejejeeaindaiyaiai'));
        $this->assertEquals('feaineai', $spell->splitSpell('feaineain'));
        $this->assertEquals('feaineaiaiaiai', $spell->splitSpell('xxxfeaineaiaiaiaiaeehehe'));
        $this->assertEquals(false, $spell->splitSpell('fefeqwertyai'));
        $this->assertEquals(false, $spell->splitSpell('fenenene'));
        $this->assertEquals('fejejeeaindaiyaiai', $spell->splitSpell('ojojojfejejeeaindaiyaiai'));
        $this->assertEquals(false, $spell->splitSpell('fe@#$!!!1ai'));
    }
}
