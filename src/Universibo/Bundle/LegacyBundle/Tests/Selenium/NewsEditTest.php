<?php
namespace Universibo\Bundle\LegacyBundle\Tests\Selenium;

use Universibo\Bundle\LegacyBundle\Tests\TestConstants;

class NewsEditTest extends UniversiBOSeleniumTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function testEditNews()
    {
        $this->login(TestConstants::ADMIN_USERNAME);

        $this->openPrefix('/news/1/edit/2/');

        $this->type('name=f8_titolo', 'Test news');
        $this->type('name=f8_testo', 'Test content');
        $this->clickAndWait('name=f8_submit');

        $this->assertSentence('modificata con successo.');
    }
}
