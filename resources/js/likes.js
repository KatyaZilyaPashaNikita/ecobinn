function likeComment(commentId, isLike) {
    fetch(`/comments/${commentId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ is_like: isLike })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById(`like-count-${commentId}`).textContent = data.like_count;
        document.getElementById(`dislike-count-${commentId}`).textContent = data.dislike_count;
    })
    .catch(error => {
        console.error('Ошибка:', error);
    });
}
