<div class="content-container py-3">
    <div class=" d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <% if $ShowTitle && $Title %>
            <% if $Pos == 1 %><h1>$Title</h1><% else %><h2>$Title</h2><% end_if %>
        <% end_if %>
        <% if $Index %>
            <a href="$Index.Link" class="d-block fs-5">
                <% if $IndexPromos.Count > CombinedPromos.Count %>
                    <%t Page.MORE_TITLE "More {title}" title=$Index.Title %>
                <% else %>
                    $Index.Title 
                <% end_if %>
                <i class="ms-1 bi bi-arrow-right-circle fs-6"></i>
            </a>
        <% end_if %>
    </div>
    <% if $HTML %>
        $HTML
    <% end_if %>

    <% if $CombinedPromos.Count %>
        <% if $PromoLayout == 'slider' %>
            <div class="slider" data-slider>
                <div class="$GridClasses mt-3 slider__slides" data-slider-slides>
                    <% loop $CombinedPromos %>
                        <%-- badges, cards --%>
                        <% if $Up.PromoType == 'badges' %>
                            <div class="col slider__slide"><% include QuinnInteractive/Orgsite/PromoBadge HideImages=$Up.HideImages %></div>
                        <% else_if $Up.PromoType == 'cards' %>
                            <div class="col slider__slide"><% include QuinnInteractive/Orgsite/PromoCard HideImages=$Up.HideImages %></div>
                        <% end_if %>
                    <% end_loop %>
                </div>
            </div>
        <% else %>
            <div class="$GridClasses mt-3">
                <% loop $CombinedPromos %>
                    <%-- badges, stack, cards, blocks --%>
                    <% if $Up.PromoType == 'badges' %>
                        <div class="col"><% include QuinnInteractive/Orgsite/PromoBadge HideImages=$Up.HideImages %></div>
                    <% else_if $Up.PromoType == 'stack' %>
                        <% include QuinnInteractive/Orgsite/PromoStack HideImages=$Up.HideImages %>
                    <% else_if $Up.PromoType == 'cards' %>
                        <div class="col"><% include QuinnInteractive/Orgsite/PromoCard HideImages=$Up.HideImages %></div>
                    <% else_if $Up.PromoType == 'blocks' %>
                        <% include QuinnInteractive/Orgsite/PromoBlock HideImages=$Up.HideImages %>
                    <% end_if %>
                <% end_loop %>
            </div>
        <% end_if %>
    <% end_if %>

</div>
