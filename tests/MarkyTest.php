<?php

namespace Marky;

class MarkyTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_should_be_created_from_string()
    {
        $marky = Marky::fromString('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $this->assertNotEmpty($marky->generate(500));
    }
}
