<?php

$title          = get_field('title');
$subtitle       = get_field('subtitle');
$form_fields    = get_field('form_fields');
$button_text    = get_field('button_text') ?: 'Submit';
$date_restrictions = get_field('date_restrictions');
$max_future_period = $date_restrictions['max_future_period'] ?? '12';
?>

<section class="contact-form-block position-relative w-100 h-auto mx-auto bg-transparent" data-max-future-period="<?php echo esc_attr($max_future_period); ?>">
    <div class="contact-form-block__inner d-flex flex-column w-100 mx-auto my-0 p-0">
        
        <div class="contact-form__content-column flex-grow-0 flex-shrink-0 p-0 bg-transparent">
            <div class="contact-form__content-sticky">
                <?php if (!empty($title)) : ?>
                    <h2 class="h2 contact-form__title"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if (!empty($subtitle)) : ?>
                    <p class="body-small-all contact-form__subtitle"><?php echo wp_kses_post($subtitle); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="contact-form__form-column w-100 flex-fill">
            <div class="contact-form__form-container w-100 m-0">
                
                <form id="js-contact-form" class="contact-form__form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" novalidate>

                    <?php wp_nonce_field('submit_contact_lead', 'contact_lead_nonce'); ?>

                    <div class="contact-form__grid d-flex flex-wrap">
                        
                        <?php 
                        if (!empty($form_fields)) : 
                            foreach ($form_fields as $index => $field) : 
                                $field_type    = $field['field_type'] ?? 'text';
                                $field_label   = $field['field_label'] ?? '';
                                $required      = !empty($field['required']) ? true : false;
                                $field_id      = sanitize_title($field_label);
                                $options       = $field['field_options_list'] ?? [];
                                $default_value = $field['default_value'] ?? '';

                                $modifier_class = '';
                                if (in_array($field_type, ['text', 'email', 'tel']) && $index < 2) {
                                    $modifier_class = ' contact-form__field-wrap--half';
                                }
                        ?>
                                <div class="contact-form__field-wrap w-100 flex-grow-0 flex-shrink-0<?php echo esc_attr($modifier_class); ?>">
                                    <div class="contact-form__field position-relative w-100">
                                        
                                        <?php if ($field_type === 'select') : ?>
                                            <select id="<?php echo esc_attr($field_id); ?>" name="<?php echo esc_attr($field_id); ?>" class="contact-form__input contact-form__select body w-100 cursor-pointer bg-white rounded" 
                                                    <?php echo $required ? 'required' : ''; ?>>
                                                <option value=""><?php echo esc_html($field_label); ?><?php echo $required ? ' *' : ''; ?></option>
                                                <?php foreach ($options as $opt) : ?>
                                                    <?php
                                                    $selected = ($opt['option_value'] === $default_value) ? 'selected' : '';
                                                    ?>
                                                    <option value="<?php echo esc_attr($opt['option_value']); ?>" <?php echo $selected; ?>><?php echo esc_html($opt['option_label']); ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                        <?php elseif ($field_type === 'radio') : ?>
                                            <div class="contact-form__radio-dropdown-wrapper position-relative w-100">
                                                
                                                <div class="contact-form__input contact-form__radio-trigger body d-flex align-items-center justify-content-between user-select-none w-100 cursor-pointer bg-white rounded">
                                                    <span class="contact-form__trigger-label">
                                                        <span class="placeholder-text"><?php echo esc_html($field_label); ?><?php echo $required ? ' *' : ''; ?></span>
                                                    </span>
                                                    <span class="contact-form__dropdown-icon d-flex align-items-center justify-content-center">
                                                        <?php include get_template_directory() . '/resources/images/icon-chevron-down.svg'; ?>
                                                    </span>
                                                </div>
                                                
                                                <div class="contact-form__radio-dropdown-menu w-100 bg-transparent">
                                                    <div class="contact-form__radio-group d-flex flex-column mt-0">
                                                        <?php foreach ($options as $r_index => $opt) : 
                                                            $val = $opt['option_value'];
                                                            $lbl = $opt['option_label'];

                                                            $checked = ($val === $default_value) ? 'checked' : '';
                                                        ?>
                                                            <div class="contact-form__radio-item d-flex align-items-center">
                                                                <input 
                                                                    type="radio"
                                                                    id="radio-<?php echo esc_attr($val); ?>"
                                                                    name="<?php echo esc_attr($field_id); ?>"
                                                                    value="<?php echo esc_attr($val); ?>"
                                                                    class="contact-form__radio position-relative d-inline-flex align-items-center justify-content-center cursor-pointer bg-white rounded-circle"
                                                                    <?php echo $checked; ?>
                                                                />
                                                                <label for="radio-<?php echo esc_attr($val); ?>" class="contact-form__radio-label body d-flex align-items-center m-0 cursor-pointer">
                                                                    <?php echo esc_html($lbl); ?>
                                                                </label>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php else : ?>
                                            <input
                                                type="<?php echo esc_attr($field_type); ?>"
                                                id="<?php echo esc_attr($field_id); ?>"
                                                name="<?php echo esc_attr($field_id); ?>"
                                                placeholder="<?php echo esc_attr($field_label); ?><?php echo $required ? ' *' : ''; ?>"
                                                class="contact-form__input body w-100 bg-white rounded<?php echo ($field_type === 'date') ? ' contact-form__date-picker' : ''; ?>"
                                                <?php echo $required ? 'required' : ''; ?>
                                                <?php if ($field_type === 'email') : ?>
                                                title="Please enter a valid email address"
                                                <?php endif; ?> />
                                        <?php endif; ?>
                                        
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>
                        
                        <div class="contact-form__field-wrap w-100 flex-grow-0 flex-shrink-0">
                            <div class="contact-form__submit-container w-100 mt-6">
                                <button type="submit" class="btn btn-primary contact-form__submit btn-lg d-inline-flex align-items-center border-0 text-white position-relative rounded-0">
                                    <span><?php echo esc_html($button_text); ?></span>
                                    <span class="contact-form__submit-arrow d-flex align-items-center position-relative">
                                        <?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?>
                                    </span>
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
