<%-- Loop is all on one line to prevent whitespace bug in older versions of IE --%>
<% if $Pages %>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="/$CurrentLocaleObject.URLSegment" title="$SiteConfig.Title.ATT">
			<%t SilverStripe\\CMS\\Model\\SiteTree.DEFAULTHOMETITLE 'Home' %>
		</a>
	</li>
	<% loop $Pages %>
		<% if $IsLast %>
			<li class="breadcrumb-item active" aria-current="page">$MenuTitle.XML</li>
		<% else %>
			<% if not Up.Unlinked %>
				<li class="breadcrumb-item"><a href="$Link">$MenuTitle.XML</a></li>
			<% else %>
				<li class="breadcrumb-item">$MenuTitle.XML</li>
			<% end_if %>
		<% end_if %>
	<% end_loop %>
  </ol>
</nav>
<% end_if %>
