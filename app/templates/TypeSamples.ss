<div>
<style>
    $SiteConfig.FontHeadCode(import).RAW
    .type-sample-headline {
        font-family: $SiteConfig.FontData('Headline').family.RAW;
        font-size: 24px;
    }
    .type-sample-body {
        font-family: $SiteConfig.FontData('Body').family.RAW;
        font-size: 16px;
    }
    .type-sample-monospace {
        font-family: $SiteConfig.FontData('Monospace').family.RAW;
        font-size: 16px;
    }
</style>

<h1 class="type-sample-headline">Headline Sample: $SiteConfig.FontData('Headline').title</h1>
<p class="type-sample-body">Body Sample: $SiteConfig.FontData('Body').title: Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Nulla vitae elit libero, a pharetra augue.</p>
<pre class="type-sample-monospace">Monospace Sample: $SiteConfig.FontData('Monospace').title</pre>
</div>