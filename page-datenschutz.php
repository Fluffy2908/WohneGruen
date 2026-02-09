<?php
/**
 * Template Name: Datenschutz
 * Privacy policy page template
 */

get_header();

// Get featured image or use fallback
$hero_image_url = '';
$featured_image_id = get_post_thumbnail_id();
if ($featured_image_id) {
    $featured_image = wp_get_attachment_image_src($featured_image_id, 'full');
    if ($featured_image) {
        $hero_image_url = esc_url($featured_image[0]);
    }
}

// Fallback to default image if no featured image is set
if (empty($hero_image_url)) {
    $hero_image_url = get_template_directory_uri() . '/assets/images/wohnegruen-mobilhaus-exterior-3.jpg';
}
?>

<!-- Privacy Hero Section -->
<section id="main-content" class="hero-section hero-small">
    <div class="hero-background">
        <img src="<?php echo esc_url($hero_image_url); ?>" alt="WohneGruen Datenschutz" loading="eager">
        <div class="hero-overlay"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <h1 class="animate-slide-up">Datenschutzerklärung</h1>
            <p class="hero-text animate-slide-up">Informationen gemäß DSGVO</p>
        </div>
    </div>
</section>

<style>
.hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(44, 140, 79, 0.5);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-content h1 {
    color: #ffffff;
}

.hero-text {
    color: #ffffff;
}
</style>

<!-- Privacy Content Section -->
<section class="legal-section section-padding">
    <div class="container">
        <div class="legal-content">
            <h2>Datenschutzerklärung</h2>

            <h3>1. Datenschutz auf einen Blick</h3>

            <h4>Allgemeine Hinweise</h4>
            <p>
                Die folgenden Hinweise geben einen einfachen Überblick darüber, was mit Ihren personenbezogenen Daten passiert, wenn Sie diese Website besuchen. Personenbezogene Daten sind alle Daten, mit denen Sie persönlich identifiziert werden können.
            </p>

            <h4>Datenerfassung auf dieser Website</h4>
            <p><strong>Wer ist verantwortlich für die Datenerfassung auf dieser Website?</strong></p>
            <p>
                Die Datenverarbeitung auf dieser Website erfolgt durch den Websitebetreiber. Dessen Kontaktdaten können Sie dem Impressum dieser Website entnehmen.
            </p>

            <h3>2. Hosting</h3>
            <p>
                Wir hosten die Inhalte unserer Website bei folgendem Anbieter: [Hosting-Anbieter einfügen]
            </p>

            <h3>3. Allgemeine Hinweise und Pflichtinformationen</h3>

            <h4>Datenschutz</h4>
            <p>
                Die Betreiber dieser Seiten nehmen den Schutz Ihrer persönlichen Daten sehr ernst. Wir behandeln Ihre personenbezogenen Daten vertraulich und entsprechend den gesetzlichen Datenschutzvorschriften sowie dieser Datenschutzerklärung.
            </p>

            <h4>Hinweis zur verantwortlichen Stelle</h4>
            <p>
                Die verantwortliche Stelle für die Datenverarbeitung auf dieser Website ist:
            </p>
            <p>
                <strong><?php echo esc_html(get_field('datenschutz_controller_name')); ?></strong><br>
                <?php echo nl2br(esc_html(get_field('datenschutz_controller_address'))); ?>
            </p>
            <p>
                Telefon: <?php echo esc_html(get_field('datenschutz_controller_phone')); ?><br>
                E-Mail: <a href="mailto:<?php echo esc_attr(get_field('datenschutz_controller_email')); ?>"><?php echo esc_html(get_field('datenschutz_controller_email')); ?></a>
            </p>

            <?php if (get_field('datenschutz_dpo_name') || get_field('datenschutz_dpo_email')) : ?>
            <h4>Datenschutzbeauftragter</h4>
            <p>
                <?php if (get_field('datenschutz_dpo_name')) : ?>
                    Name: <?php echo esc_html(get_field('datenschutz_dpo_name')); ?><br>
                <?php endif; ?>
                <?php if (get_field('datenschutz_dpo_email')) : ?>
                    E-Mail: <a href="mailto:<?php echo esc_attr(get_field('datenschutz_dpo_email')); ?>"><?php echo esc_html(get_field('datenschutz_dpo_email')); ?></a>
                <?php endif; ?>
            </p>
            <?php endif; ?>

            <h3>4. Datenerfassung auf dieser Website</h3>

            <h4>Kontaktformular</h4>
            <p>
                Wenn Sie uns per Kontaktformular Anfragen zukommen lassen, werden Ihre Angaben aus dem Anfrageformular inklusive der von Ihnen dort angegebenen Kontaktdaten zwecks Bearbeitung der Anfrage und für den Fall von Anschlussfragen bei uns gespeichert. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter.
            </p>

            <h4>Server-Log-Dateien</h4>
            <p>
                Der Provider der Seiten erhebt und speichert automatisch Informationen in so genannten Server-Log-Dateien, die Ihr Browser automatisch an uns übermittelt. Dies sind:
            </p>
            <ul>
                <li>Browsertyp und Browserversion</li>
                <li>Verwendetes Betriebssystem</li>
                <li>Referrer URL</li>
                <li>Hostname des zugreifenden Rechners</li>
                <li>Uhrzeit der Serveranfrage</li>
                <li>IP-Adresse</li>
            </ul>

            <h3>5. Ihre Rechte</h3>
            <p>
                Sie haben jederzeit das Recht:
            </p>
            <ul>
                <li>Auskunft über Ihre bei uns gespeicherten personenbezogenen Daten zu erhalten</li>
                <li>Berichtigung unrichtiger personenbezogener Daten zu verlangen</li>
                <li>Löschung Ihrer bei uns gespeicherten personenbezogenen Daten zu verlangen</li>
                <li>Einschränkung der Datenverarbeitung zu verlangen</li>
                <li>Widerspruch gegen die Verarbeitung zu erheben</li>
                <li>Datenübertragbarkeit zu verlangen</li>
            </ul>

            <h3>6. SSL- bzw. TLS-Verschlüsselung</h3>
            <p>
                Diese Seite nutzt aus Sicherheitsgründen und zum Schutz der Übertragung vertraulicher Inhalte, wie zum Beispiel Bestellungen oder Anfragen, die Sie an uns als Seitenbetreiber senden, eine SSL- bzw. TLS-Verschlüsselung.
            </p>

            <?php if (get_field('datenschutz_custom_content')) : ?>
            <div class="additional-content">
                <?php echo wp_kses_post(get_field('datenschutz_custom_content')); ?>
            </div>
            <?php endif; ?>

            <p class="legal-update">
                <small>Stand dieser Datenschutzerklärung: <?php echo date('d.m.Y'); ?></small>
            </p>
        </div>
    </div>
</section>

<?php get_footer(); ?>
