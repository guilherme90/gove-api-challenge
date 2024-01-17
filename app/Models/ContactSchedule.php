<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactSchedule extends Model
{
    protected $table = 'contacts_schedules';

    protected $fillable = ['contact_id', 'scheduled_at'];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
