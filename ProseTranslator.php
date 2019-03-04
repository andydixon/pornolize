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
    protected $swearability = 50;

    /**
     * ProseTranslator constructor.
     * @param string $text Text to be translated
     * @param string $lang can be one of 'dk', 'de', 'en', 'es', 'hr', 'hu', 'no', 'se'
     * @param int    $swearability   0-100 on chance of injection randomisation being true
     */
    public function __construct(string $text, string $lang, int $swearability)
    {
        $this->lang = $lang;

        /**
         * Handle loading the dictionary
         */
        if(!file_exists(__DIR__ . '/dictionaries/' . $lang . '_adjectives.txt'))
            throw new PornolizerDictionaryException('Dictionary for '.$lang . ' does not exist');

        $words = file_get_contents(__DIR__ . '/dictionaries/' . $lang . '_adjectives.txt');
        $this->dictionary = explode("\n", $words);

        /**
         * Validate the swearability frequency, throw exception if out of bounds
         */
        if($swearability>=0 && $swearability <=100) {
            $this->swearability = $swearability;
        } else {
            throw new PornolizerSwearabilityException('Value is out-of-bounds');
        }

        /**
         * Split the words into an array
         */
        $this->text = preg_split('/' . '\s+' . '/', $text);

        /**
         * Adjective endings
         * @todo add additional endings for other supported languages
         */
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