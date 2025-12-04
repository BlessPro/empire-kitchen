<?php

namespace App\Observers;

use App\Mail\ProjectRegisteredMail;
use App\Models\Project;
use Illuminate\Support\Facades\Mail;
use App\Services\TwilioWhatsApp;

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

        // WhatsApp notify on project creation
        $phone = $project->client?->phone_number;
        if ($phone) {
            app(TwilioWhatsApp::class)->send(
                $phone,
                "Your project {$project->name} has been registered. We'll share your measurement schedule next."
            );
        }
    }
}
