<?php
/*
Use in code:
$_POST = clean( $_POST, 'addslashes');
*/

// to protect from bad users
function clean($data, $how)
{
if ( is_array( $data ) )
    {
    foreach ( $data as $k => $v )
        {
        $data[ $k ] = clean( $v, $how );
        }
    return $data;
    }
else
    {
    // $data = str_replace(array("\t", "\r\n", "\n"), '', $data); // tabs and new lines too
    if ( $how == 'trim' )
        {
        return trim( $data );
        }
    else if ( $how == 'int' )
        {
        return (int)$data;
        }
    else if ( $how == 'float' )
        {
        return (float)$data;
        }
    else if ( $how == 'addslashes' )
        {
        return addslashes( $data );
        }
    else if ( $how == 'stripslashes' )
        {
        return stripslashes( $data );
        }
    else if ( $how == 'htmlentities' )
        {
        return htmlentities( $data );
        }
    }
echo 'WRONG clean() DEFINITION. USE: clean($data, $how)';
exit();
}










?>