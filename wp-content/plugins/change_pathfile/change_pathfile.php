<?php
/**
 * Plugin Name:  Change file path
 * Description:  Mon premier plugin
 * Version:      0.1.0
 * Author:       Joris Bertier
 * Requires PHP: 8.0
 */

require 'vendor/autoload.php';


function get_filepath($filename)
{
    // transform filename
    $filename = strtolower($filename);
    $new_filepath = uniqid() . $filename;
    return $new_filepath;
}


add_filter('sanitize_file_name', 'get_filepath');