<?php
foreach (glob("*.jpg") as $filename) {
echo "$filename size " . filesize($filename) . "<BR>";
}
?>