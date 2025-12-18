<?php
$lib_dir = get_stylesheet_directory()  . '/lib';

$priority_files = [
  'functions-setup.php',
  'functions-utilities.php',
  'functions-scripts-styles.php',
];

foreach ($priority_files as $file) {
  $priority = $lib_dir . '/' . $file;
  if (file_exists($priority)) {
    require_once $priority;
  }
}

$function_files = glob($lib_dir . '/functions-*.php');
if ($function_files !== false && !empty($function_files)) {
   foreach ($function_files as $file) {
        if (!in_array(basename($file), $priority_files, true)) {
            require_once $file;
        }
    }
} else {
  if ($function_files === false) {
     error_log(" glob() failed when scanning {$lib_dir}/functions-*.php");
  }
}