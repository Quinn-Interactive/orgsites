<!-- Button trigger modal -->
<button type="button"
    class="bg-transparent p-0 border-0 d-block position-relative w-100 play-icon-hover"
    data-bs-toggle="modal"
    data-video-modal data-bs-target="#video-$ID"
    style="text-transform: none;"
>
    <div class="w-100 ratio ratio-16x9 rounded" style="background-image: url('$VideoThumbURL(l)'); background-size: cover;">
        <% include QuinnInteractive/Orgsite/PlayIcon %>
    </div>
    <div class="h3 fs-5 text-black mt-2">$VideoTitle</div>
</button>

<!-- Modal -->
<div class="modal fade" id="video-$ID" tabindex="-1" aria-labelledby="video-$ID-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog modal-fullscreen-md-down">
        <div class="modal-content" style="background-color: #000;">
            <div class="modal-header border-0">
                <h1 class="modal-title text-white fs-5" id="video-$ID-label">$VideoTitle</h1>
                <button type="button" class="btn-close btn-close-white bg-transparent" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" data-video-iframe="$VideoIframe.ATT"></div>
        </div>
    </div>
</div>
