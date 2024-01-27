<div class="content-container py-3">
    <% if $Level(2) %>
        <div class="mb-3">
            $Breadcrumbs
        </div>
    <% end_if %>
    <h1>$Title</h1>
    <div>$Date.Nice</div>
    <% if $AuthorMember %>
    <div>By $AuthorMember.Name</div>
    <% else_if $AuthorName %>
    <div>By $AuthorName</div>
    <% end_if %>
    $Content
</div>
