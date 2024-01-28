<!doctype html>
<html class="no-js" lang="$SourceLocale.Locale">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <% base_tag %>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %></title>
    <% if $MetaTitle %>$MetaTags(0)<% end_if %>

    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <meta
        name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, viewport-fit=cover"
    />
    <% include QuinnInteractive/Orgsite/Includes/HeadIcons %>
    <%-- change js class on html --%>
    <script>
        var html = document.getElementsByTagName('html')[0];
        html.classList.remove('no-js');
        html.classList.add('js');
    </script>
    <%-- detect touch devices --%>
    <script>
        document.documentElement.className +=  (("ontouchstart" in document.documentElement) ? ' touch' : ' no-touch');
    </script>
    <%-- load any fonts if needed --%>
    $SiteConfig.FontHeadCode.RAW
    <%-- CSS --%>
    <% require themedCSS('dist/css/styles') %>
</head>
<body class="body d-flex flex-column d-flex flex-column min-vh-100 $SiteConfig.DefaultBgTextColor.BgClass $SiteConfig.DefaultBgTextColor.CssClass">
    <% include QuinnInteractive/Orgsite/Header %>
    <main class="main flex-grow-1 d-flex flex-column">
        $Layout
    </main>
    <% include QuinnInteractive/Orgsite/Footer %>
    <script src="$resourceURL('quinninteractive/orgsite:themes/orgsite/dist/js/index.js')"></script>
    <% include QuinnInteractive/Orgsite/ThemeVars %>    
</body>
</html>
