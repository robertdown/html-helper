<?php
/**
 * HtmlHelper Library.
 *
 * @license https://github.com/robertdown/html-helper/blob/master/LICENSE MIT
 */

namespace rdown\HtmlHelper;

abstract class Element
{

    private $optionalAttributes = [];

    private $requiredAttributes = [];

    protected $attributes = [];

    abstract public function __construct();

    protected function flattenAttributes()
    {
        $tmp = [];
        foreach ($this->attributes as $prop => $val) {
            $tmp[] = "{$prop}=\"$val\"";
        }

        return implode(" ", $tmp);
    }

    protected function validateAttribute($attributes)
    {
        if (is_array($attributes)) {
            $tmp = [];
            foreach ($attributes as $key => $value) {
                if (!$this->validateAttribute($key)) {
                    return false;
                }
            }
            return true;
        }

        $allowedAttributes = array_merge($this->optionalAttributes, $this->requiredAttributes);
        if (in_array($attributes, $allowedAttributes)) {
            return true;
        } else {
            error_log("{$attributes} not allowed in script tag");
        }
    }

    abstract public function render();

    /**
     * Create data object
     *
     * @param array $array
     * @return object
     */
    protected function createData(array $array)
    {
        return (object) $array;
    }

    /**
     * @return array
     */
    public function getRequiredAttributes()
    {
        return $this->requiredAttributes;
    }

    /**
     * @param array $requiredAttributes
     */
    public function setRequiredAttributes($requiredAttributes)
    {
        $this->requiredAttributes = $requiredAttributes;
    }

    /**
     * @return array
     */
    public function getOptionalAttributes()
    {
        return $this->optionalAttributes;
    }

    /**
     * @param array $optionalAttributes
     */
    public function setOptionalAttributes($optionalAttributes)
    {
        $this->optionalAttributes = $optionalAttributes;
    }

    /**
     * @param string $name Name of attribute. Return all if null
     * @return \stdClass
     */
    public function getAttribute($name = null)
    {
        if ($name == null) {
            return $this->createData($this->attributes);
        } else {
            return $this->createData($this->attributes->$name);
        }
    }

    /**
     * @param string $attribute Name of attribute
     * @param string $val Value
     */
    public function setAttributes($attribute, $val)
    {
        $this->attributes["{$attribute}"] = $val;
    }
}
