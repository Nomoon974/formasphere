export default function deletePost() {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            console.log('supprime')
            const postId = this.getAttribute('data-post-id');
            const confirmDelete = confirm('Voulez-vous vraiment supprimer ce post ?');
            if (confirmDelete) {
                document.getElementById(`delete-form-${postId}`).submit();
            }
        });
    });
}
