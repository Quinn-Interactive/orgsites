<a  href="$Link" 
    lang="$SourceLocale.Locale"
    data-lightbox="type: $ItemType"
    <% if $ShowTitle && $Title %>data-title="$Title.ATT"<% end_if %>
    <% if $Caption %>data-description="$Caption.ATT"<% end_if %>
    data-alt="$Title.ATT"
    <% if $ItemType == 'video' %>class="play-icon position-relative d-block"<% end_if %>
>
    <% if $Image %>
        <img src="$Image.FitMax(400,400).URL?v=$Image.Version" width="$Image.FitMax(400,400).Width" height="$Image.FitMax(400,400).Height" class="img-fluid" alt="$Title.ATT">
    <% else_if $ItemType == 'video' %>
        $VideoThumbIMG(l).RAW
    <% end_if %>
</a>
<% if $ShowTitle && $Title %><div>$Title</div><% end_if %>