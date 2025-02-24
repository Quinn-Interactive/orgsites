<% cached ElementSlideshow, $ID, $LastEdited, $Slides.Count, $Slides.Max('LastEdited'), $Slides.Max('LastEdited'), $Slides.Count, $Locale %>
<div class="content-container pt-3">
    <% if $ShowTitle && $Title %>
        <% if $Pos == 1 %><h1>$Title</h1><% else %><h2>$Title</h2><% end_if %>
    <% end_if %>
    <% if $HTML %>
        $HTML
    <% end_if %>
</div>
<div class="<% if not $FullWidth %>content-container<% end_if %> pb-3">
    <% if $Slides.Count %>
    <div id="carousel-$ID" class="carousel slide carousel-fade" <% if $Autoplay %>data-bs-ride="carousel"<% end_if %>>
        <div class="carousel-indicators">
            <% loop $Slides %>
                <button type="button" data-bs-target="#carousel-$Up.ID" data-bs-slide-to="$Pos(0)" <% if $Pos == 1 %> class="active -unstyled" aria-current="true"<% end_if %> class="-unstyled" aria-label="Slide $Pos"></button>
            <% end_loop %>
        </div>
        <div class="carousel-inner">
            <% loop $Slides %>
                <div 
                    style="--bs-aspect-ratio: $Top.RatioPercentage;"
                    class="
                        carousel-item 
                        ratio 
                        -text-$TextPosition 
                        <% if $Pos == 1 %>active<% end_if %> 
                        <% if $ShowTitle || $HTML %>-text-$TextColor<% end_if %>
                    ">
                    <% if $Image %>
                        <img class="d-block w-100 h-auto"
                            <% if $Up.Sort > 1 %>loading="lazy"<% end_if %>
                            alt=""
                            src="$FocusRatioFill(1024).URL?v=$Image.Version"
                            width="$FocusRatioFill(1024).Width"
                            height="$FocusRatioFill(1024).Height"
                            srcset="
                            <% if $Image.WiderThanOrEqual(320) %>$FocusRatioFill(320).URL?v=$Version 320w,<% end_if %>
                            <% if $Image.WiderThanOrEqual(640) %>$FocusRatioFill(640).URL?v=$Version 640w,<% end_if %>
                            <% if $Image.WiderThanOrEqual(1024) %>$FocusRatioFill(1024).URL?v=$Version 1024w,<% end_if %>
                            <% if $Image.WiderThanOrEqual(1920) %>$FocusRatioFill(1920).URL?v=$Version 1920w,<% end_if %>
                            <% if $Image.WiderThanOrEqual(2880) %>$FocusRatioFill(2880).URL?v=$Version 2880w,<% end_if %>
                            <% if $Image.WiderThanOrEqual(3840) %>$FocusRatioFill(3840).URL?v=$Version 3840w,<% end_if %>
                            "
                            <% if $Up.FullWidth %>
                                sizes="100vw"
                            <% else %>
                                sizes="(min-width: 1200px) 1200px, 100vw"
                            <% end_if %>
                        />
                    <% end_if %>
                    <% if $ShowTitle || $Caption || $Link %>
                        <div class="carousel-caption content-container $ContentClasses">
                            <% if $ShowTitle && $Title %>
                                <% if $Pos == 1 %><h1>$Title</h1><% else %><h2>$Title</h2><% end_if %>
                            <% end_if %>
                            <% if $Caption %>
                                $Caption
                            <% end_if %>
                            <% if $Link %>
                                <a href="$Link.LinkURL" class="
                                    <% if $HideButton %>
                                        stretched-link
                                    <% else %>
                                        btn btn-primary
                                    <% end_if %>
                                "
                                $Link.TargetAttr
                                <% if $HideButton %>title="$Link.Title.ATT"<% end_if %>
                                ><% if not $HideButton %>$Link.Title<% end_if %></a>
                            <% end_if %>
                        </div>
                    <% end_if %>
                </div>

            <% end_loop %>
        </div>
        <% if $ShowArrows %>
            <button class="carousel-control-prev -unstyled" type="button" data-bs-target="#carousel-$ID" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next -unstyled" type="button" data-bs-target="#carousel-$ID" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        <% end_if %>
    </div>
    <% end_if %>
</div>
<% end_cached %>