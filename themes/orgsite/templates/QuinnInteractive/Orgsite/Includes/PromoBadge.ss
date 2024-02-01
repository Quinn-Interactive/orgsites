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
        <h5>$Title</h5>
        <p>
            <% if $Start || $Date || $DisplayDate %>
                <% include QuinnInteractive/Orgsite/EventDates %>
            <% end_if %>
            $DescriptionOrSummary
            <% if $Link %>
                <% if $Link.LinkURL %>
                    <a 
                        href="$Link.LinkURL" 
                        class="stretched-link text-nowrap"
                        title="$Title.ATT"
                    >$Title <i class="bi bi-arrow-right-short"></i></a>
                <% else %>
                    <a 
                        href="$Link" 
                            class="stretched-link text-nowrap"
                        title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>"
                    ><%t Page.READ_MORE "Read More" %> <i class="bi bi-arrow-right-short"></i></a>
                <% end_if %>
            <% end_if %>
        </p>
    </div>
</div>
