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
//        $script = new Script('text/javascript');
//        $this->assertInstanceOf("Script", $script);

        $fail = new Script();
    }

    public function testCreateScriptWithNoAttributes()
    {
        $script = new Script('filename.js');
//        $this->assertEquals($script->getAttribute(), []);
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
