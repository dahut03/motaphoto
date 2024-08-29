<?php
// Récupération de la valeur du champ ACF
$photo_reference = get_field('reference', $post->ID);
?>

<div id="modal-5" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <!-- Formulaire de contact -->
        <?php echo do_shortcode('[contact-form-7 id="49a7742" title="Formulaire de contact 1"]'); ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Insérez la référence dans le champ du formulaire lors de l'ouverture de la modale
        var referenceValue = '<?php echo esc_js($photo_reference); ?>';

        // Quand la modale est ouverte, insérer la référence dans le champ
        document.getElementById('open-modal-5').addEventListener('click', function() {
            var refField = document.querySelector('#modal-5 input[name="your-reference-field"]'); // Remplacez 'your-reference-field' par le nom du champ dans le formulaire
            if (refField) {
                refField.value = referenceValue;
            }
        });
    });
</script>

