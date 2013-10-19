<?php
App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('BootstrapIconHelper', 'Plugin/TwitterBootstrapCakeBake/View/Helper');

class BootstrapIconHelperTest extends CakeTestCase {
    public function setUp() {
        parent::setUp();
        $Controller = new Controller();
        $View = new View($Controller);
        $this->BootstrapIcon = new BootstrapIconHelper($View);
    }

    public function testPlusWhite() {
        $result = $this->BootstrapIcon->css('plus','white');
        $this->assertContains('<i class="icon-plus icon-white"></i>', $result);
    }

    public function testPlusBlack() {
        $result = $this->BootstrapIcon->css('plus','black');
        $this->assertContains('<i class="icon-plus icon-black"></i>', $result);
    }

    public function testPlus() {
        $result = $this->BootstrapIcon->css('plus');
        $this->assertContains('<i class="icon-plus icon-black"></i>', $result);
    }
}