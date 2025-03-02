<div class="position-relative mb-3" lang="$SourceLocale.Locale">
    <% if not $HideImages %>
        <% if $CardImage %>
            <% with $CardImage %><% include QuinnInteractive/Orgsite/PromoBadgeImage %><% end_with %>
        <% else_if $FeaturedImage %>
            <% with $FeaturedImage %><% include QuinnInteractive/Orgsite/PromoBadgeImage %><% end_with %>
        <% else_if $Image %>
            <% with $Image %><% include QuinnInteractive/Orgsite/PromoBadgeImage %><% end_with %>
        <% end_if %>
    <% end_if %>
    <div>
        <% if not $HideText %>
        <h5 class="text-center">$Title</h5>
        <p class="text-center">
            <% if $Start || $Date || $DisplayDate %>
                <% include QuinnInteractive/Orgsite/EventDates %>
            <% end_if %>
            <% if not $HideSummaries %>$DescriptionOrSummary.RAW<% end_if %>
        </p>
        <% end_if %>
        <% if $Link %>
            <% if $Link.LinkURL %>
                <a 
                    href="$Link.LinkURL" 
                    class="
                        <% if $ButtonStyle != 'whole card' && not $HideText %>text-center d-block<% end_if %>
                        <% if $ButtonStyle != 'button' %> stretched-link<% end_if %>
                    "
                    title="$Title.ATT"
                    $Link.TargetAttr
                ><% if $ButtonStyle != 'whole card' && not $HideText %>
                    <% if $Link.Title %>$Link.Title<% else %><%t Page.READ_MORE "Read More" %><% end_if %>
                    <i class="bi bi-arrow-right-short"></i>
                <% end_if %></a>
            <% else %>
                <a 
                    href="$Link" 
                    class="
                        <% if $ButtonStyle != 'whole card' && not $HideText %>text-center d-block<% end_if %>
                        <% if $ButtonStyle != 'button' %> stretched-link<% end_if %>
                    "
                    title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>"
                ><% if $ButtonStyle != 'whole card' && not $HideText %><%t Page.READ_MORE "Read More" %> <i class="bi bi-arrow-right-short"></i><% end_if %></a>
            <% end_if %>
        <% end_if %>
    </div>
</div>
