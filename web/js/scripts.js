function confirmDeletion() {
    return confirm('Êtes-vous sûr de vouloir supprimer cette activité ? Cette action est irréversible.');
}

function showSport(sport) {
    // Cacher tous les ensembles de statistiques
    var allStats = document.querySelectorAll('.sport-stats');
    allStats.forEach(function(test) {
        test.style.display = 'none';
    });

    // Afficher uniquement les statistiques du sport sélectionné
    var selectedStats = document.querySelector('.sport-stats.' + sport);
    if (selectedStats) {
        selectedStats.style.display = 'block';
    }
}