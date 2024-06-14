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
    <% if not $Parent.HideText %>
    <div class="card-body">
        <h5 class="card-title">$Title</h5>
        <p class="card-text">
            <% if $Start || $Date || $DisplayDate %>
                <% include QuinnInteractive/Orgsite/EventDates %>
            <% end_if %>
            <% if not $HideSummaries %>$DescriptionOrSummary.RAW<% end_if %>
        </p>
    </div>
    <% end_if %>
    <% if $Link %>
        <div class="card-footer text-center border-top-0 bg-white">
            <% if $Link.LinkURL %>
                <a 
                    href="$Link.LinkURL" 
                    class="
                        <% if not $ButtonStyle == 'whole card' && not $Parent.HideText %>btn btn-small btn-primary<% end_if %>
                        <% if $ButtonStyle != 'button' %> stretched-link<% end_if %>
                    "
                    $Link.TargetAttr
                    title="$Title.ATT"
                ><% if not $ButtonStyle == 'whole card' && not $Parent.HideText %>$Link.Title<% end_if %></a>
            <% else %>
                <a 
                    href="$Link" 
                    class="
                        <% if not $ButtonStyle == 'whole card' && not $Parent.HideText %>btn btn-small btn-primary<% end_if %>
                        <% if $ButtonStyle != 'button' %> stretched-link<% end_if %>
                    "
                    title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>"
                ><% if not $ButtonStyle == 'whole card' && not $Parent.HideText %><%t Page.READ_MORE "Read More" %><% end_if %></a>
            <% end_if %>
        </div>
    <% end_if %>
</div>
