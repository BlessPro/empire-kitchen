@component('mail::message')
<div style="text-align:center; margin-bottom: 12px;">
  <img src="{{ asset('empire-kitchengold-icon.png') }}" alt="Empire Kitchen" style="height:60px; width:auto;">
</div>

# Measurement booked for {{ $project->name }}

Hi {{ $client->name ?? ($client->firstname ?? 'there') }},

We have booked your project for measurement.

@if(!empty($dateLabel))
- **Date:** {{ $dateLabel }}
@endif
@if(!empty($timeLabel))
- **Time:** {{ $timeLabel }}
@endif
@if(!empty($project->location))
- **Location:** {{ $project->location }}
@endif

If you need to adjust the appointment, reply to this email and we will reschedule.

Thanks,  
{{ config('app.name', 'Empire Kitchens') }} Team
@endcomponent
