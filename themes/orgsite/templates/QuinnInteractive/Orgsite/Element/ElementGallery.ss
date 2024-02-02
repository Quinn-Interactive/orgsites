<% cached ElementVideoCarousel, $ID, $LastEdited, $Videos.Count, $Videos.Max('LastEdited'), $GalleryItems.Max('LastEdited'), $GalleryItems.Count, $Locale %>
<div class="content-container py-3">
    <% if $ShowTitle && $Title %>
        <% if $Pos == 1 %><h1>$Title</h1><% else %><h2>$Title</h2><% end_if %>
    <% end_if %>
    <% if $HTML %>
        $HTML
    <% end_if %>
    <% if $GalleryItems %>
        <% if $Slider %>
        <div class="slider" data-slider>
            <div class="row g-4 align-items-stretch slider__slides -has-modals" data-slider-slides>
            <% loop $GalleryItems %>
                <div class="col-12 col-md-6 col-lg-4 mb-4 text-center slider__slide">
                    <% include QuinnInteractive/Orgsite/GalleryItem %>
                </div>
            <% end_loop %>
            </div>
        </div>
        <% else %>
            <div class="row g-4 align-items-stretch">
                <% loop $GalleryItems %>
                    <div class="col-12 col-md-6 col-lg-4 mb-4 text-center">
                        <% include QuinnInteractive/Orgsite/GalleryItem %>
                    </div>
                <% end_loop %>
            </div>
        <% end_if %>
    <% end_if %>
</div>
<% end_cached %>