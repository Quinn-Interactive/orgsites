<div class="blog-post-meta text-secondary">
    $PublishDate.Date

    <% if $Credits %>
        <%t SilverStripe\\Blog\\Model\\Blog.By "by" %>

        <% loop $Credits %>
            <% if not $IsFirst && not $IsLast %>, <% end_if %>
            <% if not $IsFirst && $IsLast %> <%t SilverStripe\\Blog\\Model\\Blog.AND "and" %> <% end_if %>
            $Name.XML
        <% end_loop %>
    <% end_if %>

        
    <% if $Tags.exists || $Categories.exists %>
        <span class="ps-3">
        <% loop $Categories %>
            <span class="badge rounded-pill text-bg-secondary" title="$Title">$Title</span>
        <% end_loop %>
        <% loop $Tags %>
            <span class="badge rounded-pill text-bg-secondary opacity-75" title="$Title">$Title</span>
        <% end_loop %>
        </span>
    <% end_if %>

    <% if $Comments.exists %>
        <span class="ps-3">
            <%t SilverStripe\\Blog\\Model\\Blog.Comments "Comments" %>
            $Comments.count
        </span>
    <% end_if %>
</div>
