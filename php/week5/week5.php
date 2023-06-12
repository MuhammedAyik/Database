<?php
// Opdracht 1
$tijd = date("H:i");

if ($tijd < "12:00") {
  echo "Goedemorgen\n";
} elseif ($tijd >= "12:00" && $tijd < "18:00") {
  echo "Goedemiddag\n";
} else {
  echo "Goedenavond\n";
}

echo "\n";

// Opdracht 2
function berekenGemiddelde($getal1, $getal2) {
  $gemiddelde = ($getal1 + $getal2) / 2;
  echo "Het gemiddelde is: " . $gemiddelde . "\n";
}

berekenGemiddelde(6, 9);

echo "\n";

// Opdracht 3
function dagenTotEindeJaar() {
  $huidigeDatum = date("Y-m-d");
  $eindeJaar = date("Y-12-31");
  
  $huidigeTimestamp = strtotime($huidigeDatum);
  $eindeJaarTimestamp = strtotime($eindeJaar);
  
  $verschil = $eindeJaarTimestamp - $huidigeTimestamp;
  $aantalDagen = ceil($verschil / (60 * 60 * 24));
  
  return $aantalDagen;
}

$aantalDagen = dagenTotEindeJaar();
echo "Aantal dagen tot het einde van het jaar: " . $aantalDagen . "\n";

echo "\n";

// Opdracht 4
function berekenTotaleLengte($strings) {
  $totaleLengte = 0;
  
  foreach ($strings as $string) {
    $lengte = strlen($string);
    $totaleLengte += $lengte;
  }
  
  return $totaleLengte;
}

$strings = array("Hallo", "Wereld", "Hi");
$resultaat = berekenTotaleLengte($strings);

echo "Totale lengte: " . $resultaat . "\n";

?>