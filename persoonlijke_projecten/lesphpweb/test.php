<?php
//knight
$gezondheids_punten = 100;
$aanvals_punten = 20;
$verdedigings_punten = 15;
//dwarf
$gezondheidPunten = 100;
$aanvalsPunten = 40;
$verdedigingsPunten = 10;

//charaters
$miner = "type: Miner" . PHP_EOL . "HP: " . $gezondheidPunten . PHP_EOL . "AP: " . $aanvalsPunten . PHP_EOL . "DP: " . $verdedigingsPunten . PHP_EOL;
$warrior = "type: Warrior" . PHP_EOL . "HP: " . $gezondheids_punten . PHP_EOL . "AP: " . $aanvals_punten . PHP_EOL . "DP: " . $verdedigings_punten . PHP_EOL;

$knight = "knight";
$dwarf = "dwarf";

$charaters =  array("knight" => $warrior, "dwarft" => $miner);


echo "kies een personage door de naam in te voeren: ";
$input = readline();
if ($input == $knight) {
    foreach ($charaters as $name => $type) {
        echo "You chose: $name " . PHP_EOL . $type;
    }
}
// ik ben er niet aan toe gekommen om het uit te testen en het einde van het script uit te printen en kon geen funtie
// en te checken of het aan de ijzen voldoet