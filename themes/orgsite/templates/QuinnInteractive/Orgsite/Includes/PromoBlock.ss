<div class="d-md-flex mb-3 <% if not $Last %>border-bottom border-primary pb-3<% end_if %>" lang="$SourceLocale.Locale">
    <% if not $HideImages %>
        <% if $CardImage || $FeaturedImage || $Image %>
            <div class="w-md-50 flex-shrink-0 ms-md-4 mb-3 mb-md-0 order-2">
                <% if $CardImage %>
                    <% with $CardImage %><% include QuinnInteractive/Orgsite/PromoCardImage %><% end_with %>
                <% else_if $FeaturedImage %>
                    <% with $FeaturedImage %><% include QuinnInteractive/Orgsite/PromoCardImage %><% end_with %>
                <% else_if $Image %>
                    <% with $Image %><% include QuinnInteractive/Orgsite/PromoCardImage %><% end_with %>
                <% end_if %>
            </div>
        <% end_if %>
    <% end_if %>

    <div class="flex-grow-1 order-1">
        <h5>$Title</h5>
        <% if $Start || $Date || $DisplayDate %>
            <% include QuinnInteractive/Orgsite/EventDates %>
        <% end_if %>
        <p>
            <% if not $HideSummaries %>$DescriptionOrSummary.RAW<% end_if %>
            <% if $Link %>
                <% if $Link.LinkURL %>
                    <a 
                        href="$Link.LinkURL" 
                        class="
                        <% if $ButtonStyle != 'whole card' && not $Parent.HideText %>text-nowrap<% end_if %>
                        <% if $ButtonStyle != 'button' %> stretched-link<% end_if %>
                        "
                        title="$Title.ATT"
                    ><% if $ButtonStyle != 'whole card' && not $Parent.HideText %>
                        <% if $Link.Title %>$Link.Title<% else %><%t Page.READ_MORE "Read More" %><% end_if %>
                        <i class="bi bi-arrow-right-short"></i>
                    <% end_if %></a>
                <% else %>
                    <a 
                        href="$Link" 
                        class="
                        <% if $ButtonStyle != 'whole card' && not $Parent.HideText %>text-nowrap<% end_if %>
                        <% if $ButtonStyle != 'button' %> stretched-link<% end_if %>
                        "
                        title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>"
                    ><% if $ButtonStyle != 'whole card' && not $Parent.HideText %><%t Page.READ_MORE "Read More" %> <i class="bi bi-arrow-right-short"></i><% end_if %></a>
                <% end_if %>
            <% end_if %>
        </p>
    </div>
</div>
