<div class="mb-2">
    <i class="bi bi-calendar me-1" aria-hidden></i>
    <% if $DisplayDate %>
        $DisplayDate
    <% else %>
        <% if $AllDay %>$Start.Date<% else %>$Start.Nice<% end_if %>
        <% if $End %>
            &ndash; <% if $AllDay %>$End.Date<% else %>$End.Nice<% end_if %>
        <% end_if %>
    <% end_if %>
</div>
