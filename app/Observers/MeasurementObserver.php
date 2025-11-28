<?php

namespace App\Observers;

use App\Mail\MeasurementScheduledMail;
use App\Models\Measurement;
use Illuminate\Support\Facades\Mail;

class MeasurementObserver
{
    public function created(Measurement $measurement): void
    {
        $measurement->loadMissing('project.client');

        $project = $measurement->project;
        $email   = $project?->client?->email;

        if (!$email) {
            return;
        }

        // Only send when a schedule exists (prevents noise on raw measurement rows without a booking).
        if (!$measurement->scheduled_date && !$measurement->start_time) {
            return;
        }

        Mail::to($email)->send(new MeasurementScheduledMail($project, $measurement));
    }
}
