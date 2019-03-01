<?php
/**
 * ProseTranslator class for andydixon\pornolize
 *
 * Used for rewriting content
 *
 * This work is licensed under the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit http://creativecommons.org/licenses/by/4.0/.
 *
 * @package    andydixon/Pornolize
 * @author     Andy Dixon <ajdixon0283@outlook.com>
 **/

namespace Pornolize;


class ProseTranslator extends AbstractTranslator
{

    protected $lang = 'en';
    protected $adjectiveEndings = ['ing', 'ed', 's'];
    protected $nodeName = '';
    protected $weightMap = [
        'fallback' => 50,
        'p' => 30,
        'h1' => 90,
        'h2' => 90,
        'h3' => 80,
        'h4' => 80,
        'h5' => 70,
        'h6' => 70,
    ];

    /**
     * ProseTranslator constructor.
     * @param string $text Text to be translated
     * @param string $lang can be one of 'dk', 'de', 'en', 'es', 'hr', 'hu', 'no', 'se'
     * @param string $nodeName Used as an identifier for the translated object - set to a blank string
     */
    public function __construct(string $text, string $lang, string $nodeName)
    {
        $this->text = preg_split('/' . '\s+' . '/', $text);
        $this->nodeName = $nodeName;
        $this->lang = $lang;

        $words = file_get_contents(__DIR__ . '/dictionaries/' . $lang . '_adjectives.txt');
        $this->dictionary = explode("\n", $words);

        switch ($lang) {
            case 'en':
            default:
                $this->adjectiveEndings = ['ing', 'ed', 's'];
                break;
        }
    }

    /**
     * Translate the text passed to the object
     * @return $this
     */
    public function translate()
    {
        $this->text = array_map(function ($word) {
            $wordEnding = $this->adjectiveMatcher($word);

            if ($wordEnding && $this->shouldTranslate()) {
                $word = $this->randomWord() . $wordEnding;
            }

            return $word;
        }, $this->text);

        return $this;
    }

    /**
     * Check if the word is an adjective
     * @param $word
     * @return bool
     */
    private function adjectiveMatcher($word)
    {
        preg_match('/' . '\w{3,10}(' . implode('|', $this->adjectiveEndings) . ')' . '/', $word, $matches);
        return isset($matches[1]) ? $matches[1] : false;
    }


}