<?php
/**
 * Template Name: AGB
 * Terms and conditions page template
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
    $hero_image_url = get_template_directory_uri() . '/assets/images/wohnegruen-mobilhaus-exterior-4.jpg';
}
?>

<!-- AGB Hero Section -->
<section id="main-content" class="hero-section hero-small">
    <div class="hero-background">
        <img src="<?php echo esc_url($hero_image_url); ?>" alt="WohneGruen AGB" loading="eager">
        <div class="hero-overlay"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <h1 class="animate-slide-up">Allgemeine Geschäftsbedingungen</h1>
            <p class="hero-text animate-slide-up">Rechtliche Grundlagen für unsere Leistungen</p>
        </div>
    </div>
</section>

<!-- AGB Content Section -->
<section class="legal-section section-padding">
    <div class="container">
        <div class="legal-content">
            <h2>Allgemeine Geschäftsbedingungen (AGB)</h2>

            <?php if (get_field('agb_custom_content')) : ?>
                <?php echo wp_kses_post(get_field('agb_custom_content')); ?>
            <?php else : ?>
            <h3>§ 1 Geltungsbereich</h3>
            <p>
                Diese Allgemeinen Geschäftsbedingungen gelten für alle Verträge zwischen <?php echo esc_html(get_field('agb_company_name')); ?> (nachfolgend "Anbieter") und dem Kunden über die Lieferung und Montage von Mobilhäusern.
            </p>
            <?php endif; ?>

            <h3>§ 2 Vertragsschluss</h3>
            <p>
                Der Vertrag kommt durch die schriftliche Auftragsbestätigung des Anbieters zustande. Angebote sind freibleibend und unverbindlich, sofern nicht ausdrücklich als verbindlich gekennzeichnet.
            </p>

            <h3>§ 3 Preise und Zahlung</h3>
            <p>
                Alle Preise verstehen sich inklusive der gesetzlichen Mehrwertsteuer, sofern nicht anders angegeben. Der Gesamtpreis ergibt sich aus dem individuellen Angebot.
            </p>
            <p><strong>Zahlungsbedingungen:</strong></p>
            <ul>
                <li>30% Anzahlung bei Auftragsbestätigung</li>
                <li>40% bei Produktionsbeginn</li>
                <li>30% bei Lieferung</li>
            </ul>

            <h3>§ 4 Lieferung und Montage</h3>
            <p>
                Die Lieferfristen sind unverbindlich, sofern nicht ausdrücklich als verbindlich zugesagt. Die Lieferung erfolgt innerhalb von 8-12 Wochen nach Auftragsbestätigung, sofern nicht anders vereinbart.
            </p>
            <p>
                Die Montage erfolgt durch Fachpersonal des Anbieters innerhalb von 3-5 Werktagen.
            </p>

            <h3>§ 5 Eigentumsvorbehalt</h3>
            <p>
                Die gelieferte Ware bleibt bis zur vollständigen Bezahlung Eigentum des Anbieters.
            </p>

            <h3>§ 6 Gewährleistung</h3>
            <p>
                Der Anbieter gewährt eine Garantie von 25 Jahren auf die Konstruktion des Mobilhauses gemäß den Garantiebedingungen. Für andere Komponenten gelten die gesetzlichen Gewährleistungsfristen.
            </p>
            <p>
                Mängel sind unverzüglich schriftlich anzuzeigen. Bei berechtigten Mängelrügen erfolgt nach Wahl des Anbieters Nachbesserung oder Ersatzlieferung.
            </p>

            <h3>§ 7 Haftung</h3>
            <p>
                Der Anbieter haftet unbeschränkt für Vorsatz und grobe Fahrlässigkeit. Für leichte Fahrlässigkeit haftet der Anbieter nur bei Verletzung wesentlicher Vertragspflichten.
            </p>

            <h3>§ 8 Widerrufsrecht für Verbraucher</h3>
            <p>
                Verbrauchern steht ein gesetzliches Widerrufsrecht zu. Details zum Widerrufsrecht werden in der Auftragsbestätigung mitgeteilt.
            </p>

            <h3>§ 9 Datenschutz</h3>
            <p>
                Der Anbieter verarbeitet personenbezogene Daten gemäß den geltenden Datenschutzbestimmungen. Nähere Informationen finden Sie in unserer <a href="<?php echo home_url('/datenschutz'); ?>">Datenschutzerklärung</a>.
            </p>

            <h3>§ 10 Schlussbestimmungen</h3>
            <p>
                Sollten einzelne Bestimmungen dieser AGB unwirksam sein oder werden, bleibt die Wirksamkeit der übrigen Bestimmungen davon unberührt.
            </p>
            <p>
                Es gilt österreichisches Recht unter Ausschluss des UN-Kaufrechts. Gerichtsstand ist Graz, Österreich.
            </p>

            <p class="legal-update">
                <strong>Kontakt für Rückfragen:</strong><br>
                <?php echo esc_html(get_field('agb_company_name')); ?><br>
                <?php echo nl2br(esc_html(get_field('agb_address'))); ?><br>
                Telefon: <?php echo esc_html(get_field('agb_phone')); ?><br>
                E-Mail: <a href="mailto:<?php echo esc_attr(get_field('agb_email')); ?>"><?php echo esc_html(get_field('agb_email')); ?></a>
            </p>

            <p class="legal-update">
                <small>Stand dieser AGB: <?php echo date('d.m.Y'); ?></small>
            </p>
        </div>
    </div>
</section>

<?php get_footer(); ?>
