<% if $PaginatedList.MoreThanOnePage %>
    <nav aria-label="Pagination">
        <ul class="pagination">
        <% if $PaginatedList.NotFirstPage %>
            <li class="page-item">
                <a class="page-link" href="$PaginatedList.PrevLink" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <% end_if %>
        <% loop $PaginatedList.PaginationSummary %>
            <% if $CurrentBool %>
                <li class="page-item active" active" aria-current="page"><a class="page-link" href="$Link">$PageNum</a></li>
            <% else %>
                <% if $Link %>
                    <li class="page-item"><a class="page-link" href="$Link">$PageNum</a></li>
                <% else %>
                    <li class="page-item disabled">
                        <span class="page-link">…</span>
                  </li>
                <% end_if %>
            <% end_if %>
        <% end_loop %>
        <% if $PaginatedList.NotLastPage %>
            <li class="page-item">
                <a class="page-link" href="$PaginatedList.NextLink" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <% end_if %>
        </ul>
    </nav>
<% end_if %>
