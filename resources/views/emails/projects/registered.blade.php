@component('mail::message')
<div style="text-align:center; margin-bottom: 12px;">
  <img src="{{ asset('empire-kitchengold-icon.png') }}" alt="Empire Kitchen" style="height:60px; width:auto;">
</div>

# Your project is registered

Hi {{ $client->name ?? ($client->firstname ?? 'there') }},

Great news: your project **{{ $project->name }}** has been registered and work is underway.

**Current status:** {{ $statusLabel ?? 'In review' }}  
@if(!empty($stageLabel)) **Stage:** {{ $stageLabel }}<br> @endif
@if(!empty($project->location)) **Location:** {{ $project->location }}<br> @endif

We'll share your measurement schedule next and keep you updated at each milestone. If anything looks off, just reply to this email.

Thanks,  
{{ config('app.name', 'Empire Kitchens') }} Team
@endcomponent
