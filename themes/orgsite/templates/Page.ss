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
    <link rel="apple-touch-icon" sizes="57x57" href="/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">

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
<body class="body d-flex flex-column d-flex flex-column">
    <% include QuinnInteractive/Orgsite/Header %>
    <main class="main flex-grow-1 d-flex flex-column">
        $Layout
    </main>
    <% include QuinnInteractive/Orgsite/Footer %>
    <script src="$resourceURL('quinninteractive/orgsite:themes/orgsite/dist/js/index.js')"></script>
    <% include QuinnInteractive/Orgsite/ThemeVars %>    
</body>
</html>
