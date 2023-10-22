<div class="content-container py-3">
    <% if $Title %>
        <h1>$Title for: $Query</h1>
    <% end_if %>
    <% if not $Results %>
        <p>Sorry, your search query did not return any results.</p>
    <% else %>
        <p>Found $Results.TotalItems results for <q>$Query</q></p>
        <ul class="">
            <% loop $Results %>
            <li class="">
                <a href="$Link" class="">
                    <h2 class="">$Title</h2>
                    <div class="">
                        <% if $PublishDate %>
                            <strong>$PublishDate.Month $PublishDate.DayOfMonth(true), $PublishDate.Year:</strong>
                        <% end_if %>
                        <% if $Summary %>
                            $Summary
                        <% else_if $MetaDescription %>
                            $MetaDescription
                        <% else %>
                            $Content.Summary(80, '…')
                        <% end_if %>
                    </div>
                </a>
            </li>
            <% end_loop %>
        </ul>

    <% end_if %>
</div>
