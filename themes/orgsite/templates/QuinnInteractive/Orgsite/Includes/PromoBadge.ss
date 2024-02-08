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
        <h5>$Title</h5>
        <p>
            <% if $Start || $Date || $DisplayDate %>
                <% include QuinnInteractive/Orgsite/EventDates %>
            <% end_if %>
            $DescriptionOrSummary
        </p>
        <% end_if %>
        <% if $Link %>
            <% if $Link.LinkURL %>
                <a 
                    href="$Link.LinkURL" 
                    class="text-nowrap<% if $StretchedLink || $HideText %> stretched-link<% end_if %>"
                    title="$Title.ATT"
                    $Link.TargetAttr
                ><% if not $HideText %>$Link.Title <i class="bi bi-arrow-right-short"></i><% end_if %></a>
            <% else %>
                <a 
                    href="$Link" 
                        class="text-nowrap<% if $StretchedLink || $HideText %> stretched-link<% end_if %>"
                    title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>"
                ><% if not $HideText %><%t Page.READ_MORE "Read More" %> <i class="bi bi-arrow-right-short"></i><% end_if %></a>
            <% end_if %>
        <% end_if %>
    </div>
</div>
