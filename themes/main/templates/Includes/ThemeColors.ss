<% cached 'ThemeColors', $SiteConfig.LastEdited %>
<%-- theme styling --%>
<% with $SiteConfig %>
<style>
:root,
[data-bs-theme=light] {
--bs-primary: #$Color(Primary);
--bs-secondary: #$Color(Secondary);
--bs-success: #$Color(Success);
--bs-info: #$Color(Info);
--bs-warning: #$Color(Warning);
--bs-danger: #$Color(Danger);
--bs-light: #$Color(Light);
--bs-dark: #$Color(Dark);

--bs-primary-rgb: $Color(Primary).Red, $Color(Primary).Green, $Color(Primary).Blue;
--bs-secondary-rgb: $Color(Secondary).Red, $Color(Secondary).Green, $Color(Secondary).Blue;
--bs-success-rgb: $Color(Success).Red, $Color(Success).Green, $Color(Success).Blue;
--bs-info-rgb: $Color(Info).Red, $Color(Info).Green, $Color(Info).Blue;
--bs-warning-rgb: $Color(Warning).Red, $Color(Warning).Green, $Color(Warning).Blue;
--bs-danger-rgb: $Color(Danger).Red, $Color(Danger).Green, $Color(Danger).Blue;
--bs-light-rgb: $Color(Light).Red, $Color(Light).Green, $Color(Light).Blue;
--bs-dark-rgb: $Color(Dark).Red, $Color(Dark).Green, $Color(Dark).Blue;

--bs-primary-text-emphasis: #$Color(Primary).Blend(0.6, '#000000');
--bs-secondary-text-emphasis: #$Color(Secondary).Blend(0.6, '#000000');
--bs-success-text-emphasis: #$Color(Success).Blend(0.6, '#000000');
--bs-info-text-emphasis: #$Color(Info).Blend(0.6, '#000000');
--bs-warning-text-emphasis: #$Color(Warning).Blend(0.6, '#000000');
--bs-danger-text-emphasis: #$Color(Danger).Blend(0.6, '#000000');
--bs-light-text-emphasis: #$Color(Dark).Blend(0.6, '#000000');
--bs-dark-text-emphasis: #$Color(Dark).Blend(0.6, '#000000');

--bs-primary-bg-subtle: #$Color(Primary).Blend(0.8, '#ffffff');
--bs-secondary-bg-subtle: #$Color(Secondary).Blend(0.8, '#ffffff');
--bs-success-bg-subtle: #$Color(Success).Blend(0.8, '#ffffff');
--bs-info-bg-subtle: #$Color(Info).Blend(0.8, '#ffffff');
--bs-warning-bg-subtle: #$Color(Warning).Blend(0.8, '#ffffff');
--bs-danger-bg-subtle: #$Color(Danger).Blend(0.8, '#ffffff');
--bs-light-bg-subtle: #fcfcfd;
--bs-dark-bg-subtle: #ced4da;

--bs-primary-border-subtle:  #$Color(Primary).Blend(0.6, '#ffffff');
--bs-secondary-border-subtle:  #$Color(Secondary).Blend(0.6, '#ffffff');
--bs-success-border-subtle:  #$Color(Success).Blend(0.6, '#ffffff');
--bs-info-border-subtle:  #$Color(Info).Blend(0.6, '#ffffff');
--bs-warning-border-subtle:  #$Color(Warning).Blend(0.6, '#ffffff');
--bs-danger-border-subtle:  #$Color(Danger).Blend(0.6, '#ffffff');
--bs-light-border-subtle: #e9ecef;
--bs-dark-border-subtle: #adb5bd;

--bs-white-rgb: 255, 255, 255;
--bs-black-rgb: 0, 0, 0;

<%-- --bs-font-sans-serif: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
--bs-font-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
--bs-gradient: linear-gradient(180deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
--bs-body-font-family: var(--bs-font-sans-serif);

--bs-body-font-size: 1rem;
--bs-body-font-weight: 400;
--bs-body-line-height: 1.5; --%>

--bs-body-color: #$Color(Dark);
--bs-body-color-rgb: $Color(Dark).Red, $Color(Dark).Green, $Color(Dark).Blue;

<%-- --bs-body-bg: #fff;
--bs-body-bg-rgb: 255, 255, 255;
--bs-emphasis-color: #000;
--bs-emphasis-color-rgb: 0, 0, 0;
 --%>
--bs-secondary-color: #$Color(Dark).CSSColor(0.75);
--bs-secondary-color-rgb: $Color(Dark).Red, $Color(Dark).Green, $Color(Dark).Blue;

--bs-secondary-bg: #e9ecef;
--bs-secondary-bg-rgb: 233, 236, 239;

--bs-tertiary-color: #$Color(Dark).CSSColor(0.5);
--bs-tertiary-color-rgb: $Color(Dark).Red, $Color(Dark).Green, $Color(Dark).Blue;

--bs-tertiary-bg: #f8f9fa;
--bs-tertiary-bg-rgb: 248, 249, 250;
--bs-heading-color: inherit;
--bs-link-color: #$Color(Primary);
--bs-link-color-rgb: $Color(Primary).Red, $Color(Primary).Green, $Color(Primary).Blue;
--bs-link-decoration: underline;
--bs-link-hover-color: #$Color(Primary).Blend(0.2, '#000000');
--bs-link-hover-color-rgb: $Color(Primary).Blend(0.2, '#000000').Red, $Color(Primary).Blend(0.2, '#000000').Green, $Color(Primary).Blend(0.2, '#000000').Blue;

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
</style>
<% end_with %>
<% end_cached %>