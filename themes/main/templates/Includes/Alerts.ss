<% if $ActiveAlerts.Count %>
    <div data-alert-list>
        <% if $AlertsByType('alert').Count %>
            <% loop $AlertsByType('alert') %>
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
        <% end_if %>
        <% if $AlertsByType('toast').Count %>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <% loop $AlertsByType('toast') %>
                <div data-alert='$AlertJSON' hidden class="toast show bg-$AlertColor-subtle border-$AlertColor" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-$AlertColor-subtle text-black border-$AlertColor">
                        <strong class="me-auto">$Title</strong>
                        <button type="button" class="btn-close" data-alert-close aria-label="Close"></button>
                    </div>
                    <% if $Content || $CTA %>
                        <div class="toast-body">
                            $Content
                            <% if $CTA %>
                                <p>$CTA</p>
                            <% end_if %>
                        </div>
                    <% end_if %>
                </div>
            <% end_loop %>
        </div>
        <% end_if %>
        <% if $AlertsByType('modal').Count %>
            <% with $AlertsByType('modal').First %>
                <div data-alert='$AlertJSON' hidden>
                    <div class="modal d-block" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <% if $Severity == 'critical' %>
                                            <i class="bi bi-exclamation-diamond-fill text-danger me-1"></i>
                                        <% else_if $Severity == 'warning' %>
                                            <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i>
                                        <% else_if $Severity == 'success' %>
                                            <i class="bi bi-check-circle-fill text-success me-1"></i>
                                        <% else_if $Severity == 'notice' %>
                                            <i class="bi bi-info-circle-fill text-info me-1"></i>
                                        <% end_if %>
                                        $Title
                                    </h5>
                                    <button type="button" class="btn-close" data-alert-close aria-label="Close"></button>
                                </div>
                                <% if $Content %>
                                    <div class="modal-body">
                                        $Content
                                    </div>
                                <% end_if %>
                                <% if $CTA %>
                                    <div class="modal-footer">
                                        <a href="$Link.LinkURL" $TargetAttr class="btn btn-$AlertColor">$Link.Title</a>
                                    </div>
                                <% end_if %>
                            </div>
                        </div>
                        <button class="modal-backdrop show border-0 z-n1" data-alert-close></button>
                    </div>
                </div>
            <% end_with %>
        <% end_if %>
        
    </div>
<% end_if %>