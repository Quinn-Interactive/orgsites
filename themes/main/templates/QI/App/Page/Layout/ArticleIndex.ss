<div class="content-container py-3">
    <% if $Title %>
        <h1>$Title</h1>
    <% end_if %>
    $Content

    <ul>
        <% loop $PaginatedList %>
            <li><a href="$Link">$Title</a></li>
        <% end_loop  %>
    </ul>
	<div class="overflow-hidden">
	    <% include Pagination %>
	</div>
</div>
