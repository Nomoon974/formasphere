document.addEventListener('DOMContentLoaded', function() {
    function toggleComments() {
        const toggleButtons = document.querySelectorAll('.toggle-comments-btn');
        console.log('Total buttons:', toggleButtons.length); // Check if buttons are found

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                console.log('Button clicked'); // Check if this logs when you click the button
                const postId = this.getAttribute('data-post-id');
                const commentSection = document.querySelector(`#comment-section-${postId}`);
                const commentsContainer = document.getElementById(`comments_${postId}`);
                const isExpanded = this.getAttribute('aria-expanded') === 'true';

                if (!commentsContainer) {
                    console.log('Comments container not found for post id:', postId);
                    return;
                }

                console.log('Post ID:', postId);
                console.log('Comments container:', commentsContainer);
                console.log('Initial display style:', commentsContainer.style.display);
                console.log('Initial maxHeight:', commentsContainer.style.maxHeight);

                if (isExpanded) {
                    // Hide comments with animation
                    commentsContainer.style.maxHeight = '0px';
                    console.log('Updated maxHeight (hide):', commentsContainer.style.maxHeight);
                    setTimeout(() => {
                        commentsContainer.style.display = 'none';
                        commentSection.style.paddingBottom = '0';
                        console.log('Updated display style (hide):', commentsContainer.style.display);
                    }, 300); // Duration of the animation should match CSS transition duration
                    this.innerHTML = '↓ Afficher les commentaires ↓';
                    this.setAttribute('aria-expanded', 'false');
                } else {
                    // Show comments
                    commentsContainer.style.display = 'block';
                    setTimeout(() => {
                        commentsContainer.style.maxHeight = commentsContainer.scrollHeight + 'px';
                        commentSection.style.paddingBottom = '12px';
                    }, 10);
                    console.log('Updated maxHeight (show):', commentsContainer.style.maxHeight);
                    this.innerHTML = '↑ Masquer les commentaires ↑';
                    this.setAttribute('aria-expanded', 'true');
                }
            });
        });
    }

    toggleComments();
});
