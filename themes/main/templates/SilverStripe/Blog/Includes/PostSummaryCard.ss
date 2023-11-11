<div class="post-summary card h-100" lang="$SourceLocale.Locale">
	<% if $FeaturedImage %>
	<a href="$Link" class="card-img-top" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>">
		<% with $FeaturedImage %>
		<img src="$ScaleWidth(320).URL"
			class="h-auto w-100"
			alt="$Title.ATT"
			loading="lazy"
			width="320"
			height="$ScaleWidth(320).Height"
		>
		<% end_with %>
	</a>
	<% end_if %>
	<div class="card-body">
		<h2 class="card-title">
			<a href="$Link" class="stretched-link link-underline link-underline-opacity-0 text-dark" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>">
				<% if $MenuTitle %>$MenuTitle
				<% else %>$Title<% end_if %>
			</a>
		</h2>
        <div class="card-text">
		<div>$PublishDate.Date</div>
		<% if $Summary %>
			$Summary
		<% else %>
			<p>$Excerpt</p>
		<% end_if %>
        <% if $Tags.exists || $Categories.exists %>
            <% loop $Categories %>
                <span class="badge rounded-pill text-bg-secondary" href="$Link" title="$Title">$Title</span>
            <% end_loop %>
            <% loop $Tags %>
                <span class="badge rounded-pill text-bg-secondary opacity-75" href="$Link" title="$Title">$Title</span>
            <% end_loop %>
        <% end_if %>

        <% if $Comments.exists %>
            <a href="{$Link}#comments-holder">
                <%t SilverStripe\\Blog\\Model\\Blog.Comments "Comments" %>
                $Comments.count
            </a>;
        <% end_if %>
        
        </div>
	</div>
</div>
