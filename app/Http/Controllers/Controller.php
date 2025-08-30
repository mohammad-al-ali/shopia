<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * The base controller class for the application.
 * All other controllers should extend this class to inherit
 * authorization and validation functionalities.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
