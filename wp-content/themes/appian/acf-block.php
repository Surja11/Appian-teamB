<?php
add_action('acf/init', function () {
    if (function_exists('acf_register_block_type')) {

        $boilerplateModules = [
            'leadspace' => 'Leadspace',
            'about'     => 'About',
            'home-leadspace' => 'Home Leadspace',
            'our-work' => 'Our Work',
            'styleguide' => 'Style Guide', 
            'our-story' => 'Our Story',
            'services' => 'Services',
            'our-history' => 'Our History',
            'slider-testimonial' => 'Slider Testimonial',
<<<<<<< HEAD
            'hero-projects'      => 'Hero Projects',
            'arrow-testimonial' => 'Arrow Testimonial',
=======
            'our-partner'=>'Our Partner',
>>>>>>> 16a6d8d (AB:37 added our partners module)
        ];

        foreach ($boilerplateModules as $key => $mModule) {

            $fileName = str_replace('_', '-', $key);

            acf_register_block_type(array(
                'name'            => $key,
                'title'           => __($mModule),
                'description'     => __('A custom ' . $mModule . ' block.'),
                'render_template' => 'blocks/' . $fileName . '.php',
                'category'        => 'wp-trainee-boilerplate',
                'icon'            => 'block-default',
                'api_version'   => 3,
                'acf_block_version'   => 3,
                'style'         => "{$fileName}-module",
                'script'        => "{$fileName}-module",
                'keywords'      => [$mModule, 'wp-trainee-boilerplate'],
                'example'       => [
                    'attributes' => [
                        'mode' => 'preview',
                        'data' => [],
                    ],
                ],

                'enqueue_assets' => function () use ($fileName) {
                    $manifest = theme_vite_manifest();

                    if (empty($manifest)) {
                        return;
                    }

                    // JS ENTRY
                    $js_key = "resources/scripts/modules/{$fileName}.js";

                    if (isset($manifest[$js_key])) {
                        wp_enqueue_script_module(
                            "{$fileName}-module",
                            get_template_directory_uri() . '/public/' . $manifest[$js_key]['file'],
                            [],
                            null,
                            []
                        );
                    }

                    // CSS ENTRY
                    $css_key = "resources/styles/modules/{$fileName}.scss";

                    if (isset($manifest[$css_key])) {
                        wp_enqueue_style(
                            "{$fileName}-module",
                            get_template_directory_uri() . '/public/' . $manifest[$css_key]['file'],
                            [],
                            null
                        );
                    }
                },
            ));
        }
    }
});
