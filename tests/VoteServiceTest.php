 <?php
require_once __DIR__ . "/../src/Models/GestionVotes.php";

$votes = [1,1,1];
var_dump(GestionVotes::isUnanimous($votes));
$v = [1,2,3];
var_dump(GestionVotes::moyenne($v));
var_dump(GestionVotes::mediane($v));
