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

$text = "The domestic goat or simply goat (Capra aegagrus hircus) is a subspecies of C. aegagrus domesticated from the wild goat of Southwest Asia and Eastern Europe. The goat is a member of the animal family Bovidae and the goat—antelope subfamily Caprinae, meaning it is closely related to the sheep. There are over 300 distinct breeds of goat. Goats are one of the oldest domesticated species of animal, and have been used for milk, meat, fur, and skins across much of the world. Milk from goats is often turned into goat cheese.

Female goats are referred to as does or nannies, intact males are called bucks or billies and juvenile goats of both sexes are called kids. Castrated males are called wethers. While the words hircine and caprine both refer to anything having a goat-like quality, hircine is used most often to emphasize the distinct smell of domestic goats.";

$language = "en"; // can be one of 'dk', 'de', 'en', 'es', 'hr', 'hu', 'no', 'se'

try {

	// Pornolize any names that may exist
	$translator = Pornolize\NameTranslator::make($text, $language, '');
	$text=$translator->translate()->__toString();

	// Pornolize main content
	$translator = Pornolize\ProseTranslator::make($text, $language, '');
	$text = $translator->translate()->__toString();

	echo $text;

} catch (\Exception $e) {
	echo "An error ocurred: " . $e->getMessage();
}
