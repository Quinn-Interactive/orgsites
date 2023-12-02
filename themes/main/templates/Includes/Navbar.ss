<nav class="navbar navbar-expand-lg bg-$SiteConfig.NavbarBg $SiteConfig.NavbarTextColor.CssClass $SiteConfig.NavbarTextColor.NavbarBGClass">
    <div class="content-container">
        <a class="navbar-brand d-block $SiteConfig.NavbarTextColor.CssClass position-relative" href="/$CurrentLocaleObject.URLSegment" title="$SiteConfig.Title.ATT">
            <% include Brand %>
        </a>
        <button class="navbar-toggler $SiteConfig.NavbarTextColor.CssClass" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div  id="navbarSupportedContent" class="offcanvas offcanvas-end" tabindex="-1" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header $SiteConfig.NavbarTextColor.CssClass bg-$SiteConfig.NavbarBg">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><% include Brand %></h5>
                <button type="button" class="btn-close $SiteConfig.NavbarTextColor.BtnCloseClass" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body bg-$SiteConfig.NavbarBg">
                <ul class="navbar-nav $SiteConfig.NavbarTextColor.CssClass ms-auto">
                    <% loop $Menu(1) %>
                        <% if $IsHomePage %>
                            <%-- don't show home --%>
                        <% else_if $Children %>
                            <li class="nav-item dropdown">
                                <a class="nav-link $SiteConfig.NavbarTextColor.CssClass dropdown-toggle <% if $IsSection %>active<% end_if %>" <% if $IsCurrent %>aria-current="page"<% end_if %> href="#" role="button" data-bs-toggle="dropdown"
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
                                <a class="nav-link $SiteConfig.NavbarTextColor.CssClass <% if $IsSection %>active<% end_if %>" <% if $IsCurrent %>aria-current="page"<% end_if %>href="$Link">$MenuTitle</a>
                            </li>
                        <% end_if %>
                    <% end_loop %>

                    <% if $Locales.Count > 1 %>
                        <li class="nav-item dropdown me-3">
                            <button class="nav-link $SiteConfig.NavbarTextColor.CssClass dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-translate"></i> <%t Page.LANGUAGE "Language" %>
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
                    <% end_if %>
                    <%-- <li class="nav-item dropdown">
                        <button class="nav-link $SiteConfig.NavbarTextColor.CssClass dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-search" title="<%t SilverStripe\CMS\Search.SEARCH "Search" %>"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="nav-link $SiteConfig.NavbarTextColor.CssClass search-form">$SearchForm</div>
                        </div>
                    </li> --%>
                </ul>
            </div>
        </div>
    </div>
</nav>