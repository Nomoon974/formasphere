function toggleComments() {
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButtons = document.querySelectorAll('.toggle-comments-btn');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function () {
                const postId = this.getAttribute('data-post-id');
                const commentsContainer = document.getElementById(`comments_${postId}`);

                if (commentsContainer.style.display === 'none' || commentsContainer.style.display === '') {
                    commentsContainer.style.display = 'block';
                    this.textContent = `<img src="{{ asset('build/images/up-arrow.a444ac92.png') }}" alt=""> Masquer les commentaires <img src="{{ asset('build/images/up-arrow.a444ac92.png') }}" alt="">`;
                } else {
                    commentsContainer.style.display = 'none';
                    this.textContent = `<img src='{{ asset("build/images/down-arrow.215b1a22.png")' }} alt=""> Afficher les commentaires <img src='{{ asset("build/images/down-arrow.215b1a22.png)' }} alt="">`;
                }
            });
        });
    });
}

export default toggleComments;
