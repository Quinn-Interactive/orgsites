<div class="content-container py-3">
    <% if $Title %>
        <h1>$Title</h1>
    <% end_if %>
    <% if not $Success %>
        $VerifySettingsForm
    <% else %>
        <p><a class="btn btn-primary" href="/">Home</a></p>
    <% end_if %>
</div>
