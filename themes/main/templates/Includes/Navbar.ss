<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="content-container">
        <a class="navbar-brand" href="/">$SiteConfig.Title</a>
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
                <div class="search-form">$SearchForm</div>
            </div>
        </div>
    </div>
</nav>