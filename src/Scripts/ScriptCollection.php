<?php
/**
 * HtmlHelper Library.
 *
 * @license https://github.com/robertdown/html-helper/blob/master/LICENSE MIT
 */

namespace rdown\HtmlHelper\Scripts;

use rdown\HtmlHelper\Scripts\Script;

/**
 * Collect scripts under the same base path.
 *
 * @package rdown\HtmlHelper
 * @subpackage Scripts
 * @author Robert Down <robertdown@live.com>
 * @copyright Copyright (C) 2017 Robert Down
 */
class ScriptCollection implements \IteratorAggregate
{

    /** @var array */
    private $scripts = [];

    /** @var string */
    private $baseUri;

    public function __construct($baseUri = '/', array $attributes = null)
    {
        // @todo: Add ability to waterfall attributes down to any Script in collection is arg present in constructor
        $this->baseUri = $baseUri;
    }

    /**
     * @param $script Script
     * @throws \Exception
     */
    public function addScript($script)
    {
        if (is_string($script)) {
            $this->scripts[] = new Script($this->baseUri . $script);
        } elseif (is_object($script) && (get_class($script) == 'rdown\\HtmlHelper\\Scripts\\Script')) {
            $script->setSrc($this->baseUri . $script->getSrc());
            $this->scripts[] = $script;
        } else {
            throw new \Exception('Parameter must be string or Script object');
        }
    }

    public function render()
    {
        foreach ($this->getIterator() as $script) {
            echo $script->render() . "\n";
        }
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->scripts);
    }
}
