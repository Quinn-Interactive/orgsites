<footer 
    class="
        bg-$SiteConfig.NavbarBg 
        $SiteConfig.NavbarTextColor.CssClass 
        $SiteConfig.NavbarTextColor.NavbarBGClass
        <% if $SiteConfig.FooterBgPattern %>pattern-$SiteConfig.FooterBgPattern<% end_if %>
    "
    lang="$SiteConfig.SourceLocale.Locale"
>
    <div class="content-container py-3">
        <% if $SiteConfig.FooterLinks.Count %>
            <div class="d-inline-block float-lg-end ms-lg-3">
                <% loop $SiteConfig.FooterLinks %>
                    $Me.AddExtraClass('d-inline-block ms-lg-2')
                <% end_loop %>
            </div>
        <% end_if %>
        $SiteConfig.Footer
    </div>
</footer>