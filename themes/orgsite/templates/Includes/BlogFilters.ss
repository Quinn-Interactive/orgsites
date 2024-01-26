<% if $BlogYears.Count > 1 || $Categories.Count || $Tags.Count %>
<div class="blog-filters mb-3">
    <% if $BlogYears.Count > 1 %>
    <div class="dropdown d-inline-block me-2">
        <button class="btn <% if $ArchiveYear %>btn-primary<% else %>btn-secondary<% end_if %> dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <% if $ArchiveYear %>$ArchiveYear.Title<% else %><%t Page.CHOOSE_YEAR "Choose Year" %><% end_if %>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="$Link"><%t Page.ALL_YEARS "All Years" %></a></li>
            <% loop $BlogYears %>
                <li><a class="dropdown-item <% if $Top.ArchiveYear.ID == $ID %>active<% end_if %>" href="{$Up.Link}archive/$Year">$Year</a></li>
            <% end_loop %>
        </ul>
    </div>
    <% end_if %>

    <% if $Categories.Count %>
    <div class="dropdown d-inline-block me-2">
        <button class="btn <% if $CurrentCategory %>btn-primary<% else %>btn-secondary<% end_if %> dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <% if $CurrentCategory %>$CurrentCategory.Title<% else %><%t Page.CHOOSE_CATEGRORY "Choose Category" %><% end_if %>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="$Link"><%t Page.ALL_CATEGORIES "All categories" %></a></li>
            <% loop $Categories.Sort('Title') %>
                <li><a class="dropdown-item <% if $Top.CurrentCategory.ID == $ID %>active<% end_if %>" href="$Link">$Title</a></li>
            <% end_loop %>
        </ul>
    </div>
    <% end_if %>

    <% if $Tags.Count %>
    <div class="dropdown d-inline-block me-2">
        <button class="btn <% if $CurrentTag %>btn-primary<% else %>btn-secondary<% end_if %> dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <% if $CurrentTag %>$CurrentTag.Title<% else %><%t Page.CHOOSE_Tag "Choose Tag" %><% end_if %>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="$Link"><%t Page.ALL_TAGS "All tags" %></a></li>
            <% loop $Tags.Sort('Title') %>
                <li><a class="dropdown-item <% if $Top.CurrentTag.ID == $ID %>active<% end_if %>" href="$Link">$Title</a></li>
            <% end_loop %>
        </ul>
    </div>
    <% end_if %>
</div>
<% end_if %>
