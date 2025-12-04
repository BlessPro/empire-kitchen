{{-- Thin wrapper to reuse the shared project info partial without the admin sidebar --}}
@include('partials.profileinforeuse', [
    'project'                => $project,
    'layoutComponent'        => 'designer-layout',
    'projectManagementRoute' => 'designer.AssignedProjects',
    'headerInclude'          => 'designer.layouts.header',
])
