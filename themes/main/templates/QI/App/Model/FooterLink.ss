<% if LinkURL %>
    <a{$IDAttr}{$ClassAttr} href="{$LinkURL}"{$TargetAttr} <% if $HideTitle %>title="$Title.ATT"<% end_if %>>
        <% if $IconClass %>
            <i class="bi bi-$IconClass" aria-hidden="true"></i>
        <% else_if $IconFile %>
            <% if $IconFile.IsImage %>
                <img style="height: 1lh; width: auto" src="$IconFile.ScaleHeight(24).URL" width="auto" height="24" alt="$IconFile.Title.ATT">
            <% else_if $IconFile.Extension == 'svg' %>
                <img style="height: 1lh; width: auto" src="$IconFile.URL" width="auto" height="24" alt="$IconFile.Title.ATT">
            <% end_if %>
        <% end_if %>
        <% if not $HideTitle %>{$Title}<% end_if %>
    </a>
<% end_if %>
