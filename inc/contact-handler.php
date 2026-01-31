<?php
/**
 * Contact Form Handler
 */

if (!defined('ABSPATH')) exit;

/**
 * Handle contact form submission via AJAX
 */
function wohnegruen_handle_contact_form() {
    // Verify nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'wohnegruen_contact_form')) {
        wp_send_json_error(array('message' => 'Sicherheitsprüfung fehlgeschlagen.'));
        return;
    }

    // Sanitize and validate input
    $vorname = sanitize_text_field($_POST['vorname'] ?? '');
    $nachname = sanitize_text_field($_POST['nachname'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $betreff = sanitize_text_field($_POST['betreff'] ?? '');
    $nachricht = sanitize_textarea_field($_POST['nachricht'] ?? '');

    // Validation
    $errors = array();

    if (empty($vorname)) {
        $errors[] = 'Vorname ist erforderlich.';
    }

    if (empty($nachname)) {
        $errors[] = 'Nachname ist erforderlich.';
    }

    if (empty($email) || !is_email($email)) {
        $errors[] = 'Gültige E-Mail-Adresse ist erforderlich.';
    }

    if (empty($betreff)) {
        $errors[] = 'Betreff ist erforderlich.';
    }

    if (empty($nachricht)) {
        $errors[] = 'Nachricht ist erforderlich.';
    }

    if (!empty($errors)) {
        wp_send_json_error(array('message' => implode(' ', $errors)));
        return;
    }

    // Prepare email
    // Use ACF contact email option, fallback to info@wohnegrün.at
    $to = function_exists('get_field') ? get_field('contact_email', 'option') : '';
    if (empty($to)) {
        $to = 'info@wohnegrün.at';
    }

    $full_name = trim($vorname . ' ' . $nachname);
    $email_subject = 'WohneGrün Kontaktformular: ' . $betreff;

    // Email body
    $email_body = "Neue Kontaktanfrage von der WohneGrün Website\n\n";
    $email_body .= "Vorname: " . $vorname . "\n";
    $email_body .= "Nachname: " . $nachname . "\n";
    $email_body .= "E-Mail: " . $email . "\n";
    $email_body .= "Telefon: " . ($phone ? $phone : 'Nicht angegeben') . "\n";
    $email_body .= "Betreff: " . $betreff . "\n\n";
    $email_body .= "Nachricht:\n" . $nachricht . "\n\n";
    $email_body .= "---\n";
    $email_body .= "Diese Nachricht wurde über das Kontaktformular auf " . home_url() . " gesendet.";

    // Email headers
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: WohneGrün Website <noreply@wohnegruen.at>',
        'Reply-To: ' . $full_name . ' <' . $email . '>'
    );

    // Log attempt for debugging
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('WohneGruen Contact Form: Attempting to send email to ' . $to);
        error_log('From: ' . $vorname . ' ' . $nachname . ' <' . $email . '>');
    }

    // Send email
    $sent = wp_mail($to, $email_subject, $email_body, $headers);

    if ($sent) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('WohneGruen Contact Form: Email sent successfully');
        }
        wp_send_json_success(array(
            'message' => 'Vielen Dank! Ihre Nachricht wurde erfolgreich gesendet. Wir werden uns in Kürze bei Ihnen melden.'
        ));
    } else {
        // Log error for debugging
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('WohneGruen Contact Form: Email failed to send to ' . $to);
            error_log('Last error: ' . print_r(error_get_last(), true));
        }
        wp_send_json_error(array(
            'message' => 'Es gab ein Problem beim Senden Ihrer Nachricht. Bitte versuchen Sie es später erneut oder kontaktieren Sie uns telefonisch.'
        ));
    }
}
add_action('wp_ajax_wohnegruen_contact_form', 'wohnegruen_handle_contact_form');
add_action('wp_ajax_nopriv_wohnegruen_contact_form', 'wohnegruen_handle_contact_form');

/**
 * Add contact form nonce to footer
 */
function wohnegruen_add_contact_nonce() {
    if (is_page_template('page-contact.php')) {
        ?>
        <script>
        var wohnegruenContact = {
            ajaxUrl: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
            nonce: '<?php echo esc_attr(wp_create_nonce('wohnegruen_contact_form')); ?>'
        };
        </script>
        <?php
    }
}
add_action('wp_footer', 'wohnegruen_add_contact_nonce');
