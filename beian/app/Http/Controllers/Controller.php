<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    // Controller now extends framework base to provide middleware(), authorizes(), etc.
}
