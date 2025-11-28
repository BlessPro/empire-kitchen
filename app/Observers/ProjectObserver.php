<?php

namespace App\Observers;

use App\Mail\ProjectRegisteredMail;
use App\Models\Project;
use Illuminate\Support\Facades\Mail;

class ProjectObserver
{
    public function created(Project $project): void
    {
        $project->loadMissing('client');

        $email = $project->client?->email;
        if (!$email) {
            return;
        }

        Mail::to($email)->send(new ProjectRegisteredMail($project));
    }
}
