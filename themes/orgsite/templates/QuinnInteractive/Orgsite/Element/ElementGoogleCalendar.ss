<div class="content-container py-3">
    <% if $ShowTitle && $Title %>
        <% if $Pos == 1 %><h1>$Title</h1><% else %><h2>$Title</h2><% end_if %>
    <% end_if %>
    <% if $HTML %>
        $HTML
    <% end_if %>
    <% if $URL %>
        <iframe src="$URL" class="w-100 border-0 d-none d-md-block" width="800" height="600" frameborder="0" scrolling="no"></iframe>
        <iframe src="{$URL}&mode=agenda" class="w-100 border-0 d-block d-md-none" width="800" height="600" frameborder="0" scrolling="no"></iframe>
    <% end_if %>

</div>
