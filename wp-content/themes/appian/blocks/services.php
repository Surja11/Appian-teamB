<?php
/**
 * Services Block Template - Frontend
 */
?>

<section id="services-block" class="services-block p-0 m-0">
    <div class="services-container d-flex flex-column flex-md-row w-100">
        
        <!-- Construction Department Card -->
        <div class="service-card service-card--construction position-relative overflow-hidden">
            <div class="service-card__background position-absolute w-100 h-100">
                <img src="/wp-content/themes/appian/resources/images/construction-department.png" 
                     alt="Construction Department - Leaders in the field" 
                     class="w-100 h-100" />
                <div class="service-card__overlay position-absolute w-100 h-100"></div>
            </div>
            
            <div class="service-card__content h-100 text-white">
                <div class="service-card__top-content d-flex flex-column">
                    <div class="service-card__label caption-1 order-2 order-md-1">
                        LEADERS IN THE FIELD
                    </div>
                    <h2 class="service-card__title h1 order-1 order-md-2">
                        Construction<br>Department
                    </h2>
                </div>
                
                <a href="#" class="btn btn-primary btn--small">
                    <span></span>
                    <span><?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?></span>
                </a>
            </div>
        </div>

<!-- Service Department Card -->
<div class="service-card service-card--service position-relative overflow-hidden">
    <div class="service-card__background position-absolute w-100 h-100">
        <img src="/wp-content/themes/appian/resources/images/service-department.png" 
             alt="Service Department - Experience that matters" 
             class="w-100 h-100" />
        <div class="service-card__overlay position-absolute w-100 h-100"></div>
    </div>
    
    <div class="service-card__content h-100 text-white">
        <div class="service-card__top-content d-flex flex-column">
            <div class="service-card__label caption-1">
                EXPERIENCE THAT MATTERS
            </div>
            <h2 class="service-card__title h1">
                Service<br>Department
            </h2>
        </div>
        
        <a href="#" class="btn btn-primary btn--small">
            <span></span>
            <span><?php include get_template_directory() . '/resources/images/icon-arrow-right.svg'; ?></span>
        </a>
    </div>
</div>        

    </div>
</section>