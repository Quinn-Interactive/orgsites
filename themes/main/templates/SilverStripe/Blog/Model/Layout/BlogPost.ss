<% require css('silverstripe/blog: client/dist/styles/main.css') %>
<div class="blog-entry content-container">
	<% include Breadcrumbs %>
	<article>
		<h1>$Title</h1>
		<% include SilverStripe\\Blog\\EntryMeta %>
		<% if $FeaturedImage %>
			<p class="post-image">$FeaturedImage.ScaleWidth(795)</p>
		<% end_if %>
		<div class="content">$Content</div>
	</article>
	$Form
	<%-- $CommentsForm --%>
</div>

<% include SilverStripe\\Blog\\BlogSideBar %>
