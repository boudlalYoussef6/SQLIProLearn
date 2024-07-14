document.addEventListener('DOMContentLoaded', function () {
    const toggleButtons = document.querySelectorAll('.btn-toggle-favorite');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function () {
            const courseId = this.getAttribute('data-course-id');
            const isFavorite = this.hasAttribute('data-is-favorite');
            const toggleUrl = isFavorite ?
                this.getAttribute('data-remove-url') :
                this.getAttribute('data-toggle-url');

            const favoriteOn = this.getAttribute('data-favorite-on'), favoriteOff = this.getAttribute('data-favorite-off')

            fetch(toggleUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (isFavorite) {
                            toastr.success('Cours retiré des favoris')
                            this.removeAttribute('data-is-favorite');
                            this.innerHTML = '<i class="fa-regular fa-star  not-favorite"></i> ' + favoriteOff;
                        } else {
                            toastr.success('Cours ajouté aux favoris')
                            this.setAttribute('data-is-favorite', 'true');
                            this.innerHTML = '<i class="fa-solid fa-star favorite"></i> ' + favoriteOn;
                        }

                        // Afficher un toast de succès
                        const toastClass = isFavorite ? 'bg-danger' : 'bg-success';
                        /*$(document).Toasts('create', {
                            class: toastClass,
                            title: 'Favoris mis à jour',
                            body: data.message
                        });*/
                    } else {
                        // Afficher un toast d'erreur en rouge
                        /*$(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'Erreur',
                            body: data.message
                        });*/
                    }

                    /*if (isFavorite) {
                        toastr.success('Cours ajouté aux favoris')
                    } else {
                        toastr.success('Cours retiré des favoris')
                    }*/
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Afficher un toast d'erreur réseau en rouge
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Erreur',
                        body: 'Une erreur réseau est survenue. Veuillez vérifier votre connexion Internet.'
                    });
                });
        });
    });
});
