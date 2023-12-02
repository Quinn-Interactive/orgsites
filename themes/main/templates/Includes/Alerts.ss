<% if $Alerts.Count %>
    <div data-alert-list>
        <% loop $Alerts.Filter('AlertStyle', 'alert').Sort('AlertSort') %>
            <div data-alert='$AlertJSON' hidden>
                <div class="alert alert-$AlertColor fade show m-0 rounded-0 border-0 px-0 py-2" role="alert">
                    <div class="content-container mb-0 d-flex justify-content-between align-items-center">
                        <div class="fs-5 fw-bold">
                            $Title
                            <% if $Link %>
                                <a href="$Link.LinkURL" $TargetAttr class="fw-normal fs-6 d-inline-block ms-2 text-uppercase link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">$Link.Title <i class="bi bi-arrow-right-short"></i></a>
                            <% end_if %>
                        </div>
                        <button type="button" class="btn-close py-3" data-alert-close aria-label="Close"></button>
                    </div>
                </div>
            </div>
        <% end_loop %>
    </div>
<% end_if %>