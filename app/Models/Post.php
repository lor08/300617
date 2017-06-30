<?php

namespace App\Models;

use App\Traits\Categorizable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	use Categorizable;
}
