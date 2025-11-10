<div class="install-comments">
    <style>
        /* Override admin green for Send button in Installation only */
        .install-comments .bg-emerald-600 { background-color: #5A0562 !important; }
        .install-comments .hover\:bg-emerald-700:hover { background-color: #4a044c !important; }
        .install-comments .hover\:bg-emerald-800:hover { background-color: #4a044c !important; }
        /* Fallback: target the drawer submit button regardless of classes */
        .install-comments footer form button[type="submit"] {
            background-color: #5A0562 !important;
            color: #fff !important;
        }
        .install-comments footer form button[type="submit"]:hover {
            background-color: #4a044c !important;
        }
    </style>
    @include('admin.partials.comments-drawer', ['project' => $project])
  </div>
