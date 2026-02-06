<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions; // Add this import

class Category extends Model
{
    use LogsActivity;

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'status',
    ];

    /**
     * Define the logging options for Spatie Activitylog
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['category_name', 'status']) // Track these specific fields
            ->logOnlyDirty()                       // Only record a log if data actually changed
            ->dontSubmitEmptyLogs()                 // Don't save a log if the user just hit "Save" without changes
            ->useLogName('category');              // Optional: Groups these logs under 'category' in the DB
    }
}
