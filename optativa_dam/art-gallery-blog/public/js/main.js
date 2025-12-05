async function toggleLike(postId, btn) {
    try {
        const response = await fetch('/api/like', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ post_id: postId })
        });
        const data = await response.json();

        if (data.success) {
            btn.innerHTML = data.liked ? '❤️' : '🤍';
            btn.classList.toggle('liked', data.liked);
            document.getElementById('likes-count-' + postId).innerText = data.count + ' Me gusta';
        }
    } catch (e) { console.error(e); }
}

async function postComment(e, postId) {
    e.preventDefault();
    const input = document.getElementById('input-' + postId);
    const text = input.value.trim();

    if (!text) return;

    try {
        const response = await fetch('/api/comment', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ post_id: postId, text: text })
        });
        const data = await response.json();

        if (data.success) {
            const list = document.getElementById('comments-' + postId);
            const div = document.createElement('div');
            div.className = 'comment';
            div.innerHTML = `<span class="comment-user">${data.username}</span> ${data.text}`;
            list.appendChild(div);
            input.value = '';
        }
    } catch (e) { console.error(e); }
}

async function deletePost(postId) {
    if (!confirm("¿Borrar publicación?")) return;

    try {
        const response = await fetch('/api/post/delete', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ post_id: postId })
        });
        const data = await response.json();
        if (data.success) {
            const el = document.getElementById('post-' + postId);
            if (el) el.remove();
            else window.location.reload(); // If on profile
        } else {
            alert("Error al borrar");
        }
    } catch (e) { console.error(e); }
}

function focusComment(id) {
    document.getElementById('input-' + id).focus();
}
