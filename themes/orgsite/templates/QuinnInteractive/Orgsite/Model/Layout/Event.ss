<% cached $ClearKey('Calendar'), 'Event', $ID, $Locale %>
<div class="calendar content-container py-3">
    <% if $Parent %>
    <a class="d-block mb-2" href="$Parent.Link">
        <i class="bi bi-arrow-left-circle-fill me-1" aria-hidden></i> 
        Back to $Parent.MenuTitle
    </a>
    <% end_if %>
    <% if $FeaturedImage && $FeaturedImage.IsImage %>
        <% if $FeaturedImage.Ratio > 1 %>
            <%-- horizontal image --%>
            <p>
                <img src="$FeaturedImage.ScaleMaxWidth(1152).URL?v=$FeaturedImage.Version"
                    class="img-fluid w-100"
                    alt="$FeaturedImage.Title.ATT"
                    width="$FeaturedImage.ScaleMaxWidth(1152).Width"
                    height="$FeaturedImage.ScaleMaxWidth(1152).Height"
                    srcset="
                        <% with $FeaturedImage %>
                        <% if $WiderThanOrEqual(320) %>$ScaleWidth(320).URL?v=$Version 320w,<% end_if %>
                        <% if $WiderThanOrEqual(640) %>$ScaleWidth(640).URL?v=$Version 640w,<% end_if %>
                        <% if $WiderThanOrEqual(1024) %>$ScaleWidth(1024).URL?v=$Version 1024w,<% end_if %>
                        <% if $WiderThanOrEqual(1152) %>$ScaleWidth(1152).URL?v=$Version 1152w,<% end_if %>
                        <% if $WiderThanOrEqual(1920) %>$ScaleWidth(1920).URL?v=$Version 1920w,<% end_if %>
                        <% end_with %>
                    "
                    sizes="
                        (min-width: 1200px) 1152, 
                        calc(100vw - 60px)
                    "
                />
            </p>
        <% else %>
            <%-- vertical image --%>
            <p class="w-100 w-md-50 float-md-end ms-md-3 mb-3">
                <img src="$FeaturedImage.ScaleMaxWidth(1152).URL?v=$Version"
                    class="img-fluid w-100"
                    alt="$FeaturedImage.Title.ATT"
                    width="$FeaturedImage.ScaleMaxWidth(1152).Width"
                    height="$FeaturedImage.ScaleMaxWidth(1152).Height"
                    srcset="
                        <% with $FeaturedImage %>
                        <% if $WiderThanOrEqual(320) %>$ScaleWidth(320).URL?v=$Version 320w,<% end_if %>
                        <% if $WiderThanOrEqual(640) %>$ScaleWidth(640).URL?v=$Version 640w,<% end_if %>
                        <% if $WiderThanOrEqual(1024) %>$ScaleWidth(1024).URL?v=$Version 1024w,<% end_if %>
                        <% if $WiderThanOrEqual(1152) %>$ScaleWidth(1152).URL?v=$Version 1152w,<% end_if %>
                        <% if $WiderThanOrEqual(1920) %>$ScaleWidth(1920).URL?v=$Version 1920w,<% end_if %>
                        <% end_with %>
                    "
                    sizes="
                        (min-width: 1200px) 1152, 
                        calc(100vw - 60px)
                    "
                />
            </p>
        <% end_if %>
    <% end_if %>
    <h1>$Title</h1>
    <% include QuinnInteractive/Orgsite/EventDates %>
    <div class="content">$Content</div>
</div>
<% end_cached %>