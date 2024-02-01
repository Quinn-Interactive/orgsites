<div class="banner -text-$TextPosition <% if $ShowTitle || $HTML %>-text-$TextColor<% end_if %>">
    <% if $Image %>
        <% with $Image %>
            <img class="focused-image banner__image"
                src="$ScaleWidth(1024).URL?v=$Version"
                width="$ScaleWidth(1024).Width"
                height="$ScaleWidth(1024).Height"
                alt=""
                <% if $Up.Sort > 1 %>loading="lazy"<% end_if %>
                srcset="
                <% if $WiderThanOrEqual(320) %>$ScaleWidth(320).URL?v=$Version 320w,<% end_if %>
                <% if $WiderThanOrEqual(640) %>$ScaleWidth(640).URL?v=$Version 640w,<% end_if %>
                <% if $WiderThanOrEqual(1024) %>$ScaleWidth(1024).URL?v=$Version 1024w,<% end_if %>
                <% if $WiderThanOrEqual(1920) %>$ScaleWidth(1920).URL?v=$Version 1920w,<% end_if %>
                <% if $WiderThanOrEqual(2880) %>$ScaleWidth(2880).URL?v=$Version 2880w,<% end_if %>
                <% if $WiderThanOrEqual(3840) %>$ScaleWidth(3840).URL?v=$Version 3840w,<% end_if %>
                "
                sizes="100vw"
                data-focus-x="$FocusPoint.X"
                data-focus-y="$FocusPoint.Y"
            />
        <% end_with %>
    <% end_if %>
    <% if $ShowTitle || $HTML %>
        <div class="content-container banner__content -text-$TextPosition">
            <div class="banner__text">
                <% if $ShowTitle && $Title %>
                    <% if $Pos == 1 %><h1>$Title</h1><% else %><h2>$Title</h2><% end_if %>
                <% end_if %>
                <% if $HTML %>
                    $HTML
                <% end_if %>
            </div>
        </div>
    <% end_if %>
</div>
