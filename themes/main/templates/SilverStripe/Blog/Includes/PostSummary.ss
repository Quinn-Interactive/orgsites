<div class="post-summary d-flex" lang="$SourceLocale.Locale">
	<% if $FeaturedImage %>
	<a href="$Link" class="d-none d-sm-block flex-0 order-2 ms-3 " title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>">
		<% with $FeaturedImage %>
		<img src="$FocusFill(200,200).URL"
			<%-- class="h-auto w-100" --%>
			alt="$Title.ATT"
			loading="lazy"
			width="150"
			height="150"
		>
		<% end_with %>
	</a>
	<% end_if %>
	<div class="flex-1">
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
