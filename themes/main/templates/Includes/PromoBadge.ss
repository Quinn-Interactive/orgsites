<div class="position-relative mb-3" lang="$SourceLocale.Locale">
    <% if not $HideImages %>
        <% if $CardImage %>
            <% with $CardImage %><% include PromoBadgeImage %><% end_with %>
        <% else_if $FeaturedImage %>
            <% with $FeaturedImage %><% include PromoBadgeImage %><% end_with %>
        <% else_if $Image %>
            <% with $Image %><% include PromoBadgeImage %><% end_with %>
        <% end_if %>
    <% end_if %>
    <div>
        <h5>$Title</h5>
        <p>
            <% if $Date || $DisplayDate %>
                <div class="mt-n3 mb-0"><% if $DisplayDate %>$DisplayDate<% else %>$Date.Date<% end_if %></div>
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
