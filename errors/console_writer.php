
<?php 

class sl
{

/**
* send a log message to the STDOUT stream.
// usage example : 
sl::log('Hello, world!');
// outputting an array : 
sl::log($_SERVER);
*
* @param array<int, mixed> $args
*
* @return void
*/
public static function log(...$args): void {

    foreach ($args as $arg) {

        if (is_object($arg) || is_array($arg) || is_resource($arg)) {
            $output = print_r($arg, true);
        } else {
            $output = (string) $arg;
        }

        fwrite(STDOUT, $output . "\n");
     }

}

}

?>