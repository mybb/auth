<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

/**
 * Hasher for legacy IPB 2/3 passwords, using the same algoritm as MyBB 1.x used
 *
 * @package MyBB\Auth
 */
class HashIpb implements HasherContract
{
    private $mybbHasher;

    public function __construct(HashMybb1 $mybbHasher)
    {
        $this->mybbHasher = $mybbHasher;
    }

    public function make($value, array $options = array())
    {
        // This is IPB's way of filtering input - the rest of the hashing is the same we use
        $value = str_replace( "&"			, "&amp;"         , $value );
        $value = str_replace( "<!--"	    , "&#60;&#33;--"  , $value );
        $value = str_replace( "-->"			, "--&#62;"       , $value );
        $value = str_ireplace( "<script"	, "&#60;script"   , $value );
        $value = str_replace( ">"			, "&gt;"          , $value );
        $value = str_replace( "<"			, "&lt;"          , $value );
        $value = str_replace( '"'			, "&quot;"        , $value );
        $value = str_replace( "\n"			, "<br />"        , $value );
        $value = str_replace( "$"			, "&#036;"        , $value );
        $value = str_replace( "!"			, "&#33;"         , $value );
        $value = str_replace( "'"			, "&#39;"         , $value );

        return $this->mybbHasher->make($value, $options);
    }

    public function check($value, $hashedValue, array $options = array())
    {
        return $this->mybbHasher->check($value, $hashedValue, $options);
    }

    public function needsRehash($hashedValue, array $options = array())
    {
        return false;
    }
}
