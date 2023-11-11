<div class="post-summary row position-relative" lang="$SourceLocale.Locale">
	<div class="col-12 col-sm-7 col-md-8 col-lg-9 col-xl-10">
		<h2 class="mb-0">
			<a href="$Link" class="stretched-link link-dark link-underline link-underline-opacity-0 link-underline-opacity-100-hover" text-dark" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>">$Title</a>
		</h2>
		
		<% include SilverStripe\\Blog\\EntryMeta %>
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
			<img src="$FocusFill(300,300).URL"
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
