<div id="wt-gallery-block-<?php echo $this->counter; ?>" class="swiper-container">
    <div class="swiper-wrapper">
    <?php foreach ($images as $image) { ?>
        <a href="<?php echo $image['src']; ?>" class="swiper-slide"
            <?php if (!empty($image['title'])) echo 'title="' . $image['title'] . '"';?>>
            <img src="<?php echo $image['src_miniature']; ?>" alt="<?php echo $image['alt']; ?>" />
        </a>
    <?php } ?>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('#wt-gallery-block-<?php echo $this->counter; ?>', {
        pagination: '#wt-gallery-block-<?php echo $this->counter; ?> .swiper-pagination',
        nextButton: '#wt-gallery-block-<?php echo $this->counter; ?> .swiper-button-next',
        prevButton: '#wt-gallery-block-<?php echo $this->counter; ?> .swiper-button-prev',
        slidesPerView: 'auto',
        paginationClickable: true,
        spaceBetween: 10
    });

    jQuery('#wt-gallery-block-<?php echo $this->counter; ?> .swiper-wrapper').magnificPopup({
        delegate: 'a', // child items selector, by clicking on it popup will open
        type: 'image',
        gallery:{
            enabled:true,
            tCounter: '%curr% из %total%'
        }
        // other options
    });
</script>
