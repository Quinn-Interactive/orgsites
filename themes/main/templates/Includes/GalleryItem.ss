<a href="$Link" data-lightbox="type: $ItemType" <% if $ItemType == 'video' %>class="play-icon position-relative d-block"<% end_if %>>
    <% if $Image %>
        <img src="$Image.FitMax(400,400).URL" width="$Image.FitMax(400,400).Width" height="$Image.FitMax(400,400).Height" class="img-fluid" alt="Picture of $Image.Title.ATT">
    <% else_if $ItemType == 'video' %>
        $VideoThumbIMG(l).RAW
    <% end_if %>
</a>