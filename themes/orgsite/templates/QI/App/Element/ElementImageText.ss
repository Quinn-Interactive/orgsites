<% cached ElementImageText, $ID, $LastEdited, $Locale, $Image.ID, $Image.LastEdited %>
<div class="content-container py-3">
    <% if $ShowTitle && $Title %>
        <% if $Pos == 1 %><h1>$Title</h1><% else %><h2>$Title</h2><% end_if %>
    <% end_if %>
    <% if $Subtitle %>
        <p class="<% if $Pos == 1 %>fs-3<% else %>fs-4<% end_if %>">$Subtitle</p>
    <% end_if %>
    <% if $HTML %>
        $HTML
    <% end_if %>
    <div class="ElementImageText__row -image-$ImagePos">
        <% if $Image %>
        <div class="ElementImageText__image -image-$ImagePos">
            <% if $ImagePos == 'top' %>
                <img class="w-100 h-auto" src="$Image.ScaleMaxWidth(1272).Link" width="$Image.ScaleMaxWidth(1272).Width" height="$Image.ScaleMaxWidth(1272).Height" loading="lazy" alt="$Image.Title.ATT" />
            <% else %>
                <img class="w-100 h-auto" src="$Image.ScaleMaxWidth(512).Link" width="$Image.ScaleMaxWidth(512).Width" height="$Image.ScaleMaxWidth(512).Height" loading="lazy" alt="$Image.Title.ATT" />
            <% end_if %>
        </div>
        <% end_if %>
        <div class="ElementImageText__text -image-$ImagePos">
            <% if $HTML %>
                $HTML
            <% end_if %>
        </div>
    </div>
</div>
<% end_cached %>