<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class People extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'peoples';

    // protected static $logAttributes = ['*'];

    // protected static $logOnlyDirty = true;

    // $newsItem = People::create([
    //     'name' => 'original name',
    //     'text' => 'Lorum'
    // ]);

    // //creating the newsItem will cause an activity being logged
    // $activity = Activity::all()->last();

    // $activity->description; //returns 'created'
    // $activity->subject; //returns the instance of NewsItem that was created
    // $activity->changes(); //returns ['attributes' => ['name' => 'original name', 'text' => 'Lorum']];


    // protected $fillable = ['name', 'text'];

    // protected static $logAttributes = ['name', 'text'];


    // protected static $logAttributes = [];

    // protected static $logFillable = true;

    // protected static $logOnlyDirty = true;

}
