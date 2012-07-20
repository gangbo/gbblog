<?php

require_once('./ThumbGen.class.php');

// Disable caching
$thumbGen = new ThumbGen(false);

// 75% quality
$thumbGen->setQuality(75);

// Prepare a 200x300 JPEG thumbnail
$thumbGen->getThumbnail('aisi.jpg', 150, 150, 'jpg');
$thumbGen->saveThumbnail('small-aisi.jpg');
// Output the thumbnail
$thumbGen->outputThumbnail();
