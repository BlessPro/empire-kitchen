@component('mail::message')
<div style="text-align:center; margin-bottom: 12px;">
  <img src="{{ asset('empire-kitchengold-icon.png') }}" alt="Empire Kitchen" style="height:60px; width:auto;">
</div>

# {{ $stageLabel ?? 'Project update' }}

Hi {{ $client->name ?? ($client->firstname ?? 'there') }},

{{ $messageLine }}

- **Project:** {{ $project->name }}
@if(!empty($project->location))
- **Location:** {{ $project->location }}
@endif

We'll keep you posted as we progress to the next stage. If you have any questions, just reply to this email.

Thanks,  
{{ config('app.name', 'Empire Kitchens') }} Team
@endcomponent
