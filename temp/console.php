<?php

// testing access to javascript debug console
function debug_to_console($data)
{
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

debug_to_console('hi there');
?>