<div class="row mb-3" lang="$SourceLocale.Locale">
    <% if not $HideImages %>
        <div class="col-12 col-sm-5 col-md-4 col-lg-3">
            <% if $CardImage %>
                <% with $CardImage %><% include QuinnInteractive/Orgsite/PromoCardImage %><% end_with %>
            <% else_if $FeaturedImage %>
                <% with $FeaturedImage %><% include QuinnInteractive/Orgsite/PromoCardImage %><% end_with %>
            <% else_if $Image %>
                <% with $Image %><% include QuinnInteractive/Orgsite/PromoCardImage %><% end_with %>
            <% end_if %>
        </div>
    <% end_if %>
    <div class="<% if not $HideImages %>col-12 col-sm-7 col-md-8 col-lg-9<% else %>col-12<% end_if %>">
        <h5>$Title</h5>
        <% if $Date || $DisplayDate %>
            <p class="mt-n1 mb-0"><% if $DisplayDate %>$DisplayDate<% else %>$Date.Date<% end_if %></p>
        <% end_if %>
        <p>
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
