<?php
include 'docDisplay/config.php'; // Include configuration settings
require_once 'docDisplay/php-markdown-lib/Michelf/Markdown.php'; // Include Markdown parser

$homePageURL = "./index.php?file=".$homePage;

// Function to setup the menu list

function menuSetup($i)
{
    $depth = 0;
    $logo = '<li class="sidebar-brand"><a href="'.$homePageURL.'"><img src="../website_code/images/xerteLogo.jpg" alt="Xerte logo" /></a></li>';
    $menu = $menu.'<ul class="sidebar-nav">';
    $menu = $menu.$logo;
    foreach ($i as $path) {
        $depth1 = $i->getDepth();
        $fileName = $i->getFilename();
        //echo $depth." ".$depth1;
        
        if ($depth < $depth1)
        {
            $menu = $menu.'<ul>';
            $depth = $depth1;
        }
        elseif ($depth > $depth1) {
            $menu = $menu. '</ul>';
            $depth = $depth1;
        }
        
           $menu = $menu.'<li><a href="index.php?file='.$fileName.'">'.createPageName($fileName).'</a></li>';
        
    }
    $menu = $menu.'</ul>';
    return $menu;
}

// Setup iterator for previous function
$dir = $docsDir;
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir),RecursiveIteratorIterator::SELF_FIRST );

// End of menusetup



function createPageName($fname) {

    $name = str_replace(".md", "", $fname); // remove extension
    $name = str_replace("-", " ", $name); // replace - with space
    $name = str_replace("_", " ", $name); // replace - with space
    $name = ucwords($name); // set first character to be a capital letter

// Remove numbers from name if they exist
    if (is_numeric(substr($name, 0,1))) {
        $name = substr($name, 2, strlen($name)-2);
    }

    return $name;

}


// Get list of files in docs directory - to show in menu
/*
$files = array();
$directories = array();
$dir = opendir($docsDir); // open the docs directory. Also do an err check.
while(false != ($file = readdir($dir))) {
        if(($file != ".") and ($file != "..") and ($file != "index.php")) {
                if (is_dir($docsDir.'/'.$file)) {
                    $directories[] = $docsDir.'/'.$file; // put in directory array
                } else {
                    $files[] = $file; // put in file array.    
                }
                

        }   
}




natsort($files); // sort files
natsort($directories); // sort directories

// Go through each file and create a multi-dimensional array of files, page titles and categories

$pages = array();
foreach ($files as $file) {
    if ($file != '.git') {
        $pageName = $file;
        /*
        // Check if file has a category
        if (strpos($file, '--') != true) {

            $category = 'Uncategorized';
            $pageName = $file;
            } else {
            // if file doesn't have a category, then extract it, leaving the page name
            $arr = explode('--', $file);
            $category = $arr[0];
            $pageName = $arr[1];
            }

        // Now setup the $page array
        $page['category']= $category; // Setup $page array: category                

        $page['pageName'] = createPageName($pageName); // Make name to go in menu - put in $page array: pageName

        $page['fileName'] = $file; // Put filename in $page array: fileName

        $pages[] = $page; // Add this set of page items to the $pages array
    } // end of check for .git
} // end of Foreach

*/


// Get markdown file to display from URL

$URLfileName = $_GET['file']; // Pick up the filename from the URL

if (is_null($URLfileName)) { // If no filename - go to the home page
    $URLfileName = $homePage;
}




// Get the names ready to display on the page

$URLpageName = createPageName($URLfileName);
/*
if (strpos($URLfileName, '--') != true) {
    $URLcategory = '---';
    $URLpageName = createPageName($URLfileName);
    } else {
    $URLcategory = current(explode("--", $URLfileName)); // extract category name to display in breadcrumb trail
    // Tidy up file name to display in page title
    $arr = explode('--', $URLfileName);
    $URLpageName = $arr[1]; // Page name = 2nd element in the exploded array
    $URLpageName = createPageName($URLpageName);
    }
*/

// Put contents of file into string

$fileContents = file_get_contents($docsDir.'/'.$URLfileName);

// Translate from markdown to HTML

$fileHtml = \Michelf\Markdown::defaultTransform($fileContents);

// Create page title
$pageTitle = $application.' Documentation > '.$URLcategory.' > '.$URLpageName;

?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $pageTitle ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap-theme.min.css">


<!-- Bootstrap core JavaScript
    ================================================== -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>

<!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <link href="docDisplay/css/simple-sidebar.css" rel="stylesheet">
</head>

<body>
    <script>
 
    var docsName = "<?php echo $docsDir; ?>";


    $( document ).ready(function() {
// Function to replace URLs in the page content generated by the markdown with ones that will work locally
        $('#page-content-wrapper a').each(function() {
        $(this).attr("href", function(index, old) {
            
            newstring1 = old.replace(docsName, "index.php?file="); // Add the index.php piece
            newstring2 = newstring1.replace(/=\/(.+?)/,'=$1'); // Find the string after the = and replace the \

            
            if (newstring2 != newstring1) { // only deal with URL's that had the index.php added
                newstring2 = newstring2 + '.md'; // add .md to the end of the URL
                }

            newstring3 = newstring2.replace(/\/.md/,'.md'); // Deal with any URLs with a stray /

            return newstring3;

            
        });
        });

        
    });
 
    </script>
    <!--<div class="container theme-showcase">-->
        <div id="wrapper">
            <!-- Sidebar -->
      <div id="sidebar-wrapper">

        <ul class="sidebar-nav">
          <li class="sidebar-brand"><a href="<?php echo $homePageURL;?>"><img src="../website_code/images/xerteLogo.jpg" alt="Xerte logo" /></a></li>
            <?php
          // print list of files in docsDir as menu

            // $categoryTemp = '';

            //foreach($pages as $page) { 
                /*
                $category = $page['category'];
                if($category != $categoryTemp) {
                    echo($page['category']);
                    $categoryTemp = $category; // TODO: Change this to collapsible list
                }
                */

                echo menuSetup($iterator);
                
                //echo('<li><a href="index.php?file='.$page['fileName'].'">'.$page['pageName'].'</a></li>');

                //}
            //foreach($directories as $directory) {

                //$directory = $docsDir.'/'.$directory;
                
                //echo('<li><a href="index.php?file='.$directory.'">'.$directory.'</a></li>');

                //}
            ?>
          
        </ul>
      </div>

      <!-- Main space for a primary marketing message or call to action -->
      <div class="well">
        <h1><?php echo $application; ?> > Documentation</h1>
        <p><?php echo $intro; ?></p>
      </div>
      
      
          
      <!-- Page content -->
      <div id="page-content-wrapper">
        <div class="content-header">
          <h1>
            <a id="menu-toggle" href="#" class="btn btn-default"><i class="icon-reorder"></i></a>
            <?php
                // echo $URLcategory.' / '.$URLpageName;
                echo $URLpageName;
                ?>
          </h1>
        </div>
        <!-- Keep all page content within the page-content inset div! -->
        <div class="page-content inset">
            <?php
                echo $fileHtml; // print out markdown file contents
                ?>

        </div>
      </div>
      
    
        
    

    





      



</div> <!-- Wrapper-->


    

    <!-- Custom JavaScript for the Menu Toggle -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
    </script>

  </body>


</html>