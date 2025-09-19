<?php
/**
 * Get the root directory name of the current script.
 */
$route = __FILE__;
$dir = dirname($route);

/**
 * Get the base name of the root directory.
 */
$ROOTNAME = basename($dir);