<?php
/**
 * HtmlHelper Library.
 *
 * @license https://github.com/robertdown/html-helper/blob/master/LICENSE MIT
 */

namespace rdown\HtmlHelper\Scripts;

use rdown\HtmlHelper\Element;

/**
 * Object representation of an HTML5 <script> tag.
 *
 * ```php
 * $script = new Script('path/to/file.js');
 * $script->addAttribute('type', 'text/javascript');
 * $script->render();
 * // <script src="path/to/file.js" type="text/javascript"></script>
 * ```
 *
 *
 * @package rdown\HtmlHelper\Scripts
 */
class Script extends Element
{

    private $events = [
        'onload',
        'onunload',
        'onclick',
        'ondblclick',
        'onmousedown',
        'onmouseup',
        'onmouseover',
        'onmouseover',
        'onmousemove',
        'onmouseout',
        'onfocus',
        'onblur',
        'onkeypress',
        'onkeydown',
        'onkeyup',
        'onsubmit',
        'onreset',
        'onselect',
        'onchange',
    ];

    /* @var string */
    private $type = "text/javascript";

    /**
     * src attribute value
     * @var string
     */
    private $src = false;

    public function __construct($src = null, array $attributes = null)
    {
        if ($src) {
            $this->setOptionalAttributes([
                'charset',
                'src',
                'defer'
            ]);

            $this->setRequiredAttributes(['type']);

            $this->src = $src;

            if ($attributes) {
                $this->validateAttribute($attributes);
            }
        } else {
            throw new \Exception('src attribute required');
        }
    }

    public function render()
    {
        $atts = (count($this->attributes) > 0) ? " " . $this->flattenAttributes() : "";
        $template = "<script src=\"{$this->src}\"{$atts}></script>";
        return $template;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getSrc()
    {
        return $this->src;
    }
}
