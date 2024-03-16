<% cached $ClearKey('Calendar'), $PaginatedList.PageStart, $ID, $Locale %>
<div class="calendar content-container py-3">
    <% if $ICalendar %>
        <a class="float-end btn btn-outline-primary" 
           href="{$Link}/ical/{$URLSegment}.ics" 
           title="<%t QuinnInteractive\Orgsite\Page\Calendar.ADD_TO_CALENDAR 'Add to Calendar' %>" 
           ><i class="bi-calendar-plus me-1"></i> <%t QuinnInteractive\\Orgsite\\Page\\Calendar.SUBSCRIBE 'Subscribe' %></a>
    <% end_if %>
    <h1>
        $Title
    </h1>

    <div class="content">$Content</div>
    <% if $UpcomingEvents && $PastEvents %>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a 
                class="nav-link <% if not $ShowPast %>active<% end_if %>" 
                <% if not $ShowPast %>aria-current="page"<% end_if %>
                href="$Link"
            >Upcoming Events</a>
        </li>
        <li class="nav-item">
            <a 
                class="nav-link <% if $ShowPast %>active<% end_if %>" 
                <% if $ShowPast %>aria-current="page"<% end_if %> 
                href="$Link?past=1"
            >Past Events</a>
        </li>
    </ul>   
    <% end_if %>


    <% if $PaginatedList.Exists %>
        <div class="vstack pt-3">
            <% loop $PaginatedList %>
                <div class="border-bottom py-3">
                    <div class="row position-relative" lang="$SourceLocale.Locale">
                        <div class="col-12 col-sm-7 col-md-8 col-lg-9 col-xl-10">
                            <h2 class="mb-2">
                                <% if $Link %>
                                    <a href="$Link" class="link-dark link-underline link-underline-opacity-0 link-underline-opacity-100-hover" text-dark" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>">
                                        $Title <i class="ms-1 bi bi-arrow-right-circle fs-4"></i>
                                    </a>
                                <% else %>
                                    $Title
                                <% end_if %>
                            </h2>
                            <% include QuinnInteractive/Orgsite/EventDates %>
                            <div class="mb-n3">
                                <% if $Summary %>
                                    $Summary
                                <% else %>
                                    <p>$Excerpt</p>
                                <% end_if %>
                            </div>
                        </div>
                        <div class="d-none d-sm-block col-12 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                            <% if $FeaturedImage %>
                                <% with $FeaturedImage %>
                                <img src="$FocusFill(300,300).URL?v=$Version"
                                    class="h-auto w-100"
                                    alt="$Title.ATT"
                                    loading="lazy"
                                    width="300"
                                    height="300"
                                    alt="$Title.ATT"
                                >
                                <% end_with %>
                            <% end_if %>
                        </div>
                    </div>
                
                </div>
            <% end_loop %>
        </div>
        <% include QuinnInteractive/Orgsite/Pagination %>
    <% else %>
        <p><%t SilverStripe\\Blog\\Model\\Blog.NoPosts 'There are no posts' %></p>
    <% end_if %>

</div>
<% end_cached %>