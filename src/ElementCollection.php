<?php
/**
 * HtmlHelper Library.
 *
 * @license https://github.com/robertdown/html-helper/blob/master/LICENSE MIT
 */

namespace rdown\HtmlHelper;


abstract class ElementCollection implements \IteratorAggregate
{

    /** @var array */
    protected $files = [];

    /** @var string */
    protected $baseUri;

    public function __construct($baseUri = '/', array $attributes = null)
    {
        // @TODO: Add ability to waterfall attributes down to any Script in collection is arg present in constructor
        if ($baseUri == DIRECTORY_SEPARATOR) {
            $this->baseUri = $baseUri;
        } else {
            $this->baseUri = $baseUri . DIRECTORY_SEPARATOR;
        }
    }

    abstract public function addFile($file);

    public function hasFile($file)
    {
        foreach ($this->files as $item)
        {
            if (method_exists($item, 'getSrc')) {
                if ($file === $this->stripBase($item->getSrc())) {
                    return true;
                }
            } else {
                throw new \Exception('Cannot getFilename');
            }
        }

        return false;
    }

    protected function stripBase($file)
    {
        return str_replace($this->baseUri, '', $file);
    }

    public function removeFile($file)
    {
        $file = $this->getFullFilename($file);
        for ($i = 0; $i < count($this->files); $i++)
        {
            if (method_exists($this->files[$i], 'getSrc')) {
                if ($file === $this->files[$i]->getSrc()) {
                    unset($this->files[$i]);
                    return true;
                }
            }
        }

        return false;
    }

    public function getFullFilename($file)
    {
        return $this->baseUri . $file;
    }

    private function findFile($file)
    {
        foreach ($this->files as $item) {
            $tmpFile = str_replace($this->baseUri, '', $item->getSrc());
            if ($tmpFile === $file) {
                return $item;
            }
        }

        throw new \Exception('File not found');
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
        return new \ArrayIterator($this->files);
    }
}
