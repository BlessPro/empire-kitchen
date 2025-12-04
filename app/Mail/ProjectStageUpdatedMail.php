<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectStageUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Project $project,
        public string $stage,
        public string $messageLine
    ) {
        $this->project->loadMissing('client');
    }

    public function build(): self
    {
        $stageLabel = $this->label($this->stage, null);

        return $this
            ->subject("{$this->project->name} - {$stageLabel}")
            ->markdown('emails.projects.stage-update', [
                'project'     => $this->project,
                'client'      => $this->project->client,
                'stageLabel'  => $stageLabel,
                'messageLine' => $this->messageLine,
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
