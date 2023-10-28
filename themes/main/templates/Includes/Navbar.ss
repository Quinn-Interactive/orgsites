<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="content-container">
        <a class="navbar-brand" href="/$CurrentLocaleObject.URLSegment">$SiteConfig.Title</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div  id="navbarSupportedContent" class="offcanvas offcanvas-end" tabindex="-1" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <% loop $Menu(1) %>
                        <% if $Link == '/' %>
                            <%-- don't show home --%>
                        <% else_if $Children %>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <% if $IsSection %>active<% end_if %>" <% if $IsCurrent %>aria-current="page"<% end_if %> href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    $MenuTitle
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item <% if $IsCurrent %>active<% end_if %>" <% if $IsCurrent %>aria-current="page"<% end_if %>href="$Link">$MenuTitle</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <% loop $Children %>
                                    <li><a class="dropdown-item <% if $IsSection %>active<% end_if %>" <% if $IsCurrent %>aria-current="page"<% end_if %>href="$Link">$MenuTitle</a></li>
                                    <% end_loop %>
                                </ul>
                            </li>
                        <% else %>
                            <li class="nav-item">
                                <a class="nav-link <% if $IsSection %>active<% end_if %>" <% if $IsCurrent %>aria-current="page"<% end_if %>href="$Link">$MenuTitle</a>
                            </li>
                        <% end_if %>
                    <% end_loop %>
                </ul>
                <%-- <% if $Locales %>
                    <div class="left">Locale <span class="arrow">&rarr;</span>
                        <nav class="primary">
                            <ul>
                                <% loop $Locales %>
                                    <li class="$LinkingMode">
                                        <a href="$Link.ATT" <% if $LinkingMode != 'invalid' %>rel="alternate"
                                        hreflang="$HrefLang"<% end_if %>>$Title.XML</a>
                                    </li>
                                <% end_loop %>
                            </ul>
                        </nav>
                    </div>
                <% end_if %> --%>
                <ul class="navbar-nav">
                    <% if $Locales.Count > 1 %>
                        <% if $Locales.Count > 3 %>
                        <li class="nav-item dropdown me-3">
                            <button class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <%t TractorCow\Fluent\Model\Locale.LOCALE "Locale" %>
                            </button>
                            <ul class="dropdown-menu">
                                <% loop $Locales %>
                                <li class="$LinkingMode">
                                    <a class="dropdown-item $LinkingMode" 
                                        href="$Link.ATT"
                                        <% if $LinkingMode != 'invalid' %>rel="alternate" hreflang="$HrefLang"<% end_if %>
                                    >
                                        $Title
                                    </a>
                                </li>
                                <% end_loop %>
                            </ul>
                        </li>
                        <% else %>
                            <% loop $Locales %>
                            <li class="nav-item $LinkingMode me-3">
                                <a class="$LinkingMode nav-link" 
                                    href="$Link.ATT"
                                    <% if $LinkingMode != 'invalid' %>rel="alternate" hreflang="$HrefLang"<% end_if %>
                                >
                                    $Title
                                </a>
                            </li>
                            <% end_loop %>
                        <% end_if %>
                    <% end_if %>
                    <li class="nav-item search-form mt-1">$SearchForm</li>
                </ul>
            </div>
        </div>
    </div>
</nav>