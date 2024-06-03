function toggleComments() {
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.toggle-comments-btn');
        console.log('Total buttons:', toggleButtons.length); // Check if buttons are found

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                console.log('Button clicked'); // Check if this logs when you click the button
                const postId = this.getAttribute('data-post-id');
                const commentsContainer = document.getElementById(`comments_${postId}`);
                const upArrow = this.getAttribute('data-up-arrow');
                const downArrow = this.getAttribute('data-down-arrow');

                if (commentsContainer) {
                    if (commentsContainer.style.display === 'none' || commentsContainer.style.display === '') {
                        // Show comments
                        commentsContainer.style.display = 'block';
                        commentsContainer.style.maxHeight = commentsContainer.scrollHeight + 'px';
                        this.innerHTML = `<img src="${upArrow}" alt=""> Masquer les commentaires <img src="${upArrow}" alt="">`;
                    } else {
                        // Hide comments with animation
                        commentsContainer.style.maxHeight = '0';
                        setTimeout(() => {
                            commentsContainer.style.display = 'none';
                        }, 300); // Duration of the animation should match CSS transition duration
                        this.innerHTML = `<img src="${downArrow}" alt=""> Afficher les commentaires <img src="${downArrow}" alt="">`;
                    }
                } else {
                    console.log('Comments container not found for post id:', postId);
                }
            });
        });
    });
}

export default toggleComments;
