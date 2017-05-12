<?php
/**
 * HtmlHelper Library.
 *
 * @license https://github.com/robertdown/html-helper/blob/master/LICENSE MIT
 */

use rdown\HtmlHelper\Scripts\ScriptCollection;
use rdown\HtmlHelper\Scripts\Script;

class ScriptCollectionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddFile()
    {
        $file = 'test.js';

        $script = new Script('/' . $file);
        $expected = [$script, $script];

        $collection = new ScriptCollection();
        $collection->addFile($file);
        $collection->addFile(new Script('test.js'));

        $reflection = new ReflectionClass('rdown\HtmlHelper\Scripts\ScriptCollection');
        $property = $reflection->getProperty('files');
        $property->setAccessible(true);

        $this->assertEquals($expected, $property->getValue($collection));

        $collection->addFile([]);
    }
}
