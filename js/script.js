// creating post
const wcp = document.getElementById('wcp'); //window create post
const createPost = document.getElementById('createPost');
const closeWcpBtn = document.getElementById('closeWcpBtn');

createPost.addEventListener('click', () => {
    wcp.style.display = 'block';
});
closeWcpBtn.addEventListener('click', () => {
    wcp.style.display = 'none';
});
window.addEventListener('click', (event) => { // Closing a modal window when clicking outside it
    if (event.target === wcp) {
        wcp.style.display = 'none';
    }
});

/************************************************************************/
// post editing

let currentPostId = null; // Зберігає ID поточного поста

function editPost(postId) {
    currentPostId = postId; // Запам'ятовуємо ID поста
    const EditModal = document.getElementById('editPostModal');
    const textarea = document.getElementById('newContent');

    // Show loading state
    textarea.value = 'Loading...';
    EditModal.style.display = 'flex';

    // Fetch current post content
    fetch('/post/get/' + postId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                textarea.value = data.content;
            } else {
                textarea.value = '';
                alert(data.error || 'Error loading post content');
            }
        })
        .catch(error => {
            textarea.value = '';
            alert('Error loading post content');
            console.error('Error:', error);
        });
}

// "Save" button
document.getElementById('saveButton').addEventListener('click', () => {
    const EditModal = document.getElementById('editPostModal');
    const textarea = document.getElementById('newContent');
    const newContent = textarea.value.trim();

    if (newContent !== "") {
        fetch('/post/edit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `post_id=${currentPostId}&content=${encodeURIComponent(newContent)}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    location.reload(); // Оновлюємо сторінку
                } else {
                    alert(data.error || "Сталася помилка");
                }
            });

        // Hiding the modal window
        EditModal.style.display = 'none';
    } else {
        alert("Текст не може бути порожнім!");
    }
});

// "Cancel" button
document.getElementById('cancelButton').addEventListener('click', () => {
    const EditModal = document.getElementById('editPostModal');
    EditModal.style.display = 'none'; // Приховуємо модальне вікно
});

function deletePost(postId) {
    fetch('/post/delete/' + postId, {
        method: 'GET'
    })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                document.getElementById(`post-${postId}`).remove(); // Видалення поста з DOM
            } else {
                alert(data.error || "Сталася помилка");
            }
        });

}

























