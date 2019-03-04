# andydixon/pornolize - The code behind pornolize.com #

### To install ###

``` composer require "andydixon/pornolize 1.*" ```

### To Use ###

The pornolization process is split into two parts - name pornolization and text pornolization. The following example will pornolize the text held in $text :

``` <?php

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

```

The code above is pretty much self explanatory (I'm no good at writing documentation for the average human), however for any Translator object, the final option changes how abusive the text can be, the higher the ~~better~~ more words are added. 

Any questions can be dropped to me by email - ajdixon0283 at outlook dot com, but you will get what you give - obnoxiousness will incur wrath, and additional wrath can be provided to those who have their cranium lodged in their rectums free of charge.