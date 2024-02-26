<div class="content-container py-3">
    <% if $ShowTitle && $Title %>
        <% if $Pos == 1 %><h1>$Title</h1><% else %><h2>$Title</h2><% end_if %>
    <% end_if %>
    <% if $HTML %>
        $HTML
    <% end_if %>
    <div class="row">
    <% loop $Bios.Sort('BioSort') %>
        <div class="col-sm-6 col-lg-4 col-xl-3 mb-4">
            <div class="card" lang="$SourceLocale.Locale">
                <% if $Image %>
                    <img src="$Image.FocusFillMax(400,300).URL?v=$Image.Version" width="400" height="300" class="card-img-top img-fluid" alt="Picture of $Up.Title.ATT">
                <% end_if %>
                <div class="card-body">
                    <h5 class="card-title">$Name</h5>
                    <% if $JobTitle %><div class="mt-n2 mb-2">$JobTitle</div><% end_if %>
                    <% if $Summary %><p class="card-text">$Summary</p><% end_if %>
                    <%-- <a href="$Top.Link?$ID" class="btn btn-primary stretched-link" title="Learn more about $Title.ATT">More</a> --%>
                    <% if $Content %>
                        <button type="button" class="btn btn-primary stretched-link" data-bs-toggle="modal" data-bs-target="#bio-$ID-$Slug" title="Learn more about $Title.ATT">
                            More
                        </button>
                    <% end_if %>
                </div>
            </div>
        </div>
        <% if $Content %>
            <div class="modal modal-xl fade" id="bio-$ID-$Slug" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" lang="$SourceLocale.Locale">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">$Name</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <% if $Image %>
                                <img src="$Image.FitMax(500,500).URL?v=$Image.Version" width="$Image.FitMax(500,500).Width" height="$Image.FitMax(500,500).Height" class="card-img-top img-fluid float-end w-md-50 w-xl-25 ms-md-3 mb-3" alt="Picture of $Up.Title.ATT">
                            <% end_if %>
                        
                            <h2>$Name</h2>
                            <% if $JobTitle %><div class="mt-n2 mb-2 fs-4">$JobTitle</div><% end_if %>
                            $Content
                        </div>
                    </div>
                </div>
            </div>
        <% end_if %>
        <% end_loop %>
    </div>

</div>
