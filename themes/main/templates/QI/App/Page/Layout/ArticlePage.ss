<div class="content-container py-3">
    <% if $Level(2) %>
        <div class="mb-3">
            $Breadcrumbs
        </div>
    <% end_if %>
    <% if $Title %>
        <h1>$Title</h1>
    <% end_if %>
    $Content
</div>
