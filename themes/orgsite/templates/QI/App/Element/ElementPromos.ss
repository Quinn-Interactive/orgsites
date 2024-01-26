<div class="content-container py-3">
    <% if $ShowTitle && $Title %>
        <% if $Pos == 1 %><h1>$Title</h1><% else %><h2>$Title</h2><% end_if %>
    <% end_if %>
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
                            <div class="col slider__slide"><% include PromoBadge HideImages=$Up.HideImages %></div>
                        <% else_if $Up.PromoType == 'cards' %>
                            <div class="col slider__slide"><% include PromoCard HideImages=$Up.HideImages %></div>
                        <% end_if %>
                    <% end_loop %>
                </div>
            </div>
        <% else %>
            <div class="$GridClasses mt-3">
                <% loop $CombinedPromos %>
                    <%-- badges, stack, cards, blocks --%>
                    <% if $Up.PromoType == 'badges' %>
                        <div class="col"><% include PromoBadge HideImages=$Up.HideImages %></div>
                    <% else_if $Up.PromoType == 'stack' %>
                        <% include PromoStack HideImages=$Up.HideImages %>
                    <% else_if $Up.PromoType == 'cards' %>
                        <div class="col"><% include PromoCard HideImages=$Up.HideImages %></div>
                    <% else_if $Up.PromoType == 'blocks' %>
                        <% include PromoBlock HideImages=$Up.HideImages %>
                    <% end_if %>
                <% end_loop %>
            </div>
        <% end_if %>
    <% end_if %>
</div>
