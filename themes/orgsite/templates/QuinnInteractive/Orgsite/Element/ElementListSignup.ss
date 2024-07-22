<div class="content-container py-3">
    <% if $ShowTitle && $Title %>
        <% if $Pos == 1 %><h1>$Title</h1><% else %><h2>$Title</h2><% end_if %>
    <% end_if %>
    <% if $HTML %>
        $HTML
    <% end_if %>
    <% if $ListSignupSuccess %>
        $SuccessMessage
    <% else %>
        $SignupForm
    <% end_if %>
</div>
