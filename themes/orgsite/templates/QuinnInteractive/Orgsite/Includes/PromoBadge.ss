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
            <% if not $HideSummaries %>$DescriptionOrSummary.RAW<% end_if %>
        </p>
        <% end_if %>
        <% if $Link %>
            <% if $Link.LinkURL %>
                <a 
                    href="$Link.LinkURL" 
                    class="
                        <% if not $HideButtonText %>text-nowrap<% end_if %>
                        <% if $StretchedLink %> stretched-link<% end_if %>
                    "
                    title="$Title.ATT"
                    $Link.TargetAttr
                ><% if not $HideButtonText %>$Link.Title <i class="bi bi-arrow-right-short"></i><% end_if %></a>
            <% else %>
                <a 
                    href="$Link" 
                    class="
                        <% if not $HideButtonText %>text-nowrap<% end_if %>
                        <% if $StretchedLink %> stretched-link<% end_if %>
                    "
                    title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>"
                ><% if not $HideButtonText %><%t Page.READ_MORE "Read More" %> <i class="bi bi-arrow-right-short"></i><% end_if %></a>
            <% end_if %>
        <% end_if %>
    </div>
</div>
