<div class="card position-relative h-100" lang="$SourceLocale.Locale">
    <% if not $HideImages %>
        <% if $CardImage %>
            <% with $CardImage %><% include QuinnInteractive/Orgsite/PromoCardImage %><% end_with %>
        <% else_if $FeaturedImage %>
            <% with $FeaturedImage %><% include QuinnInteractive/Orgsite/PromoCardImage %><% end_with %>
        <% else_if $Image %>
            <% with $Image %><% include QuinnInteractive/Orgsite/PromoCardImage %><% end_with %>
        <% end_if %>
    <% end_if %>
    <div class="card-body">
        <h5 class="card-title">$Title</h5>
        <p class="card-text">
            <% if $Start || $Date || $DisplayDate %>
                <% include QuinnInteractive/Orgsite/EventDates %>
            <% end_if %>
            $DescriptionOrSummary
        </p>
    </div>
    <% if $Link %>
        <div class="card-footer text-center border-top-0 bg-white">
            <% if $Link.LinkURL %>
                <a 
                    href="$Link.LinkURL" 
                    class="btn btn-small btn-primary stretched-link"
                    title="$Title.ATT"
                >$Title</a>
            <% else %>
                <a 
                    href="$Link" 
                    class="btn btn-small btn-primary stretched-link"
                    title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>"
                ><%t Page.READ_MORE "Read More" %></a>
            <% end_if %>
        </div>
    <% end_if %>
</div>
