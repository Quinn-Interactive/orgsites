<% if $ShowElement %>
<div class="
		element 
		$CSSClassName
		<% if $StyleVariant %>$StyleVariant<% end_if %>
		<% if $ExtraClass %> $ExtraClass<% end_if %>
		<% if $Background %>$Background.BgClass $Background.CssClass<% end_if %>
		<% if $BackgroundPattern %>pattern-$BackgroundPattern<% end_if %>
	" 
	lang="$SourceLocale.Locale"
	id="$Anchor">
	$Element
</div>
<% end_if %>