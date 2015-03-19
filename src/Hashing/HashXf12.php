<?php

namespace MyBB\Auth\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

/**
 * Hasher for legacy XenForo passwords, using basic PHPass. TODO: 1.0/1.1 passwords, so don't remove the empty class
 *
 * @package MyBB\Auth
 */
class HashXf12 extends HashPhpass
{

}
