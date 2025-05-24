<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<?php
$business_name = isset($attributes['businessName']) ? esc_html($attributes['businessName']) : '';
$external_url = isset($attributes['externalUrl']) ? esc_url($attributes['externalUrl']) : '';
$threshold = isset($attributes['threshold']) ? intval($attributes['threshold']) : 4;
?>
<div <?php echo get_block_wrapper_attributes(); ?>
     data-business-name="<?php echo $business_name; ?>"
     data-external-url="<?php echo $external_url; ?>"
     data-threshold="<?php echo $threshold; ?>"
>
    <h3><?php esc_html_e('Rate Your Experience', 'stealth-ratings-block'); ?></h3>
    <p><?php esc_html_e('How would you rate your experience with', 'stealth-ratings-block'); ?> <?php echo $business_name; ?>?</p>
    <div class="stealth-ratings-stars" tabindex="0">
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <span class="star" data-star="<?php echo $i; ?>" aria-label="<?php echo esc_attr($i . ' star' . ($i > 1 ? 's' : '')); ?>">★</span>
        <?php endfor; ?>
    </div>
    <div class="stealth-ratings-caption" style="text-align:center; color:#b0b0b0; font-size:1rem; margin-bottom:1.2rem;">
        <?php esc_html_e('Tap a star to rate', 'stealth-ratings-block'); ?>
    </div>
    <form class="stealth-ratings-form" style="display:none; margin-top:1.5rem;">
        <p><?php esc_html_e('Thank you for your rating. We\'d love to hear how we can improve.', 'stealth-ratings-block'); ?></p>
        <label>
            <?php echo sprintf(esc_html__('How could %s have done better?', 'stealth-ratings-block'), $business_name); ?>
            <textarea name="feedback" required placeholder="<?php esc_attr_e('Please share your thoughts...', 'stealth-ratings-block'); ?>"></textarea>
        </label>
        <label>
            <?php esc_html_e('Your name (optional)', 'stealth-ratings-block'); ?>
            <input type="text" name="name" placeholder="<?php esc_attr_e('John Doe', 'stealth-ratings-block'); ?>" />
        </label>
        <button type="submit" class="components-button is-primary" style="margin-top:1rem; width:100%;">
            <?php esc_html_e('Submit Feedback', 'stealth-ratings-block'); ?>
        </button>
    </form>
    <div class="stealth-ratings-success" style="display:none;"></div>
    <div class="stealth-ratings-redirect" style="display:none;"></div>
</div>

