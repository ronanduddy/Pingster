<?php

if(!function_exists('get_gravatar')) {

    function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = true, $atts = array() ) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<i><img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' /></i>';
        }
        return $url;
    }
}

$grav_email = isset($grav_email) ? $grav_email : $current_user["email"];
$s = isset($size) ? $size : 40;

echo get_gravatar($grav_email, $s);

?>