<?php

namespace App\Models;

use App\Enums\IdeaStatus;
use Database\Factories\IdeaFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property  int          $id
 * @property  string       $description  The idea description.
 * @property  IdeaStatus   $status       The idea status.
 * @property  Carbon|null  $created_at
 * @property  Carbon|null  $updated_at
 *
 * @method  static  IdeaFactory           factory($count = null, $state = [])
 * @method  static  Builder<static>|Idea  newModelQuery()
 * @method  static  Builder<static>|Idea  newQuery()
 * @method  static  Builder<static>|Idea  query()
 * @method  static  Builder<static>|Idea  whereCreatedAt($value)
 * @method  static  Builder<static>|Idea  whereDescription($value)
 * @method  static  Builder<static>|Idea  whereId($value)
 * @method  static  Builder<static>|Idea  whereStatus($value)
 * @method  static  Builder<static>|Idea  whereUpdatedAt($value)
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
