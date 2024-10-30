// Dans mon_script.js
jQuery(document).ready(function($) {
    $('#mon_bouton').on('click', function() {
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'mon_action',
                security: ajax_object.nonce,  // Ajout du nonce pour sécuriser la requête
                autres_donnees: 'valeur'
            },
            success: function(response) {
                console.log('Succès : ', response);
            },
            error: function(error) {
                console.log('Erreur : ', error);
            }
        });
    });
});
