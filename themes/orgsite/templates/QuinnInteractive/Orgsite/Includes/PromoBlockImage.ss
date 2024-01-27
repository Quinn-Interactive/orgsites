<img class="banner__img"
    src="$ScaleWidth(1024).URL"
    width="$ScaleWidth(1024).Width"
    height="$ScaleWidth(1024).Height"
    alt="$Title.ATT"
    loading="lazy"
    srcset="
        <% if $WiderThanOrEqual(320) %>$ScaleWidth(320).URL 320w,<% end_if %>
        <% if $WiderThanOrEqual(640) %>$ScaleWidth(640).URL 640w,<% end_if %>
        <% if $WiderThanOrEqual(1024) %>$ScaleWidth(1024).URL 1024w,<% end_if %>
    "
    sizes="(min-width: 992px) 50vw, (min-width: 1200) 992px, 100vw"
/>
