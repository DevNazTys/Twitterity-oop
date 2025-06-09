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

    // Clearing the text field before opening
    textarea.value = '';

    // Showing a modal window
    EditModal.style.display = 'flex';
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

























