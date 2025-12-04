<?php

namespace App\Observers;

use App\Mail\MeasurementScheduledMail;
use App\Models\Measurement;
use Illuminate\Support\Facades\Mail;
use App\Services\TwilioWhatsApp;

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

        // WhatsApp notify with schedule and stage
        $phone = $project->client?->phone_number;
        if ($phone) {
            [$dateLabel, $timeLabel] = $this->formatSchedule($measurement);
            $parts = [];
            if ($dateLabel) {
                $parts[] = "Date: {$dateLabel}";
            }
            if ($timeLabel) {
                $parts[] = "Time: {$timeLabel}";
            }
            $details = empty($parts) ? '' : ' (' . implode(', ', $parts) . ')';

            app(TwilioWhatsApp::class)->send(
                $phone,
                "Your project {$project->name} is now in the Measurement stage. Measurement booked{$details}."
            );
        }
    }

    private function formatSchedule(Measurement $measurement): array
    {
        $dateLabel = $measurement->scheduled_date
            ? $measurement->scheduled_date->format('F j, Y')
            : null;

        $start = $measurement->start_time;
        $end   = $measurement->end_time;

        $timeLabel = null;
        if ($start && $end) {
            $timeLabel = $start->format('g:i A') . ' - ' . $end->format('g:i A');
        } elseif ($start) {
            $timeLabel = $start->format('g:i A');
        }

        return [$dateLabel, $timeLabel];
    }
}
