<?php
/**
 * example for andydixon\pornolize
 *
 * Used for rewriting content
 *
 * This work is licensed under the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit http://creativecommons.org/licenses/by/4.0/.
 *
 * @package    andydixon/pornolize
 * @author     Andy Dixon <ajdixon0283@outlook.com>
 **/

require_once __DIR__ . '/vendor/autoload.php';

$text = "The domestic goat or simply goat (Capra aegagrus hircus) is a subspecies of C. aegagrus domesticated from the wild goat of Southwest Asia and Eastern Europe. The goat is a member of the animal family Bovidae and the goat—antelope subfamily Caprinae, meaning it is closely related to the sheep. There are over 300 distinct breeds of goat. Goats are one of the oldest domesticated species of animal, and have been used for milk, meat, fur, and skins across much of the world. Milk from goats is often turned into goat cheese.";

$language = "en"; // can be one of 'dk', 'de', 'en', 'es', 'hr', 'hu', 'no', 'se'

try {

    // Pornolize any names that may exist
    $translator = Pornolize\NameTranslator::make($text, $language, 50);
    $text=$translator->translate()->__toString();

    // Pornolize main content
    $translator = Pornolize\ProseTranslator::make($text, $language, 50);
    $text = $translator->translate()->__toString();

    echo $text;

} catch (PornolizerDictionaryException $e) {    // Thrown if a dictionary file cant be found
    echo $lang . "'s dictionary does not exist";
} catch (PornolizerSwearabilityException $e) {  // Thrown if you make it outside of 0-100
    echo $e->getMessage();
}
