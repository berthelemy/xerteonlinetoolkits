<?php
include 'docDisplay/config.php'; // Include configuration settings

$homePageURL = "./index.php?file=".$homePage;


function iterateDirectory($i)
{
    $depth = 0;
    echo '<ul>';
    foreach ($i as $path) {
        $depth1 = $i->getDepth();
        echo $depth." ".$depth1;
        if ($depth == $depth1)
        {
           echo '<li>'.$path.'</li>';
        }
        elseif ($depth < $depth1)
        {
            echo '<ul>';
            echo '<li>'.$path.'</li>';
            $depth = $depth1;
        }
        elseif ($depth > $depth1) {
            echo '</ul>';
            $depth = $depth1;
        }
    }
    echo '</ul>';
}

$dir = $docsDir;
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir),RecursiveIteratorIterator::SELF_FIRST );

iterateDirectory($iterator);

