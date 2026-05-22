<?php
$themeUri = get_template_directory_uri();

$primaryColors = [
// Primary colors

    ['name' => 'Primary Red',     'var' => '$color-primary-red',     'hex' => '#D72027', 'class' => '.bg-primary-red',         'style' => 'background-color:var(--color-primary-red)'],
    ['name' => 'Dark Red',        'var' => '$color-dark-red',        'hex' => '#AD1A1F', 'class' => '.bg-dark-red',            'style' => 'background-color:var(--color-dark-red)'],
    ['name' => 'Ultra Dark Red',  'var' => '$color-ultra-dark-red',  'hex' => '#811317', 'class' => '.bg-ultra-dark-red',      'style' => 'background-color:var(--color-ultra-dark-red)'],
    ['name' => 'Light Red',       'var' => '$color-light-red',       'hex' => '#F3BABC', 'class' => '.bg-light-red',                                'style' => 'background-color:var(--color-light-red)'],
    ['name' => 'Ultra Light Red', 'var' => '$color-ultra-light-red', 'hex' => '#FBE9E9', 'class' => '.bg-ultra-light-red',                          'style' => 'background-color:var(--color-ultra-light-red)', 'bordered' => true],
];

$secondaryColors = [
// Secondary colors
 

    ['name' => 'Secondary',             'var' => '$color-secondary',             'hex' => '#101922', 'class' => '.bg-secondary',             'style' => 'background-color:var(--color-secondary)'],
    ['name' => 'Secondary Dark',        'var' => '$color-secondary-dark',        'hex' => '#0C131A', 'class' => '.bg-secondary-dark',                          'style' => 'background-color:var(--color-secondary-dark)'],
    ['name' => 'Secondary Light',       'var' => '$color-secondary-light',       'hex' => '#DBDDDE', 'class' => '.bg-secondary-light',                         'style' => 'background-color:var(--color-secondary-light)'],
    ['name' => 'Secondary Ultra Light', 'var' => '$color-secondary-ultra-light', 'hex' => '#E7E8E9', 'class' => '.bg-secondary-ultra-light',                   'style' => 'background-color:var(--color-secondary-ultra-light)', 'bordered' => true],
];

$neutralColors = [
// Neutral colors

    ['name' => 'Neutral 600', 'var' => '$color-neutral-600', 'hex' => '#111111', 'class' => '.bg-neutral-600', 'style' => 'background-color:var(--color-neutral-600)'],
    ['name' => 'Neutral 500', 'var' => '$color-neutral-500', 'hex' => '#1C1C1C', 'class' => '.bg-neutral-500', 'style' => 'background-color:var(--color-neutral-500)'],
    ['name' => 'Neutral 400', 'var' => '$color-neutral-400', 'hex' => '#292929', 'class' => '.bg-neutral-400', 'style' => 'background-color:var(--color-neutral-400)'],
    ['name' => 'Neutral 300', 'var' => '$color-neutral-300', 'hex' => '#393939', 'class' => '.bg-neutral-300', 'style' => 'background-color:var(--color-neutral-300)'],
    ['name' => 'Neutral 200', 'var' => '$color-neutral-200', 'hex' => '#7C7C7C', 'class' => '.bg-neutral-200', 'style' => 'background-color:var(--color-neutral-200)'],
    ['name' => 'Neutral 100', 'var' => '$color-neutral-100', 'hex' => '#DEDEDE', 'class' => '.bg-neutral-100',                     'style' => 'background-color:var(--color-neutral-100)'],
    ['name' => 'Neutral 75',  'var' => '$color-neutral-75',  'hex' => '#E9E9E9', 'class' => '.bg-neutral-75',                      'style' => 'background-color:var(--color-neutral-75)'],
    ['name' => 'Neutral 50',  'var' => '$color-neutral-50',  'hex' => '#FFFFFF', 'class' => '.bg-white',                           'style' => 'background-color:var(--color-neutral-50)', 'bordered' => true],
];

$overlayColors = [
// Overlay colors

    ['name' => 'Overlay 68%', 'var' => '--overlay-68', 'hex' => 'rgba(0,0,0,0.68)', 'style' => 'background-color:var(--overlay-68)'],
    ['name' => 'Overlay 50%', 'var' => '--overlay-50', 'hex' => 'rgba(0,0,0,0.50)', 'style' => 'background-color:var(--overlay-50)'],
    ['name' => 'Overlay 30%', 'var' => '--overlay-30', 'hex' => 'rgba(0,0,0,0.30)', 'style' => 'background-color:var(--overlay-30)'],
    ['name' => 'Overlay 20%', 'var' => '--overlay-20', 'hex' => 'rgba(0,0,0,0.20)', 'style' => 'background-color:var(--overlay-20)'],
];

$icons = [
// Icons (SVG filenames) used by the styleguide

    'icon-arrow-left.svg',
    'icon-arrow-right.svg',
    'icon-chevron-down.svg',
    'icon-close.svg',
    'icon-hamburger.svg',
    'icon-linkedin.svg',
    'icon-pause.svg',
    'icon-play.svg',
    'icon-quote.svg',
    'icon-phone.svg',
];

/*
 * This function renders a single color swatch item and provides the swatch and its metadata (name, variable, hex, class) as output.
 */
if (!function_exists('sgColorItem')) {
    function sgColorItem($color) {
        $bordered = isset($color['bordered']) && $color['bordered']
            ? ' m-styleguide__color-swatch--bordered'
            : '';
        $swatchClass = '';
        if (!empty($color['class'])) {
            $classParts = preg_split('/\s*\/\s*/', $color['class']);
            foreach ($classParts as $classPart) {
                $classPart = trim($classPart);
                if ($classPart === '') {
                    continue;
                }
                $classPart = ltrim($classPart, '.');
                $classPart = preg_split('/\s+/', $classPart)[0];
                if (strncmp($classPart, 'bg-', 3) === 0) {
                    $swatchClass = ' ' . esc_attr($classPart);
                    break;
                }
            }
        }
        $swatchStyle = '';
        if (empty($swatchClass) && !empty($color['style'])) {
            $swatchStyle = ' style="' . esc_attr($color['style']) . '"';
        }
        ?>
        <div class="m-styleguide__color-item">
            <div class="m-styleguide__color-swatch<?php echo $bordered . $swatchClass; ?>"<?php echo $swatchStyle; ?>></div>
            <div class="m-styleguide__color-info">
                <strong><?php echo esc_html($color['name']); ?></strong>
                <em><?php echo esc_html($color['var']); ?></em>
                <span><?php echo esc_html($color['hex']); ?></span>
                <?php if (!empty($color['class'])) : ?>
                    <code><?php echo esc_html($color['class']); ?></code>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
?>

<div class="m-styleguide">

    <div class="m-styleguide__header">
        <h1>Appian Design System</h1>
    </div>

    <div class="m-styleguide__body">

        <button class="m-styleguide__nav-toggle" id="sg-nav-toggle" aria-label="Toggle navigation">
            <span class="m-styleguide__nav-toggle-icon m-styleguide__nav-toggle-icon--menu">
                <?php
                $hamburger = get_template_directory() . '/resources/images/icon-hamburger.svg';
                if (file_exists($hamburger)) echo file_get_contents($hamburger);
                ?>
            </span>
            <span class="m-styleguide__nav-toggle-icon m-styleguide__nav-toggle-icon--close">
                <?php
                $close = get_template_directory() . '/resources/images/icon-close.svg';
                if (file_exists($close)) echo file_get_contents($close);
                ?>
            </span>
        </button>

        <nav class="m-styleguide__nav" id="sg-nav">
            <h2 class="m-styleguide__nav-title">Appian</h2>
            <a href="#sg-colors">Colors</a>
            <a href="#sg-typography">Typography</a>
            <a href="#sg-buttons">Buttons</a>
            <a href="#sg-grid">Grid</a>
            <a href="#sg-icons">Icons</a>
            <a href="#sg-logo">Logo &amp; Favicon</a>
            <a href="#sg-texture">Texture</a>
        </nav>

        <div class="m-styleguide__content">

            <section class="m-styleguide__section" id="sg-colors">
                <h2 class="m-styleguide__section-title">Colors</h2>

                <p class="m-styleguide__section-label">Primary</p>
                <div class="m-styleguide__color-row">
                    <?php foreach ($primaryColors as $color) sgColorItem($color); ?>
                </div>

                <p class="m-styleguide__section-label">Secondary</p>
                <div class="m-styleguide__color-row">
                    <?php foreach ($secondaryColors as $color) sgColorItem($color); ?>
                </div>

                <p class="m-styleguide__section-label">Neutrals</p>
                <div class="m-styleguide__color-row">
                    <?php foreach ($neutralColors as $color) sgColorItem($color); ?>
                </div>

                <p class="m-styleguide__section-label">Overlays</p>
                <div class="m-styleguide__color-row">
                    <?php foreach ($overlayColors as $color) sgColorItem($color); ?>
                </div>
            </section>

            <section class="m-styleguide__section" id="sg-typography">
                <h2 class="m-styleguide__section-title">Typography</h2>

                <p class="m-styleguide__section-label">Display</p>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>D1</span><span>Reckless Neue Bold</span>
                        <span>Desktop: 120px / 100%</span><span>Mobile: 48px / 110%</span>
                        <span>Weight: 700</span><span>Spacing: 0%</span>
                    </div>
                    <div class="display-1">Lorem ipsum</div>
                    <div class="m-styleguide__code"><code>&lt;h1 class="display-1"&gt;Lorem ipsum&lt;/h1&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>D2</span><span>Reckless Neue</span>
                        <span>Desktop: 88px / 120%</span><span>Mobile: 40px / 90%</span>
                        <span>Weight: 400</span><span>Spacing: -2% mobile</span>
                    </div>
                    <div class="display-2">Lorem ipsum dolor</div>
                    <div class="m-styleguide__code"><code>&lt;p class="display-2"&gt;Lorem ipsum dolor&lt;/p&gt;</code></div>
                </div>

                <p class="m-styleguide__section-label">Headings</p>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>H1</span><span>Reckless Neue Bold</span>
                        <span>Desktop: 64px / 110%</span><span>Mobile: 40px / 120%</span>
                        <span>Weight: 700</span><span>Spacing: 0%</span>
                    </div>
                    <h1>Lorem ipsum dolor</h1>
                    <div class="m-styleguide__code"><code>&lt;h1&gt;Lorem ipsum dolor&lt;/h1&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>H2</span><span>Reckless Neue Bold</span>
                        <span>Desktop: 48px / 110%</span><span>Mobile: 32px / 140%</span>
                        <span>Weight: 700</span><span>Spacing: 0%</span>
                    </div>
                    <h2>Lorem ipsum dolor sit amet</h2>
                    <div class="m-styleguide__code"><code>&lt;h2&gt;Lorem ipsum dolor sit amet&lt;/h2&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>H3</span><span>Reckless Neue Bold</span>
                        <span>Desktop: 40px / 120%</span><span>Mobile: 28px / 140%</span>
                        <span>Weight: 700</span><span>Spacing: 0%</span>
                    </div>
                    <h3>Lorem ipsum dolor sit amet, consectetur</h3>
                    <div class="m-styleguide__code"><code>&lt;h3&gt;Lorem ipsum dolor sit amet&lt;/h3&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>H4</span><span>Reckless Neue Bold</span>
                        <span>Desktop: 32px / 140%</span><span>Mobile: 28px / 140%</span>
                        <span>Weight: 700</span><span>Spacing: 0%</span>
                    </div>
                    <h4>Lorem ipsum dolor sit amet</h4>
                    <div class="m-styleguide__code"><code>&lt;h4&gt;Lorem ipsum dolor sit amet&lt;/h4&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>H5</span><span>Reckless Neue</span>
                        <span>Desktop: 28px / 140% / Weight: 400</span>
                        <span>Mobile: 18px / 160% / Weight: 700</span><span>Spacing: 0%</span>
                    </div>
                    <h5>Lorem ipsum dolor sit amet, consectetur adipiscing</h5>
                    <div class="m-styleguide__code"><code>&lt;h5&gt;Lorem ipsum dolor sit amet&lt;/h5&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>H6</span><span>Reckless Neue</span>
                        <span>Desktop: 24px / 138% / Weight: 500</span>
                        <span>Mobile: 20px / 140% / Weight: 700</span><span>Spacing: 0%</span>
                    </div>
                    <h6>Lorem ipsum dolor sit amet, consectetur adipiscing</h6>
                    <div class="m-styleguide__code"><code>&lt;h6&gt;Lorem ipsum dolor sit amet&lt;/h6&gt;</code></div>
                </div>

                <p class="m-styleguide__section-label">Subheadings</p>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>SH0</span><span>Reckless Neue Book</span>
                        <span>Desktop: 28px / 155%</span><span>Mobile: 24px / 138%</span>
                        <span>Weight: 400</span><span>Spacing: 0%</span>
                    </div>
                    <p class="subheading-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <div class="m-styleguide__code"><code>&lt;p class="subheading-0"&gt;...&lt;/p&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>SH1</span><span>Reckless Neue</span>
                        <span>Desktop: 28px / 140% / Weight: 500</span>
                        <span>Mobile: 24px / 138% / Weight: 400</span><span>Spacing: 0%</span>
                    </div>
                    <p class="subheading-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <div class="m-styleguide__code"><code>&lt;p class="subheading-1"&gt;...&lt;/p&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>SH2</span><span>Reckless Neue</span>
                        <span>Desktop: 20px / 140% / Weight: 500</span>
                        <span>Mobile: 24px / 138% / Weight: 400</span><span>Spacing: 0%</span>
                    </div>
                    <p class="subheading-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <div class="m-styleguide__code"><code>&lt;p class="subheading-2"&gt;...&lt;/p&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>SH3</span><span>Reckless Neue</span>
                        <span>Desktop: 18px / 110%</span><span>Mobile: 18px / 160%</span>
                        <span>Weight: 400</span><span>Spacing: 0%</span>
                    </div>
                    <p class="subheading-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <div class="m-styleguide__code"><code>&lt;p class="subheading-3"&gt;...&lt;/p&gt;</code></div>
                </div>

                <p class="m-styleguide__section-label">Body</p>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>Body XLarge</span><span>General Sans Medium</span>
                        <span>Desktop: 28px / 150%</span><span>Mobile: 24px / 120%</span>
                        <span>Weight: 500</span><span>Spacing: 0%</span>
                    </div>
                    <p class="body-xlarge">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
                    <div class="m-styleguide__code"><code>&lt;p class="body-xlarge"&gt;...&lt;/p&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>Body Large</span><span>General Sans Regular</span>
                        <span>18px / 140%</span><span>Weight: 400</span>
                        <span>Desktop Spacing: 2%</span><span>Mobile Spacing: 0%</span>
                    </div>
                    <p class="body body-large">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
                    <div class="m-styleguide__code"><code>&lt;p class="body body-large"&gt;...&lt;/p&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>Body Medium</span><span>General Sans Regular</span>
                        <span>16px / 140%</span><span>Weight: 400</span><span>Spacing: 0%</span>
                    </div>
                    <p class="body body-medium">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
                    <div class="m-styleguide__code"><code>&lt;p class="body body-medium"&gt;...&lt;/p&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>Body Small All</span><span>General Sans Medium</span>
                        <span>14px / 150%</span><span>Weight: 500</span><span>Spacing: 0%</span>
                    </div>
                    <p class="body body-small-all">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
                    <div class="m-styleguide__code"><code>&lt;p class="body body-small-all"&gt;...&lt;/p&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>Body Small</span><span>General Sans Regular</span>
                        <span>Desktop: 14px / 150%</span><span>Mobile: 12px / 150%</span>
                        <span>Weight: 400</span><span>Spacing: 0%</span>
                    </div>
                    <p class="body body-small">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
                    <div class="m-styleguide__code"><code>&lt;p class="body body-small"&gt;...&lt;/p&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>Body XSmall</span><span>General Sans Regular</span>
                        <span>12px / 140%</span><span>Weight: 400</span><span>Spacing: 0%</span>
                    </div>
                    <p class="body body-xsmall">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
                    <div class="m-styleguide__code"><code>&lt;p class="body body-xsmall"&gt;...&lt;/p&gt;</code></div>
                </div>

                <p class="m-styleguide__section-label">Captions</p>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>C1</span><span>General Sans Medium</span>
                        <span>Desktop: 14px / 150%</span><span>Mobile: 12px / 150%</span>
                        <span>Uppercase</span><span>Spacing: 10%</span>
                    </div>
                    <p class="caption-1">Caption One</p>
                    <div class="m-styleguide__code"><code>&lt;p class="caption-1"&gt;Caption One&lt;/p&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>C2</span><span>General Sans Medium</span>
                        <span>14px / 150%</span><span>Uppercase</span><span>Spacing: 10%</span>
                    </div>
                    <p class="caption-2">Caption Two</p>
                    <div class="m-styleguide__code"><code>&lt;p class="caption-2"&gt;Caption Two&lt;/p&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>C3</span><span>General Sans Medium</span>
                        <span>12px / 150%</span><span>Uppercase</span><span>Spacing: 10%</span>
                    </div>
                    <p class="caption-3">Caption Three</p>
                    <div class="m-styleguide__code"><code>&lt;p class="caption-3"&gt;Caption Three&lt;/p&gt;</code></div>
                </div>

                <p class="m-styleguide__section-label">Button / Nav Text</p>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>Button Text</span><span>General Sans Medium</span>
                        <span>16px / 150%</span><span>Weight: 500</span><span>Spacing: 0%</span>
                    </div>
                    <p class="btn-text">Button Text</p>
                    <div class="m-styleguide__code"><code>&lt;p class="btn-text"&gt;Button Text&lt;/p&gt;</code></div>
                </div>

                <div class="m-styleguide__type-row">
                    <div class="m-styleguide__type-meta">
                        <span>Nav Text</span><span>General Sans Medium</span>
                        <span>16px / 150%</span><span>Weight: 500</span><span>Spacing: 0%</span>
                    </div>
                    <p class="nav-text">Home</p>
                    <div class="m-styleguide__code"><code>&lt;p class="nav-text"&gt;Home&lt;/p&gt;</code></div>
                </div>

            </section>

            <section class="m-styleguide__section" id="sg-buttons">
                <h2 class="m-styleguide__section-title">Buttons</h2>
                <p class="m-styleguide__section-desc">General Sans Medium, 16px. Padding: 14px 20px (large) / 10px 14px (small). Border radius: 0.</p>

                <p class="m-styleguide__section-label">Primary (Large)</p>
                <div class="m-styleguide__btn-row">
                    <button class="btn btn-primary"><span>Label</span><span>&rarr;</span></button>
                    <button class="btn btn-primary" disabled><span>Disabled</span><span>&rarr;</span></button>
                </div>

                <p class="m-styleguide__section-label">Primary (Small)</p>
                <div class="m-styleguide__btn-row">
                    <button class="btn btn-primary btn--small"><span>Label</span><span>&rarr;</span></button>
                    <button class="btn btn-primary btn--small" disabled><span>Disabled</span><span>&rarr;</span></button>
                </div>
                <div class="m-styleguide__code">
<code>&lt;button class="btn btn-primary"&gt;&lt;span&gt;Label&lt;/span&gt;&lt;span&gt;&amp;rarr;&lt;/span&gt;&lt;/button&gt;
&lt;button class="btn btn-primary btn--small"&gt;&lt;span&gt;Label&lt;/span&gt;&lt;span&gt;&amp;rarr;&lt;/span&gt;&lt;/button&gt;
&lt;button class="btn btn-primary" disabled&gt;&lt;span&gt;Disabled&lt;/span&gt;&lt;span&gt;&amp;rarr;&lt;/span&gt;&lt;/button&gt;</code>
                </div>

                <p class="m-styleguide__section-label">Secondary with Arrow (Large)</p>
                <div class="m-styleguide__btn-row">
                    <button class="btn btn-secondary"><span>Label</span><span>&rarr;</span></button>
                    <button class="btn btn-secondary" disabled><span>Disabled</span><span>&rarr;</span></button>
                </div>

                <p class="m-styleguide__section-label">Secondary with Arrow (Small)</p>
                <div class="m-styleguide__btn-row">
                    <button class="btn btn-secondary btn--small"><span>Label</span><span>&rarr;</span></button>
                    <button class="btn btn-secondary btn--small" disabled><span>Disabled</span><span>&rarr;</span></button>
                </div>
                <div class="m-styleguide__code">
<code>&lt;button class="btn btn-secondary"&gt;&lt;span&gt;Label&lt;/span&gt;&lt;span&gt;&amp;rarr;&lt;/span&gt;&lt;/button&gt;
&lt;button class="btn btn-secondary btn--small"&gt;&lt;span&gt;Label&lt;/span&gt;&lt;span&gt;&amp;rarr;&lt;/span&gt;&lt;/button&gt;
&lt;button class="btn btn-secondary" disabled&gt;&lt;span&gt;Disabled&lt;/span&gt;&lt;span&gt;&amp;rarr;&lt;/span&gt;&lt;/button&gt;</code>
                </div>

                <p class="m-styleguide__section-label">Secondary without Arrow (Large)</p>
                <div class="m-styleguide__btn-row">
                    <button class="btn btn-secondary-no-arrow">Label</button>
                    <button class="btn btn-secondary-no-arrow" disabled>Disabled</button>
                </div>

                <p class="m-styleguide__section-label">Secondary without Arrow (Small)</p>
                <div class="m-styleguide__btn-row">
                    <button class="btn btn-secondary-no-arrow btn--small">Label</button>
                    <button class="btn btn-secondary-no-arrow btn--small" disabled>Disabled</button>
                </div>
                <div class="m-styleguide__code">
<code>&lt;button class="btn btn-secondary-no-arrow"&gt;Label&lt;/button&gt;
&lt;button class="btn btn-secondary-no-arrow btn--small"&gt;Label&lt;/button&gt;
&lt;button class="btn btn-secondary-no-arrow" disabled&gt;Disabled&lt;/button&gt;</code>
                </div>

                <p class="m-styleguide__section-label">Tertiary (Large)</p>
                <div class="m-styleguide__btn-row">
                    <button class="btn btn-tertiary"><span>Label</span><span>&rarr;</span></button>
                    <button class="btn btn-tertiary disabled"><span>Disabled</span><span>&rarr;</span></button>
                </div>

                <p class="m-styleguide__section-label">Tertiary (Small)</p>
                <div class="m-styleguide__btn-row">
                    <button class="btn btn-tertiary btn--small"><span>Label</span><span>&rarr;</span></button>
                    <button class="btn btn-tertiary btn--small disabled"><span>Disabled</span><span>&rarr;</span></button>
                </div>
                <div class="m-styleguide__code">
<code>&lt;button class="btn btn-tertiary"&gt;&lt;span&gt;Label&lt;/span&gt;&lt;span&gt;&amp;rarr;&lt;/span&gt;&lt;/button&gt;
&lt;button class="btn btn-tertiary btn--small"&gt;&lt;span&gt;Label&lt;/span&gt;&lt;span&gt;&amp;rarr;&lt;/span&gt;&lt;/button&gt;
&lt;button class="btn btn-tertiary disabled"&gt;&lt;span&gt;Disabled&lt;/span&gt;&lt;span&gt;&amp;rarr;&lt;/span&gt;&lt;/button&gt;</code>
                </div>

            </section>

            <section class="m-styleguide__section" id="sg-grid">
                <h2 class="m-styleguide__section-title">Grid</h2>

                <p class="m-styleguide__section-label">Desktop - 12 Columns (1200px+)</p>
                <div class="m-styleguide__grid-cols">
                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                        <div class="m-styleguide__grid-col">
                            <div class="col-fill"></div>
                            <small><?php echo $i; ?></small>
                        </div>
                    <?php endfor; ?>
                </div>

                <p class="m-styleguide__section-label">Mobile - 4 Columns (&lt;575px)</p>
                <div class="m-styleguide__grid-cols m-styleguide__grid-cols--mobile">
                    <?php for ($i = 1; $i <= 4; $i++) : ?>
                        <div class="m-styleguide__grid-col">
                            <div class="col-fill"></div>
                            <small><?php echo $i; ?></small>
                        </div>
                    <?php endfor; ?>
                </div>

                <table class="m-styleguide__grid-table">
                    <thead>
                        <tr>
                            <th>Viewport</th>
                            <th>Columns</th>
                            <th>Margin</th>
                            <th>Gutter</th>
                            <th>Max Width</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mobile (&lt;575px)</td>
                            <td>4</td>
                            <td>28px (1.75rem)</td>
                            <td>24px (1.5rem)</td>
                            <td>100%</td>
                        </tr>
                        <tr>
                            <td>Desktop (1200–1400px)</td>
                            <td>12</td>
                            <td>80px (5rem)</td>
                            <td>40px (2.5rem)</td>
                            <td>100%</td>
                        </tr>
                        <tr>
                            <td>Desktop Wide (1440px+)</td>
                            <td>12</td>
                            <td>Auto</td>
                            <td>40px (2.5rem)</td>
                            <td>1440px</td>
                        </tr>
                    </tbody>
                </table>

                <div class="m-styleguide__code">
<code>&lt;div class="container"&gt;
  &lt;div class="row"&gt;
    &lt;div class="col-12 col-lg-6"&gt;Half width on desktop&lt;/div&gt;
    &lt;div class="col-12 col-lg-6"&gt;Half width on desktop&lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;</code>
                </div>

            </section>

            <section class="m-styleguide__section" id="sg-icons">
                <h2 class="m-styleguide__section-title">Icons</h2>
                <p class="m-styleguide__section-desc">
                    SVG files stored in <code class="m-styleguide__inline-code">resources/images/</code>.
                    Use as inline SVGs or img tags at 24×24px.
                </p>

                <div class="m-styleguide__icon-grid">
                    <?php foreach ($icons as $icon) :
                        $filePath = get_template_directory() . '/resources/images/' . $icon;
                    ?>
                        <div class="m-styleguide__icon-item">
                            <div class="m-styleguide__icon-svg">
                                <?php
                                if (file_exists($filePath)) {
                                    echo file_get_contents($filePath);
                                } else {
                                    echo '<span>Missing</span>';
                                }
                                ?>
                            </div>
                            <code><?php echo esc_html($icon); ?></code>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="m-styleguide__code">
<code>&lt;img src="&lt;?php echo get_template_directory_uri(); ?&gt;/resources/images/icon-arrow-right.svg" alt="" width="24" height="24"&gt;
&lt;?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?&gt;</code>
                </div>

            </section>

            <section class="m-styleguide__section" id="sg-logo">
                <h2 class="m-styleguide__section-title">Logo &amp; Favicon</h2>

                <div class="m-styleguide__logo-container">

                    <h3 class="m-styleguide__logo-title">Logo</h3>

                    <div class="m-styleguide__logo-wrapper m-styleguide__logo-wrapper--light">
                        <img src="<?php echo esc_url($themeUri . '/resources/images/logo-appian.svg'); ?>" alt="Appian Logo">
                    </div>
                    <div class="m-styleguide__code"><code>&lt;img src="...resources/images/logo-appian.svg" alt="Appian"&gt;</code></div>

                    <div class="m-styleguide__logo-wrapper m-styleguide__logo-wrapper--dark">
                        <img src="<?php echo esc_url($themeUri . '/resources/images/logo-appian.svg'); ?>" alt="Appian Logo">
                    </div>

                    <h3 class="m-styleguide__logo-title">Favicon</h3>

                    <div class="m-styleguide__logo-wrapper m-styleguide__logo-wrapper--light m-styleguide__logo-wrapper--favicon">
                        <img src="<?php echo esc_url($themeUri . '/resources/images/favicon.png'); ?>" alt="Appian Favicon" class="m-styleguide__favicon">
                        <div class="m-styleguide__favicon-meta">
                            <p class="m-styleguide__favicon-name">favicon.png</p>
                            <p class="m-styleguide__favicon-desc">32px - Shown in browser tab</p>
                        </div>
                    </div>
                    <div class="m-styleguide__code">
<code>add_action('wp_head', function() {
  echo '&lt;link rel="icon" href="' . get_template_directory_uri() . '/resources/images/favicon.png"&gt;';
});</code>
                    </div>

                </div>

            </section>

            <section class="m-styleguide__section" id="sg-texture">
                <h2 class="m-styleguide__section-title">Texture</h2>

                <p class="m-styleguide__section-label">Background Texture Pattern</p>
                <div class="m-styleguide__texture-box">
                    <img src="<?php echo esc_url($themeUri . '/resources/images/bg-texture.png'); ?>" alt="Background Texture Pattern">
                </div>
                <div class="m-styleguide__code">
<code>.your-section {
  background-image: url('.../resources/images/bg-texture.png');
  background-size: cover;
  background-repeat: no-repeat;
}</code>
                </div>

            </section>

        </div>
    </div>
</div>
