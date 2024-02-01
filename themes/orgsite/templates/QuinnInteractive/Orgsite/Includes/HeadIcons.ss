<% cached 'HeadIcons', $Locale, $SiteConfig.LastEdited %>
    <% if $SiteConfig.FaviconSmallOrLogo && $SiteConfig.FaviconSmallOrLogo.IsImage %>
        <% with $SiteConfig.FaviconSmallOrLogo %>
            <link rel="shortcut icon" type="$MimeType" href="$Pad(16,16).URL?v=$Version"/>
            <link rel="icon" type="$MimeType" sizes="16x16" href="$Pad(16,16).URL?v=$Version">
        <% end_with %>
    <% end_if %>
    <% if $SiteConfig.FaviconLargeOrLogo && $SiteConfig.FaviconSmallOrLogo.IsImage %>
        <% with $SiteConfig.FaviconLargeOrLogo %>
            <% if $Width >= 57 %><link rel="apple-touch-icon" sizes="57x57" href="$Pad(57,57).URL?v=$Version"><% end_if %>
            <% if $Width >= 60 %><link rel="apple-touch-icon" sizes="60x60" href="$Pad(60,60).URL?v=$Version"><% end_if %>
            <% if $Width >= 73 %><link rel="apple-touch-icon" sizes="72x72" href="$Pad(73,73).URL?v=$Version"><% end_if %>
            <% if $Width >= 76 %><link rel="apple-touch-icon" sizes="76x76" href="$Pad(76,76).URL?v=$Version"><% end_if %>
            <% if $Width >= 114 %><link rel="apple-touch-icon" sizes="114x114" href="$Pad(114,114).URL?v=$Version"><% end_if %>
            <% if $Width >= 120 %><link rel="apple-touch-icon" sizes="120x120" href="$Pad(120,120).URL?v=$Version"><% end_if %>
            <% if $Width >= 144 %><link rel="apple-touch-icon" sizes="144x144" href="$Pad(144,144).URL?v=$Version"><% end_if %>
            <% if $Width >= 152 %><link rel="apple-touch-icon" sizes="152x152" href="$Pad(152,152).URL?v=$Version"><% end_if %>
            <% if $Width >= 180 %><link rel="apple-touch-icon" sizes="180x180" href="$Pad(180,180).URL?v=$Version"><% end_if %>
            <% if $Width >= 192 %><link rel="icon" type="$MimeType" sizes="192x192"  href="$Pad(192,192).URL?v=$Version"><% end_if %>
            <% if $Width >= 32 %><link rel="icon" type="$MimeType" sizes="32x32" href="$Pad(32,32).URL?v=$Version"><% end_if %>
            <% if $Width >= 96 %><link rel="icon" type="$MimeType" sizes="96x96" href="$Pad(96,96).URL?v=$Version"><% end_if %>
        <% end_with %>
    <% end_if %>
<% end_cached %>