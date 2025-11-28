<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Project $project)
    {
        // Ensure the client relationship is available for the view without extra queries.
        $this->project->loadMissing('client');
    }

    public function build(): self
    {
        $status = $this->label($this->project->status, 'In review');
        $stage  = $this->label($this->project->current_stage, null);

        return $this
            ->subject("{$this->project->name} has been registered")
            ->markdown('emails.projects.registered', [
                'project'     => $this->project,
                'client'      => $this->project->client,
                'statusLabel' => $status,
                'stageLabel'  => $stage,
            ]);
    }

    private function label(?string $value, ?string $fallback): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return $fallback;
        }

        return ucwords(str_replace('_', ' ', strtolower($value)));
    }
}
