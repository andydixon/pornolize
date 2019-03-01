<?php

/**
 * NameTranslator class for andydixon\pornolize
 *
 * Used for rewriting names within content
 *
 * This work is licensed under the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit http://creativecommons.org/licenses/by/4.0/.
 *
 * @package    andydixon/Pornolize
 * @author     Andy Dixon <ajdixon0283@outlook.com>
**/

namespace Pornolize;


class NameTranslator extends AbstractTranslator
{
    protected $lang = 'en';
    protected $weightMap = [
        'fallback' => 50,
        'p'        => 30,
        'h1'       => 90,
        'h2'       => 90,
        'h3'       => 80,
        'h4'       => 80,
        'h5'       => 70,
        'h6'       => 70,
    ];

    /**
     * NameTranslator constructor.
     * @param string $text  Text to be translated
     * @param string $lang  can be one of 'dk', 'de', 'en', 'es', 'hr', 'hu', 'no', 'se'
     * @param string $nodeName  Used as an identifier for the translated object - set to a blank string
     */
    public function __construct(string $text, string $lang, string $nodeName)
    {
        $this->text = preg_split('/' . '\s+' . '/', $text);
        $this->text = array_filter($this->text, function ($word) {
            return !empty($word);
        });
        $this->text = array_values($this->text);

        $names = file_get_contents(__DIR__ . '/dictionaries/' . $lang . '_names.txt');
        $this->dictionary = explode("\n", $names);
    }

    /**
     * Check to see if the first character is uppercase
     * @param string $word
     * @return bool
     */
    private function upperStart(string $word)
    {
        return
            ctype_alnum($word[0])
            && $word[0] === mb_strtoupper($word[0])
            && (strlen($word)>1 && $word[1] !== mb_strtoupper($word[1]));
    }

    /**
     * Translate the text passed to the object
     * @return $this
     */
    public function translate()
    {

        $nameMiddle = [];
        $match = 0;

        foreach ($this->text as $index => $word) {

            if ($this->upperStart($word)) {
                $match++;
            } else {
                $match = 0;
            }

            if ($match === 2) {
                $nameMiddle[] = $index;
                $match = 0;
            }
        }
        $spliceOffset = 0;
        foreach ($nameMiddle as $start) {
            /** @var $spliceOffset int - offset of how many replacements made so far. need to add to the $start because
             * each splice pushes the array keys up one after the bit spliced
             */
            if ($this->shouldTranslate()) {
                array_splice($this->text, $start + $spliceOffset, 0, '"' . $this->randomWord() . '"');
                $spliceOffset++;
            }
        }

        return $this;
    }
}
