<?php

namespace App\Models;

use App\Enums\IdeaStatus;
use Database\Factories\IdeaFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property  IdeaStatus  $status
 *
 * @method  static  IdeaFactory           factory($count = null, $state = [])
 * @method  static  Builder<static>|Idea  newModelQuery()
 * @method  static  Builder<static>|Idea  newQuery()
 * @method  static  Builder<static>|Idea  query()
 *
 * @mixin Eloquent
 */
class Idea extends Model
{
    /** @use HasFactory<IdeaFactory> */
    use HasFactory;

    protected $casts = [
        'status' => IdeaStatus::class,
    ];
}
