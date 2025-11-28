<?php

namespace App\Mail;

use App\Models\Measurement;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeasurementScheduledMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Project $project,
        public Measurement $measurement
    ) {
        $this->project->loadMissing('client');
    }

    public function build(): self
    {
        [$dateLabel, $timeLabel] = $this->formatSchedule();

        return $this
            ->subject("Measurement booked for {$this->project->name}")
            ->markdown('emails.projects.measurement-scheduled', [
                'project'      => $this->project,
                'client'       => $this->project->client,
                'measurement'  => $this->measurement,
                'dateLabel'    => $dateLabel,
                'timeLabel'    => $timeLabel,
            ]);
    }

    private function formatSchedule(): array
    {
        $date  = $this->measurement->scheduled_date;
        $start = $this->measurement->start_time;
        $end   = $this->measurement->end_time;

        $dateLabel = $date ? $date->format('F j, Y') : null;

        $timeLabel = null;
        if ($start && $end) {
            $timeLabel = $start->format('g:i A') . ' - ' . $end->format('g:i A');
        } elseif ($start) {
            $timeLabel = $start->format('g:i A');
        }

        return [$dateLabel, $timeLabel];
    }
}
