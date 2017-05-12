<?php
/**
 * HtmlHelper Library.
 *
 * @license https://github.com/robertdown/html-helper/blob/master/LICENSE MIT
 */

use rdown\HtmlHelper\Scripts\Script;

class ScriptTest extends PHPUnit_Framework_TestCase
{

    /** @var  Script */
    private $script;

    public function setUp()
    {
        parent::setUp();
        $this->script = new Script('filename.js');
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateScript()
    {
        $script = new Script('text/javascript');
        $this->assertInstanceOf("rdown\HtmlHelper\Scripts\Script", $script);

        $fail = new Script();
    }

    public function testCreateScriptWithNoAttributes()
    {
        $script = new Script('filename.js');
        $this->assertEquals($script->getAttribute(), (object) []);
    }

    public function testSetSrc()
    {
        $expected = 'updated';
        $script = new Script('originalSrc');
        $script->setSrc($expected);

        $reflection = new ReflectionClass('rdown\HtmlHelper\Scripts\Script');
        $property = $reflection->getProperty('src');
        $property->setAccessible(true);

        $this->assertEquals($expected, $property->getValue($script));
    }

    public function testGetSrc()
    {
        $expected = 'src';
        $script = new Script($expected);
        $this->assertEquals($expected, $script->getSrc());
    }

    public function testType()
    {
        $expected = 'updated';
        $script = new Script('src');
        $script->setType($expected);

        $reflection = new ReflectionClass('rdown\HtmlHelper\Scripts\Script');
        $property = $reflection->getProperty('type');
        $property->setAccessible(true);

        $this->assertEquals($expected, $property->getValue($script));
    }

    public function testCreateScriptObjectWithAttributes()
    {
        $attributes = [
            'type' => 'text/javascript',
            'charset' => 'UTF-8',
            'defer' => 'async',
        ];
        $attributesObject = (object) $attributes;
        $script = new Script('filepath', $attributes);
//        $this->assertEquals($script->getAttribute(), $attributesObject);
    }

    public function testRender()
    {
        $expected = '<script src="filename.js"></script>';
        $script = new Script('filename.js');
        $this->assertEquals($expected, $script->render());
    }
}
