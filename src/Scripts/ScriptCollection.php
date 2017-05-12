<?php
/**
 * HtmlHelper Library.
 *
 * @license https://github.com/robertdown/html-helper/blob/master/LICENSE MIT
 */

namespace rdown\HtmlHelper\Scripts;

use rdown\HtmlHelper\ElementCollection;
use rdown\HtmlHelper\Scripts\Script;

/**
 * Collect scripts under the same base path.
 *
 * @package rdown\HtmlHelper
 * @subpackage Scripts
 * @author Robert Down <robertdown@live.com>
 * @copyright Copyright (C) 2017 Robert Down
 */
class ScriptCollection extends ElementCollection
{

    public function __construct($baseUri = '/', array $attributes = null)
    {
        parent::__construct($baseUri, $attributes);
    }

    /**
     * @param $file Script|string
     * @throws \Exception
     */
    public function addFile($file)
    {
        if (is_string($file)) {
            $this->files[] = new Script($this->baseUri . $file);
        } elseif (is_object($file) && (get_class($file) == 'rdown\\HtmlHelper\\Scripts\\Script')) {
            $file->setSrc($this->baseUri . $file->getSrc());
            $this->files[] = $file;
        } else {
            throw new \InvalidArgumentException('Parameter must be string or Script object');
        }
    }


}
