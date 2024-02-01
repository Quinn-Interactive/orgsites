<% require css('silverstripe/blog: client/dist/styles/main.css') %>
<% if $BlogPosts.Count < 2 %>
	<%-- we only have one post, so just show that --%>
	<div class="blog-entry content-container py-3">
		<h1>$Title</h1>
		<hr>
		<% with $BlogPosts.First %>
			<article>
				<h1>$Title</h1>
				<% include SilverStripe\\Blog\\EntryMeta %>
				<% if $FeaturedImage %>
					<p class="post-image">$FeaturedImage.ScaleWidth(795)</p>
				<% end_if %>
				<div class="content">$Content</div>
			</article>
		<% end_with %>
	</div>
<% else %>
	<div class="blog-entry content-container py-3">

		<article>
			<h1>
				<% if $ArchiveYear %>
					<%t SilverStripe\\Blog\\Model\\Blog.Archive 'Archive' %>:
					<% if $ArchiveDay %>
						$ArchiveDate.Nice
					<% else_if $ArchiveMonth %>
						$ArchiveDate.format('MMMM, y')
					<% else %>
						$ArchiveDate.format('y')
					<% end_if %>
				<% else_if $CurrentTag %>
					<%t SilverStripe\\Blog\\Model\\Blog.Tag 'Tag' %>: $CurrentTag.Title
				<% else_if $CurrentCategory %>
					<%t SilverStripe\\Blog\\Model\\Blog.Category 'Category' %>: $CurrentCategory.Title
				<% else %>
					$Title
				<% end_if %>
			</h1>

			<div class="content">$Content</div>

			<% include QuinnInteractive/Orgsite/BlogFilters %>

			<% if $PaginatedList.Exists %>
				<% if $ArticleLayout == 'Grid' %>
					<div class="row row-gap-4">
						<% loop $PaginatedList %>
							<div class="col-sm-6 col-lg-4 col-xl-3">
								<% include SilverStripe\\Blog\\PostSummaryCard %>
							</div>
						<% end_loop %>
					</div>
				<% else %>
					<div class="vstack pt-3">
						<% loop $PaginatedList %>
							<div class="border-top py-3"><% include SilverStripe\\Blog\\PostSummary %></div>
						<% end_loop %>
					</div>
				<% end_if %>

			<% else %>
				<p><%t SilverStripe\\Blog\\Model\\Blog.NoPosts 'There are no posts' %></p>
			<% end_if %>
		</article>

		$Form
		<%-- $CommentsForm --%>

		<% include QuinnInteractive/Orgsite/Pagination %>
	</div>
<% end_if %>

