<% cached 'ThemeColors', $SiteConfig.LastEdited %>
<%-- theme styling --%>
<% with $SiteConfig %>
<style>
:root,
[data-bs-theme=light] {
--bs-primary: $ColorHex(Primary);
--bs-secondary: $ColorHex(Secondary);
--bs-success: $ColorHex(Success);
--bs-info: $ColorHex(Info);
--bs-warning: $ColorHex(Warning);
--bs-danger: $ColorHex(Danger);
--bs-light: $ColorHex(Light);
--bs-dark: $ColorHex(Dark);

--bs-primary-rgb: $ColorRGBVals(Primary);
--bs-secondary-rgb: $ColorRGBVals(Secondary);
--bs-success-rgb: $ColorRGBVals(Success);
--bs-info-rgb: $ColorRGBVals(Info);
--bs-warning-rgb: $ColorRGBVals(Warning);
--bs-danger-rgb: $ColorRGBVals(Danger);
--bs-light-rgb: $ColorRGBVals(Light);
--bs-dark-rgb: $ColorRGBVals(Dark);

--bs-primary-text-emphasis: $ColorHex(PrimaryTextEmphasis);
--bs-secondary-text-emphasis: $ColorHex(SecondaryTextEmphasis);
--bs-success-text-emphasis: $ColorHex(SuccessTextEmphasis);
--bs-info-text-emphasis: $ColorHex(InfoTextEmphasis);
--bs-warning-text-emphasis: $ColorHex(WarningTextEmphasis);
--bs-danger-text-emphasis: $ColorHex(DangerTextEmphasis);
--bs-light-text-emphasis: $ColorHex(DarkTextEmphasis);
--bs-dark-text-emphasis: $ColorHex(DarkTextEmphasis);

--bs-primary-bg-subtle: $ColorHex(PrimaryBgSubtle);
--bs-secondary-bg-subtle: $ColorHex(SecondaryBgSubtle);
--bs-success-bg-subtle: $ColorHex(SuccessBgSubtle);
--bs-info-bg-subtle: $ColorHex(InfoBgSubtle);
--bs-warning-bg-subtle: $ColorHex(WarningBgSubtle);
--bs-danger-bg-subtle: $ColorHex(DangerBgSubtle);
--bs-light-bg-subtle: $ColorHex(LightBgSubtle);
--bs-dark-bg-subtle: $ColorHex(DarkBgSubtle);

--bs-primary-border-subtle:  $ColorHex(PrimaryBorderSubtle);
--bs-secondary-border-subtle:  $ColorHex(SecondaryBorderSubtle);
--bs-success-border-subtle:  $ColorHex(SuccessBorderSubtle);
--bs-info-border-subtle:  $ColorHex(InfoBorderSubtle);
--bs-warning-border-subtle:  $ColorHex(WarningBorderSubtle);
--bs-danger-border-subtle:  $ColorHex(DangerBorderSubtle);
--bs-light-border-subtle: $ColorHex(LightBorderSubtle);
--bs-dark-border-subtle: $ColorHex(DarkBorderSubtle);

--bs-white-rgb: $ColorRGBVals(White);
--bs-black-rgb: $ColorRGBVals(Black);

--bs-font-sans-serif: <% if $FontData(Body).type == 'sans' %>$FontData(Body).family.RAW<% else %>system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"<% end_if %>;
--bs-font-monospace: <% if $FontData(Monospace) %>$FontData(Monospace).family.RAW<% else %>SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace<% end_if %>;
--bs-body-font-family: <% if $FontData(Body) %>$FontData(Body).family.RAW<% else %>system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"<% end_if %>;
--bs-body-headline-family: <% if $FontData(Headline) %>$FontData(Headline).family.RAW<% else %>var(--bs-body-font-family)<% end_if %>;
<%-- --bs-gradient: linear-gradient(180deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0)); --%>

<%-- --bs-body-font-size: 1rem;
--bs-body-font-weight: 400;
--bs-body-line-height: 1.5; --%>

--bs-body-color: $ColorHex(BodyColor);
--bs-body-color-rgb: $ColorRGBVals(BodyColor);

<%-- --bs-body-bg: #fff;
--bs-body-bg-rgb: 255, 255, 255;
--bs-emphasis-color: #000;
--bs-emphasis-color-rgb: 0, 0, 0;
 --%>
--bs-secondary-color: $ColorHex(SecondaryColor);
--bs-secondary-color-rgb: $ColorRGBVals(SecondaryColor);

--bs-secondary-bg: $ColorHex(SecondaryColor);
--bs-secondary-bg-rgb: $ColorRGBVals(SecondaryColor);

--bs-tertiary-color: $ColorHex(TertiaryColor);
--bs-tertiary-color-rgb: $ColorRGBVals(TertiaryColor);

--bs-tertiary-bg: #f8f9fa;
--bs-tertiary-bg-rgb: 248, 249, 250;
--bs-heading-color: inherit;
--bs-link-color: $ColorHex(Primary);
--bs-link-color-rgb: $ColorRGBVals(Primary);
--bs-link-decoration: underline;
--bs-link-hover-color: $ColorHex(Primary).Blend(0.2, '#000000');
--bs-link-hover-color-rgb: $ColorRGBVals(Primary).Blend(0.2, '#000000');

<%-- --bs-code-color: #d63384;
--bs-highlight-color: #212529;
--bs-highlight-bg: #fff3cd;
--bs-border-width: 1px;
--bs-border-style: solid;
--bs-border-color: #dee2e6;
--bs-border-color-translucent: rgba(0, 0, 0, 0.175);
--bs-border-radius: 0.375rem;
--bs-border-radius-sm: 0.25rem;
--bs-border-radius-lg: 0.5rem;
--bs-border-radius-xl: 1rem;
--bs-border-radius-xxl: 2rem;
--bs-border-radius-2xl: var(--bs-border-radius-xxl);
--bs-border-radius-pill: 50rem;
--bs-box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
--bs-box-shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
--bs-box-shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
--bs-box-shadow-inset: inset 0 1px 2px rgba(0, 0, 0, 0.075);
--bs-focus-ring-width: 0.25rem;
--bs-focus-ring-opacity: 0.25;
--bs-focus-ring-color: rgba(13, 110, 253, 0.25);
--bs-form-valid-color: #198754;
--bs-form-valid-border-color: #198754;
--bs-form-invalid-color: #dc3545;
--bs-form-invalid-border-color: #dc3545; --%>
}
<%-- 
[data-bs-theme=dark] {
color-scheme: dark;
--bs-body-color: #dee2e6;
--bs-body-color-rgb: 222, 226, 230;
--bs-body-bg: #212529;
--bs-body-bg-rgb: 33, 37, 41;
--bs-emphasis-color: #fff;
--bs-emphasis-color-rgb: 255, 255, 255;
--bs-secondary-color: rgba(222, 226, 230, 0.75);
--bs-secondary-color-rgb: 222, 226, 230;
--bs-secondary-bg: #343a40;
--bs-secondary-bg-rgb: 52, 58, 64;
--bs-tertiary-color: rgba(222, 226, 230, 0.5);
--bs-tertiary-color-rgb: 222, 226, 230;
--bs-tertiary-bg: #2b3035;
--bs-tertiary-bg-rgb: 43, 48, 53;
--bs-primary-text-emphasis: #6ea8fe;
--bs-secondary-text-emphasis: #a7acb1;
--bs-success-text-emphasis: #75b798;
--bs-info-text-emphasis: #6edff6;
--bs-warning-text-emphasis: #ffda6a;
--bs-danger-text-emphasis: #ea868f;
--bs-light-text-emphasis: #f8f9fa;
--bs-dark-text-emphasis: #dee2e6;
--bs-primary-bg-subtle: #031633;
--bs-secondary-bg-subtle: #161719;
--bs-success-bg-subtle: #051b11;
--bs-info-bg-subtle: #032830;
--bs-warning-bg-subtle: #332701;
--bs-danger-bg-subtle: #2c0b0e;
--bs-light-bg-subtle: #343a40;
--bs-dark-bg-subtle: #1a1d20;
--bs-primary-border-subtle: #084298;
--bs-secondary-border-subtle: #41464b;
--bs-success-border-subtle: #0f5132;
--bs-info-border-subtle: #087990;
--bs-warning-border-subtle: #997404;
--bs-danger-border-subtle: #842029;
--bs-light-border-subtle: #495057;
--bs-dark-border-subtle: #343a40;
--bs-heading-color: inherit;
--bs-link-color: #6ea8fe;
--bs-link-hover-color: #8bb9fe;
--bs-link-color-rgb: 110, 168, 254;
--bs-link-hover-color-rgb: 139, 185, 254;
--bs-code-color: #e685b5;
--bs-highlight-color: #dee2e6;
--bs-highlight-bg: #664d03;
--bs-border-color: #495057;
--bs-border-color-translucent: rgba(255, 255, 255, 0.15);
--bs-form-valid-color: #75b798;
--bs-form-valid-border-color: #75b798;
--bs-form-invalid-color: #ea868f;
--bs-form-invalid-border-color: #ea868f;
} --%>

<%-- btn vars --%>

<%--
--bs-primary: $ColorHex(Primary);
--bs-secondary: $ColorHex(Secondary);
--bs-success: $ColorHex(Success);
--bs-info: $ColorHex(Info);
--bs-warning: $ColorHex(Warning);
--bs-danger: $ColorHex(Danger);
--bs-light: $ColorHex(Light);
--bs-dark: $ColorHex(Dark);
--%>

.btn-primary, 
button, 
input[type=button], 
input[type=submit] {
    --bs-btn-color: #fff;
    --bs-btn-bg: $ColorHex(Primary);
    --bs-btn-border-color: $ColorHex(Primary);
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: $ColorHex(PrimaryTextEmphasis);
    --bs-btn-hover-border-color: $ColorHex(PrimaryTextEmphasis);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Primary);
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: $ColorHex(PrimaryTextEmphasis);
    --bs-btn-active-border-color: $ColorHex(PrimaryTextEmphasis);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: $ColorHex(Primary);
    --bs-btn-disabled-border-color:$ColorHex(Primary)
}

.btn-secondary, button.-secondary, input[type=button].-secondary, input[type=submit].-secondary {
    --bs-btn-color: #fff;
    --bs-btn-bg: $ColorHex(Secondary);
    --bs-btn-border-color: $ColorHex(Secondary);
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: #5c636a;
    --bs-btn-hover-border-color: $ColorHex(SecondaryTextEmphasis);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Secondary);
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: $ColorHex(SecondaryTextEmphasis);
    --bs-btn-active-border-color: $ColorHex(SecondaryTextEmphasis);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: $ColorHex(Secondary);
    --bs-btn-disabled-border-color:$ColorHex(Secondary)
}

.btn-success {
    --bs-btn-color: #fff;
    --bs-btn-bg: $ColorHex(Success);
    --bs-btn-border-color: $ColorHex(Success);
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: $ColorHex(SuccessTextEmphasis);
    --bs-btn-hover-border-color: $ColorHex(SuccessTextEmphasis);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Success);
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: $ColorHex(SuccessTextEmphasis);
    --bs-btn-active-border-color: $ColorHex(SuccessTextEmphasis);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: $ColorHex(Success);
    --bs-btn-disabled-border-color:$ColorHex(Success)
}

.btn-info {
    --bs-btn-color: #000;
    --bs-btn-bg: $ColorHex(Info);
    --bs-btn-border-color: $ColorHex(Info);
    --bs-btn-hover-color: #000;
    --bs-btn-hover-bg: $ColorHex(InfoTextEmphasis);
    --bs-btn-hover-border-color: $ColorHex(InfoTextEmphasis);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Info);
    --bs-btn-active-color: #000;
    --bs-btn-active-bg: #3dd5f3;
    --bs-btn-active-border-color: $ColorHex(InfoTextEmphasis);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: #000;
    --bs-btn-disabled-bg: $ColorHex(Info);
    --bs-btn-disabled-border-color:$ColorHex(Info)
}

.btn-warning {
    --bs-btn-color: #000;
    --bs-btn-bg: $ColorHex(Warning);
    --bs-btn-border-color: $ColorHex(Warning);
    --bs-btn-hover-color: #000;
    --bs-btn-hover-bg: $ColorHex(WarningTextEmphasis);
    --bs-btn-hover-border-color: $ColorHex(WarningTextEmphasis);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Warning);
    --bs-btn-active-color: #000;
    --bs-btn-active-bg: $ColorHex(WarningTextEmphasis);
    --bs-btn-active-border-color: $ColorHex(WarningTextEmphasis);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: #000;
    --bs-btn-disabled-bg: $ColorHex(Warning);
    --bs-btn-disabled-border-color:$ColorHex(Warning)
}

.btn-danger {
    --bs-btn-color: #fff;
    --bs-btn-bg: $ColorHex(Danger);
    --bs-btn-border-color: $ColorHex(Danger);
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: $ColorHex(DangerTextEmphasis);
    --bs-btn-hover-border-color: $ColorHex(DangerTextEmphasis);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Danger);
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: $ColorHex(DangerTextEmphasis);
    --bs-btn-active-border-color: $ColorHex(DangerTextEmphasis);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: $ColorHex(Danger);
    --bs-btn-disabled-border-color:$ColorHex(Danger)
}

.btn-light {
    --bs-btn-color: #000;
    --bs-btn-bg: $ColorHex(Light);
    --bs-btn-border-color: $ColorHex(Light);
    --bs-btn-hover-color: #000;
    --bs-btn-hover-bg: $ColorHex(LightTextEmphasis);
    --bs-btn-hover-border-color: $ColorHex(LightTextEmphasis);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Light);
    --bs-btn-active-color: #000;
    --bs-btn-active-bg: $ColorHex(LightTextEmphasis);
    --bs-btn-active-border-color: $ColorHex(LightTextEmphasis);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: #000;
    --bs-btn-disabled-bg: $ColorHex(Light);
    --bs-btn-disabled-border-color:$ColorHex(Light)
}

.btn-dark {
    --bs-btn-color: #fff;
    --bs-btn-bg: $ColorHex(Dark);
    --bs-btn-border-color: $ColorHex(Dark);
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: $ColorHex(DarkTextEmphasis);
    --bs-btn-hover-border-color: $ColorHex(DarkTextEmphasis);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Dark);
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: $ColorHex(DarkTextEmphasis);
    --bs-btn-active-border-color: $ColorHex(DarkTextEmphasis);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: $ColorHex(Dark);
    --bs-btn-disabled-border-color:$ColorHex(Dark)
}

.btn-outline-primary, .optionset.inline-options > .middleColumn > .optionset label {
    --bs-btn-color: $ColorHex(Primary);
    --bs-btn-border-color: $ColorHex(Primary);
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: $ColorHex(Primary);
    --bs-btn-hover-border-color: $ColorHex(Primary);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Primary);
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: $ColorHex(Primary);
    --bs-btn-active-border-color: $ColorHex(Primary);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: $ColorHex(Primary);
    --bs-btn-disabled-bg: transparent;
    --bs-btn-disabled-border-color: $ColorHex(Primary);
    --bs-gradient:none
}

.btn-outline-secondary {
    --bs-btn-color: $ColorHex(Secondary);
    --bs-btn-border-color: $ColorHex(Secondary);
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: $ColorHex(Secondary);
    --bs-btn-hover-border-color: $ColorHex(Secondary);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Secondary);
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: $ColorHex(Secondary);
    --bs-btn-active-border-color: $ColorHex(Secondary);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: $ColorHex(Secondary);
    --bs-btn-disabled-bg: transparent;
    --bs-btn-disabled-border-color: $ColorHex(Secondary);
    --bs-gradient:none
}

.btn-outline-success {
    --bs-btn-color: $ColorHex(Success);
    --bs-btn-border-color: $ColorHex(Success);
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: $ColorHex(Success);
    --bs-btn-hover-border-color: $ColorHex(Success);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Success);
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: $ColorHex(Success);
    --bs-btn-active-border-color: $ColorHex(Success);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: $ColorHex(Success);
    --bs-btn-disabled-bg: transparent;
    --bs-btn-disabled-border-color: $ColorHex(Success);
    --bs-gradient:none
}

.btn-outline-info {
    --bs-btn-color: $ColorHex(Info);
    --bs-btn-border-color: $ColorHex(Info);
    --bs-btn-hover-color: #000;
    --bs-btn-hover-bg: $ColorHex(Info);
    --bs-btn-hover-border-color: $ColorHex(Info);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Info);
    --bs-btn-active-color: #000;
    --bs-btn-active-bg: $ColorHex(Info);
    --bs-btn-active-border-color: $ColorHex(Info);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: $ColorHex(Info);
    --bs-btn-disabled-bg: transparent;
    --bs-btn-disabled-border-color: $ColorHex(Info);
    --bs-gradient:none
}

.btn-outline-warning {
    --bs-btn-color: $ColorHex(Warning);
    --bs-btn-border-color: $ColorHex(Warning);
    --bs-btn-hover-color: #000;
    --bs-btn-hover-bg: $ColorHex(Warning);
    --bs-btn-hover-border-color: $ColorHex(Warning);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Warning);
    --bs-btn-active-color: #000;
    --bs-btn-active-bg: $ColorHex(Warning);
    --bs-btn-active-border-color: $ColorHex(Warning);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: $ColorHex(Warning);
    --bs-btn-disabled-bg: transparent;
    --bs-btn-disabled-border-color: $ColorHex(Warning);
    --bs-gradient:none
}

.btn-outline-danger {
    --bs-btn-color: $ColorHex(Danger);
    --bs-btn-border-color: $ColorHex(Danger);
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: $ColorHex(Danger);
    --bs-btn-hover-border-color: $ColorHex(Danger);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Danger);
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: $ColorHex(Danger);
    --bs-btn-active-border-color: $ColorHex(Danger);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: $ColorHex(Danger);
    --bs-btn-disabled-bg: transparent;
    --bs-btn-disabled-border-color: $ColorHex(Danger);
    --bs-gradient:none
}

.btn-outline-light {
    --bs-btn-color: $ColorHex(Light);
    --bs-btn-border-color: $ColorHex(Light);
    --bs-btn-hover-color: #000;
    --bs-btn-hover-bg: $ColorHex(Light);
    --bs-btn-hover-border-color: $ColorHex(Light);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Light);
    --bs-btn-active-color: #000;
    --bs-btn-active-bg: $ColorHex(Light);
    --bs-btn-active-border-color: $ColorHex(Light);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: $ColorHex(Light);
    --bs-btn-disabled-bg: transparent;
    --bs-btn-disabled-border-color: $ColorHex(Light);
    --bs-gradient:none
}

.btn-outline-dark {
    --bs-btn-color: $ColorHex(Dark);
    --bs-btn-border-color: $ColorHex(Dark);
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: $ColorHex(Dark);
    --bs-btn-hover-border-color: $ColorHex(Dark);
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Dark);
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: $ColorHex(Dark);
    --bs-btn-active-border-color: $ColorHex(Dark);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    --bs-btn-disabled-color: $ColorHex(Dark);
    --bs-btn-disabled-bg: transparent;
    --bs-btn-disabled-border-color: $ColorHex(Dark);
    --bs-gradient:none
}

.btn-link {
    --bs-btn-font-weight: 400;
    --bs-btn-color: var(--bs-link-color);
    --bs-btn-bg: transparent;
    --bs-btn-border-color: transparent;
    --bs-btn-hover-color: var(--bs-link-hover-color);
    --bs-btn-hover-border-color: transparent;
    --bs-btn-active-color: var(--bs-link-hover-color);
    --bs-btn-active-border-color: transparent;
    --bs-btn-disabled-color: $ColorHex(Secondary);
    --bs-btn-disabled-border-color: transparent;
    --bs-btn-box-shadow: 0 0 0 #000;
    --bs-btn-focus-shadow-rgb: $ColorRGBVals(Primary);
    text-decoration:underline
}


</style>
<% end_with %>
<% end_cached %>