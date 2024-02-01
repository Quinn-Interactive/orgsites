<div class="mb-2">
    <i class="bi bi-calendar me-1" aria-hidden></i>
    <% if $DisplayDate %>
        $DisplayDate
    <% else %>
        <% if $ShowTimes %>$Start.Nice<% else %>$Start.Date<% end_if %>
        <% if $End %>
            &ndash; <% if $ShowTimes %>$End.Nice<% else %>$End.Date<% end_if %>
        <% end_if %>
    <% end_if %>
</div>
