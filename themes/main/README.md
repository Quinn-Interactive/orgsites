<!-- cSpell:words mixins, navbars, reorderable -->

Theme Readme
============

## Folder Structure ##

Do your development in `src`. JS, and SCSS will get moved to `dist` by the build system. Images and Fonts live in their own folders and these, along with the dist directory get symlinked into `/public/_resources/themes/main/` when composer does a `composer update`, `composer install`, or `composer vendor-expose`.

- src/ - Where the pre-compiled scss, js, images, and fonts live
- src/scss - Your sass files
- src/js - Your js files
- src/images - Image files
- src/fonts - Font files
- public/ - Where your compiled scss, js, images, and fonts end up

## SCSS ##

The `scss` for the theme lives in `src/`. There are some rollup scss files for the various folders (except for modules and pages) as well as two main entrypoint files: `styles.scss` and `editor.scss`. `editor.scss` is for the default rich text editor in the SilverStripe CMS and allows us to have the editor share basic styles with the front end of the site.

1. **functions/**: Sass @functions. no dependencies.

2. **settings/**: Site-wide, sass variable settings. may use functions. may not use mixins. Suffix these with `-settings` to help with searching for things, like `_layout-settings.scss`.

3. **mixins/**: Sass @mixins

4. **foundation/**: <html> & <body> styles for things like css reset, base type settings, box-sizing, etc. This is also where base typographic tags are styled like p, headings, lists, etc.

5. **blocks/**: These are styles for various components of the site. Because these often correspond to SilverStripe objects, they get StudlyCapped. Examples:

   - _Bio.scss
   - _Card.scss
   - _Logo.scss
   - _SearchForm.scss
   - _SocialIcon.scss
   - _Tab.scss
   - _Tag.scss

6.  **modules/**: These are styles that we decide to bring in as separate css files as needed. They would get included with a require statement in a template. Like `<% require themedCSS('dist/css/modules/MyModule') %>`.

7.  **pages/**: Styles applied to a specific page type, usually through the body like: `<body class="Page UserDefinedForm">`. These would get added in the template through a require statement in the page's Layout template and would not be included in the main styles.css. Like `<% require themedCSS('dist/css/pages/MyPage') %>`.

8.  **third-party/**: These are libraries or other classes that did not originate from us.

### BEMISH S/CSS ###

SilverStripe has a specific internal naming convention for DataObjects, fields, and template variables. Typically they are StudlyCapped. Becasue of this we will name css classes that likley correspond to SilverStripe vars/objects with StudlyCaps. These are classes in `blocks/`, `modules/`, and `pages/`.

We will use the BEM (block element modifier) convention, but with a twist that helps when working with SilverStripe as well as making things more readable.

We are using a modified version of the ABEM methodology, which is a modified version of BEM.

<https://css-tricks.com/abem-useful-adaptation-bem/>

The differences in our version are that we will use StudlyCaps (since SilverStripe objects classnames are that way) for block names, and we will **not** use atomic design prefixes.

The quick description is:

`BlockName__elementName -modifierName`

Note that the modifier is now it's own class. We avoid collisions by only applying it to other classes, or using de-specificity tricks. More info available in the docs above.

Here is some sample HTML:

```html
<div class="SomeBlock -red">
    <h2 class="SomeBlock__title -small">Title</h2>
</div>
```

Here is some sample SCSS:

```scss
// main block
.SomeBlock {
    padding: 1em;

    // .SomeBlock "red" modifier
    &.-red {
        color: #f00;
    }

    // .SomeBlock "title" element
    &__title {
        font-size: 2em;

        // .SomeBlock__title small modifier
        &.-small {
            font-size: 1em;
        }
    }
}
```

Which compiles to this CSS:

```css
.SomeBlock {
  padding: 1em;
}
.SomeBlock.-red {
  color: #fc0;
}
.SomeBlock__title {
  font-size: 2em;
}
.SomeBlock__title.-small {
  font-size: 1em;
}
```

## Javascript ##

All the theme's js lives in `src/js`. The main entrypoint is `src/js/index.js`. That file brings in any sitewide js includes, as well as uses dynamic imports to allow for code splitting of js files we only need sometimes. Here's an example of some sitewide includes at the top, and some as-needed includes below in an example `index.js` file:

```js
// every page imports
import 'babel-polyfill';
import 'nodelist-foreach-polyfill';
import './nav';

// svg-inject-helper
if (document.querySelector('[data-svg-inject]')) {
    import(/* webpackChunkName: "svg-inject-helper" */ './svg-inject-helper');
}
// lazyload
if (document.querySelector('.lazyload')) {
    import(/* webpackChunkName: "lazysizes" */ 'lazysizes');
}
```

The dynamic imports get built into a `chunks` directory in `dist/js` by laravel-mix.

## Build Tooling ##

The build tooing is managed by laravel-mix. <https://laravel-mix.com>

### Build system setup ###

In this directory, run: `yarn` on the command line to download all the needed node modules.

### Build system commands ###

- `yarn dev` - compiles a dev version (not compressed) of your front end files
- `yarn development` - same as `yarn dev`.
- `yarn production` - compiles production (compressed) version of front end files
- `yarn prod` - same as `yarn production`.
- `yarn watch` - compiles dev version and then watches and recompiles when files change.
- `yarn watch-lint` - does `yarn watch` but also lints as it goes.
- `yarn lint-js` - uses eslint to try lint the js.
- `yarn lint-css` - uses stylelint to try lint the css.
- `yarn fix-js` - uses eslint to try to fix the js.
- `yarn fix-css` - uses stylelint to try to fix the css.

### BrowserSync ###

If you define `MIX_HOST_DOMAIN` and `MIX_PROXY_URL` in your docroot's `.env` file, running `yarn watch` will also set up a proxied version at that domain (over a different port) that auto reloads JS or CSS changes. Example:
```
MIX_HOST_DOMAIN="local.mysite.com"
MIX_PROXY_URL="http://local.mysite.com"
```
