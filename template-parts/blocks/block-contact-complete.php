<?php
/**
 * Block: Contact Complete (All-in-One for Kontakt page)
 * Complete contact page with form, info, and map with LIVE PREVIEW
 */

// Get all fields
$hero_title = get_field('contact_hero_title');
$hero_subtitle = get_field('contact_hero_subtitle');
$hero_background = get_field('contact_hero_background');

$form_title = get_field('contact_form_title');
$form_subtitle = get_field('contact_form_subtitle');
$show_phone = get_field('contact_show_phone');
$show_email = get_field('contact_show_email');
$show_address = get_field('contact_show_address');

$map_enabled = get_field('contact_map_enabled');
$map_address = get_field('contact_map_address');
$map_embed = get_field('contact_map_embed');

$info_title = get_field('contact_info_title');
$phone = get_field('contact_phone');
$email = get_field('contact_email');
$address = get_field('contact_address');
$hours = get_field('contact_hours');

$block_id = 'contact-complete-' . $block['id'];
?>

<div class="contact-complete-page" id="<?php echo esc_attr($block_id); ?>">

    <!-- Hero Section -->
    <section class="contact-hero" style="background-image: url('<?php echo esc_url($hero_background['url'] ?? ''); ?>');">
        <div class="container">
            <div class="hero-content text-center">
                <?php if ($hero_title): ?>
                    <h1><?php echo esc_html($hero_title); ?></h1>
                <?php endif; ?>
                <?php if ($hero_subtitle): ?>
                    <p class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Contact Form & Info Section -->
    <section class="contact-main section-padding">
        <div class="container">
            <div class="contact-grid">

                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    <?php if ($form_title || $form_subtitle): ?>
                    <div class="form-header">
                        <?php if ($form_title): ?>
                            <h2><?php echo esc_html($form_title); ?></h2>
                        <?php endif; ?>
                        <?php if ($form_subtitle): ?>
                            <p><?php echo esc_html($form_subtitle); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <form class="contact-form" id="contact-form" method="post" action="" novalidate>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="vorname">Vorname *</label>
                                <input type="text" id="vorname" name="vorname" required>
                            </div>

                            <div class="form-group">
                                <label for="nachname">Nachname *</label>
                                <input type="text" id="nachname" name="nachname" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">E-Mail *</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <?php if ($show_phone): ?>
                        <div class="form-group">
                            <label for="phone">Telefon</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="betreff">Betreff *</label>
                            <input type="text" id="betreff" name="betreff" required>
                        </div>

                        <div class="form-group">
                            <label for="nachricht">Nachricht *</label>
                            <textarea id="nachricht" name="nachricht" rows="6" required></textarea>
                        </div>

                        <div id="form-message" class="form-message" style="display: none;"></div>

                        <button type="submit" class="btn btn-primary btn-lg" id="submit-btn">
                            Nachricht senden
                        </button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="contact-info-wrapper">
                    <?php if ($info_title): ?>
                        <h3><?php echo esc_html($info_title); ?></h3>
                    <?php endif; ?>

                    <div class="contact-info">
                        <?php if ($phone): ?>
                        <div class="info-item">
                            <div class="info-icon">
                                <?php echo wohnegruen_get_icon('phone'); ?>
                            </div>
                            <div class="info-content">
                                <h4>Telefon</h4>
                                <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>">
                                    <?php echo esc_html($phone); ?>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($email): ?>
                        <div class="info-item">
                            <div class="info-icon">
                                <?php echo wohnegruen_get_icon('email'); ?>
                            </div>
                            <div class="info-content">
                                <h4>E-Mail</h4>
                                <a href="mailto:<?php echo esc_attr($email); ?>">
                                    <?php
                                        // Decode punycode for display (e.g., xn--wohnegrn-d6a.at → wohnegrün.at)
                                        $display_email = $email;
                                        if (function_exists('idn_to_utf8')) {
                                            $parts = explode('@', $email);
                                            if (count($parts) === 2) {
                                                $display_email = $parts[0] . '@' . idn_to_utf8($parts[1], IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
                                            }
                                        }
                                        echo esc_html($display_email);
                                    ?>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($address): ?>
                        <div class="info-item">
                            <div class="info-icon">
                                <?php echo wohnegruen_get_icon('location'); ?>
                            </div>
                            <div class="info-content">
                                <h4>Adresse</h4>
                                <p><?php echo nl2br(esc_html($address)); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($hours): ?>
                        <div class="info-item">
                            <div class="info-icon">
                                <?php echo wohnegruen_get_icon('clock'); ?>
                            </div>
                            <div class="info-content">
                                <h4>Öffnungszeiten</h4>
                                <p><?php echo nl2br(esc_html($hours)); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Map Section -->
    <?php if ($map_enabled && $map_embed): ?>
    <section class="contact-map">
        <div class="map-container">
            <?php echo $map_embed; // Google Maps iframe embed ?>
        </div>
    </section>
    <?php endif; ?>

</div>

<style>
/* Contact Complete Styles */
.contact-complete-page {
    width: 100%;
}

.contact-hero {
    min-height: var(--hero-min-height);
}

.section-padding {
    padding: 60px 0;
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 var(--spacing-lg);
}

/* Hero */
.contact-hero {
    min-height: var(--hero-min-height);
    display: flex;
    align-items: center;
    background-size: cover;
    background-position: center;
    position: relative;
    padding: var(--spacing-3xl) 0;
}

.contact-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(44, 140, 79, 0.5);
}

.hero-content.text-center {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.hero-content h1 {
    font-size: var(--hero-title-size);
    color: var(--color-white);
    margin-bottom: var(--spacing-lg);
}

.hero-subtitle {
    font-size: var(--font-size-xl);
    color: var(--color-white);
}

/* Contact Grid */
.contact-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: var(--spacing-3xl);
}

/* Form */
.form-header {
    margin-bottom: var(--spacing-2xl);
}

.form-header h2 {
    font-size: var(--font-size-2xl);
    color: var(--color-primary);
    margin-bottom: var(--spacing-md);
}

.form-header p {
    color: var(--color-text-secondary);
}

.contact-form {
    background: var(--color-white);
    padding: var(--spacing-2xl);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-card);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-lg);
    margin-bottom: var(--spacing-lg);
}

.form-group {
    margin-bottom: var(--spacing-lg);
}

.form-group label {
    display: block;
    margin-bottom: var(--spacing-sm);
    font-weight: 600;
    color: var(--color-text-primary);
}

.form-message {
    padding: var(--spacing-md);
    border-radius: var(--radius-md);
    margin-bottom: var(--spacing-lg);
    font-weight: 500;
}

.form-message.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.form-message.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: var(--spacing-md);
    border: 2px solid var(--color-border);
    border-radius: var(--radius-md);
    font-family: inherit;
    font-size: var(--font-size-md);
    transition: var(--transition);
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--color-primary);
}

.form-group input.error,
.form-group textarea.error {
    border-color: #dc3545;
    background-color: #fff5f5;
}

.form-group input.success,
.form-group textarea.success {
    border-color: #28a745;
}

.field-error {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
    font-weight: 600;
}

.form-group textarea {
    resize: vertical;
}

/* Button styles inherited from global style.css */

/* Contact Info */
.contact-info-wrapper {
    background: var(--color-background);
    padding: var(--spacing-2xl);
    border-radius: var(--radius-lg);
}

.contact-info-wrapper h3 {
    font-size: var(--font-size-xl);
    color: var(--color-primary);
    margin-bottom: var(--spacing-2xl);
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-xl);
}

.info-item {
    display: flex;
    gap: var(--spacing-md);
}

.info-icon {
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    color: var(--color-primary);
}

.info-icon svg {
    width: 100%;
    height: 100%;
}

.info-content h4 {
    color: var(--color-primary);
    font-size: var(--font-size-md);
    margin-bottom: var(--spacing-sm);
}

.info-content p,
.info-content a {
    color: var(--color-text-secondary);
    line-height: 1.6;
}

.info-content a {
    text-decoration: none;
    transition: var(--transition);
}

.info-content a:hover {
    color: var(--color-primary);
}

/* Map */
.contact-map {
    width: 100%;
}

.map-container {
    width: 100%;
    height: 450px;
}

.map-container iframe {
    width: 100%;
    height: 100%;
    border: 0;
}

/* Responsive */
@media (max-width: 767px) {
    .container {
        padding: 0 var(--spacing-md);
    }

    .contact-grid {
        grid-template-columns: 1fr;
    }

    .section-padding {
        padding: var(--spacing-2xl) 0;
    }

    .hero-content h1 {
        font-size: var(--hero-title-size-mobile);
    }

    .contact-form {
        padding: var(--spacing-lg);
    }

    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    if (!form) return;

    // Validation functions
    function showFieldError(field, message) {
        field.classList.add('error');
        field.classList.remove('success');

        // Remove existing error message
        const existingError = field.parentElement.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }

        // Add new error message
        const errorDiv = document.createElement('span');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        field.parentElement.appendChild(errorDiv);
    }

    function clearFieldError(field) {
        field.classList.remove('error');
        const errorDiv = field.parentElement.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    function validateField(field) {
        const value = field.value.trim();
        let isValid = true;

        // Check if required field is empty
        if (field.hasAttribute('required')) {
            if (!value) {
                showFieldError(field, 'Dieses Feld ist erforderlich');
                return false;
            }
        }

        // Email validation (only if field has value OR is required email field)
        if (field.type === 'email') {
            if (value) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(value)) {
                    showFieldError(field, 'Bitte geben Sie eine gültige E-Mail-Adresse ein');
                    return false;
                }
            } else if (field.hasAttribute('required')) {
                showFieldError(field, 'Bitte geben Sie eine gültige E-Mail-Adresse ein');
                return false;
            }
        }

        // Textarea minimum length (only check if required and has some text)
        if (field.tagName === 'TEXTAREA' && field.hasAttribute('required')) {
            if (value && value.length < 10) {
                showFieldError(field, 'Bitte geben Sie mindestens 10 Zeichen ein');
                return false;
            }
        }

        // If we got here, field is valid
        clearFieldError(field);
        if (value) {
            field.classList.add('success');
        }
        return true;
    }

    function validateForm() {
        const fields = form.querySelectorAll('input[required], textarea[required], input[type="email"]');
        let isValid = true;

        fields.forEach(field => {
            if (!validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    // Add blur validation
    form.querySelectorAll('input, textarea').forEach(field => {
        field.addEventListener('blur', function() {
            if (this.value.trim()) {
                validateField(this);
            }
        });

        field.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                validateField(this);
            }
        });
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        console.log('Form submit triggered');

        // Clear all previous errors
        form.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
        form.querySelectorAll('.field-error').forEach(el => el.remove());

        // Validate form before submitting
        const isFormValid = validateForm();
        console.log('Form valid:', isFormValid);

        if (!isFormValid) {
            // Scroll to first error
            const firstError = form.querySelector('.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
            return;
        }

        const submitBtn = document.getElementById('submit-btn');
        const messageDiv = document.getElementById('form-message');
        const formData = new FormData(form);

        // Add AJAX action
        formData.append('action', 'wohnegruen_contact_form');
        formData.append('nonce', '<?php echo wp_create_nonce('wohnegruen_contact_form'); ?>');

        // Disable button
        submitBtn.disabled = true;
        submitBtn.textContent = 'Wird gesendet...';

        // Send AJAX request
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            messageDiv.style.display = 'block';

            if (data.success) {
                messageDiv.className = 'form-message success';
                messageDiv.textContent = data.data.message;
                form.reset();
            } else {
                messageDiv.className = 'form-message error';
                messageDiv.textContent = data.data.message || 'Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.';
            }

            // Re-enable button
            submitBtn.disabled = false;
            submitBtn.textContent = 'Nachricht senden';

            // Scroll to message
            messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        })
        .catch(error => {
            messageDiv.style.display = 'block';
            messageDiv.className = 'form-message error';
            messageDiv.textContent = 'Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.';

            submitBtn.disabled = false;
            submitBtn.textContent = 'Nachricht senden';
        });
    });
});
</script>
