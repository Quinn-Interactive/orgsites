<div class="post-summary row">
	<% if $FeaturedImage %>
	<p class="col-3 order-2">
		<a href="$Link" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>">
			<% with $FeaturedImage %>
			<img src="$ScaleWidth(500).URL"
				class="h-auto w-100"
				alt="$Title.ATT"
				loading="lazy"
				width="$ScaleWidth(500).Width"
				height="$ScaleWidth(500).Height"
				srcset="
				<% if $WiderThanOrEqual(320) %>$ScaleWidth(320).URL 320w,<% end_if %>
				<% if $WiderThanOrEqual(500) %>$ScaleWidth(500).URL 500w,<% end_if %>
				<% if $WiderThanOrEqual(768) %>$ScaleWidth(768).URL 768w,<% end_if %>
				<% if $WiderThanOrEqual(1024) %>$ScaleWidth(1024).URL 1024w,<% end_if %>
				"
				sizes="(min-width: 1400px) 389px, (min-width: 992px) calc(33vw - 152px), (min-width: 768px) calc(50vw - 72px), calc(100vw - 24px)"
			>
			<% end_with %>
		</a>
	</p>
	<% end_if %>
	<div class="col-9">
		<h2>
			<a href="$Link" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>">
				<% if $MenuTitle %>$MenuTitle
				<% else %>$Title<% end_if %>
			</a>
		</h2>
		<% include SilverStripe\\Blog\\EntryMeta %>

		<% if $Summary %>
			$Summary <% include ReadMore %>
		<% else %>
			<p>$Excerpt <% include ReadMore %></p>
		<% end_if %>
	</div>
</div>
