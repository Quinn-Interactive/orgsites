<% if $SiteConfig.Logo && $SiteConfig.Logo.IsImage %>
    <img src="$SiteConfig.Logo.ScaleHeight(80).URL" class="mh-100 w-auto" alt="$SiteConfig.Title.ATT" height="40" width="40">
<% else_if $SiteConfig.Logo && $SiteConfig.Logo.Extension == 'svg'  %>
    <img src="$SiteConfig.Logo.URL" class="mh-100 w-auto" alt="$SiteConfig.Title.ATT" height="40" width="40">
<% else %>
    $SiteConfig.Title
<% end_if %>
