<div class="mb-2">
    <% if $iCalLink %>
        <a href="$iCalLink" class="bi bi-calendar-plus me-1" aria-hidden title="<%t QuinnInteractive\\Orgsite\\Page\\Calendar.ADD_TO_CALENDAR 'Add to calendar' %>"></a>
    <% else %>
        <i class="bi bi-calendar me-1" aria-hidden></i>
    <% end_if %>
    <% if $DisplayDate %>
        $DisplayDate
    <% else %>
        <% if $AllDay %>$Start.Date<% else %>$Start.Nice<% end_if %>
        <% if $End %>
            &ndash; <% if $AllDay %>$End.Date<% else %>$End.Nice<% end_if %>
        <% end_if %>
    <% end_if %>
</div>
