<?php

$title       = get_field('title');
$subtitle    = get_field('subtitle');
$form_fields = get_field('form_fields');   
$button_text = get_field('button_text') ?: 'Submit';
?>

<section class="contact-form-block">
    <div class="contact-form-block__inner">
        
        <div class="contact-form__content-column">
            <div class="contact-form__content-sticky">
                <?php if (!empty($title)) : ?>
                    <h2 class="h2 contact-form__title"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                
                <?php if (!empty($subtitle)) : ?>
                    <p class="body-small-all contact-form__subtitle"><?php echo wp_kses_post($subtitle); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="contact-form__form-column">
            <div class="contact-form__form-container">
                
                <form id="js-contact-form" class="contact-form__form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" novalidate>
                    
                    <?php wp_nonce_field('submit_contact_lead', 'contact_lead_nonce'); ?>
                    <input type="hidden" name="action" value="process_contact_form_lead">

                    <div class="contact-form__grid">
                        
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
                                <div class="contact-form__field-wrap<?php echo esc_attr($modifier_class); ?>">
                                    <div class="contact-form__field">
                                        
                                        <?php if ($field_type === 'select') : ?>
                                            <select id="<?php echo esc_attr($field_id); ?>" name="<?php echo esc_attr($field_id); ?>" class="contact-form__input contact-form__select body-medium" <?php echo $required ? 'required' : ''; ?>>
                                                <option value=""><?php echo esc_html($field_label); ?><?php echo $required ? ' *' : ''; ?></option>
                                                <?php foreach ($options as $opt) : ?>
                                                    <?php 
                                                    $selected = ($opt['option_value'] === $default_value) ? 'selected' : ''; 
                                                    ?>
                                                    <option value="<?php echo esc_attr($opt['option_value']); ?>" <?php echo $selected; ?>><?php echo esc_html($opt['option_label']); ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                        <?php elseif ($field_type === 'radio') : ?>
                                            <div class="contact-form__radio-dropdown-wrapper">
                                                
                                                <div class="contact-form__input contact-form__radio-trigger body-medium">
                                                    <span class="contact-form__trigger-label"><?php echo esc_html($field_label); ?><?php echo $required ? ' *' : ''; ?></span>
                                                    <span class="contact-form__dropdown-icon">
                                                        <?php include get_template_directory() . '/resources/images/icon-chevron-down.svg'; ?>
                                                    </span>
                                                </div>
                                                
                                                <div class="contact-form__radio-dropdown-menu">
                                                    <div class="contact-form__radio-group">
                                                        <?php foreach ($options as $r_index => $opt) : 
                                                            $val = $opt['option_value'];
                                                            $lbl = $opt['option_label'];
                                                            
                                                            $checked = ($val === $default_value) ? 'checked' : ''; 
                                                        ?>
                                                            <div class="contact-form__radio-item">
                                                                <input 
                                                                    type="radio"
                                                                    id="radio-<?php echo esc_attr($val); ?>"
                                                                    name="<?php echo esc_attr($field_id); ?>"
                                                                    value="<?php echo esc_attr($val); ?>"
                                                                    class="contact-form__radio"
                                                                    <?php echo $checked; ?>
                                                                />
                                                                <label for="radio-<?php echo esc_attr($val); ?>" class="contact-form__radio-label body-medium">
                                                                    <?php echo esc_html($lbl); ?>
                                                                </label>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php else : ?>
                                            <input 
                                                type="<?php echo ($field_type === 'date') ? 'text' : esc_attr($field_type); ?>"
                                                id="<?php echo esc_attr($field_id); ?>"
                                                name="<?php echo esc_attr($field_id); ?>"
                                                placeholder="<?php echo esc_attr($field_label); ?><?php echo $required ? ' *' : ''; ?>"
                                                class="contact-form__input body-medium<?php echo ($field_type === 'date') ? ' contact-form__date-picker' : ''; ?>"
                                                <?php echo $required ? 'required' : ''; ?>
                                                <?php if ($field_type === 'date') : ?>
                                                    onfocus="(this.type='date')"
                                                    onblur="if(!this.value) this.type='text'"
                                                <?php endif; ?>
                                            />
                                        <?php endif; ?>
                                        
                                        <div class="error-message body-small" style="display: none;"></div>
                                        
                                    </div>
                                </div>
                        <?php 
                            endforeach; 
                        endif; 
                        ?>
                        
                        <div class="contact-form__field-wrap">
                            <div class="contact-form__submit-container">
                                <button type="submit" class="btn btn-primary contact-form__submit btn-text">
                                    <span><?php echo esc_html($button_text); ?></span>
                                    <span class="contact-form__submit-arrow">
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