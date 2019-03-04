<?php

/**
 * AbstractTranslator class for andydixon\pornolize
 *
 * This work is licensed under the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit http://creativecommons.org/licenses/by/4.0/.
 *
 * @package    andydixon/Pornolize
 * @author     Andy Dixon <ajdixon0283@outlook.com>
**/

namespace Pornolize;


abstract class AbstractTranslator
{
    protected $text = [];
    protected $lang = '';
    protected $nodeName = '';
    protected $dictionary = [];
    protected $swearability = 50;

    /**
     * @param string $text Text to be translated
     * @param string $lang can be one of 'dk', 'de', 'en', 'es', 'hr', 'hu', 'no', 'se'
     * @param string $nodeName Used as an identifier for the translated object - set to a blank string
     * @return AbstractTranslator
     */
    public static function make(string $text, string $lang, int $swearability)
    {
        return new static($text, $lang, $swearability);
    }

    abstract public function translate();

    /**
     * Return string value
     * @return string
     */
    public function __toString()
    {
        return implode(' ', $this->text);
    }

    /**
     * Get a random string from the loaded dictionary
     * @return string
     */
    protected function randomWord()
    {
        return $this->dictionary[mt_rand(0, count($this->dictionary) - 1)];
    }

    /**
     * Dice-roll on whether or not a work should be translated
     * @return bool
     */
    protected function shouldTranslate()
    {
        return mt_rand(1, 100) <= $this->swearability;
    }
}