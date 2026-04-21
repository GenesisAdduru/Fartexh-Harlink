// Recipient Community Page Handler

document.addEventListener('DOMContentLoaded', () => {
    const currentUser = {
        name: window.User?.name || 'User',
        id: window.User?.id || null,
        role: window.User?.role || 'user'
    };

    // Global state for images
    let pendingPostImage = null;

    // Render posts feed
    async function renderPosts() {
        const feedContainer = document.getElementById('posts-feed');
        if (!feedContainer) return;

        feedContainer.innerHTML = '<div class="loading-state"><p>Loading community posts...</p></div>';

        try {
            const posts = await CommunityModule.getPosts();
            feedContainer.innerHTML = '';

            if (posts.length === 0) {
                feedContainer.innerHTML = '<div class="empty-state"><p>No posts yet. Be the first to share!</p></div>';
                return;
            }

            posts.forEach(post => {
                const postElement = createPostElement(post, currentUser);
                feedContainer.appendChild(postElement);
            });
        } catch (error) {
            console.error('Error rendering posts:', error);
            feedContainer.innerHTML = '<div class="error-state"><p>Failed to load posts. Please try again later.</p></div>';
        }
    }

    // Create post element
    function createPostElement(post, currentUser) {
        const postDiv = document.createElement('div');
        postDiv.className = 'community-post';
        postDiv.dataset.postId = post.id;

        const userBadge = post.userType === 'donor' 
            ? '<span class="user-badge donor-badge">Donor</span>'
            : '<span class="user-badge recipient-badge">Recipient</span>';

        const isAuthor = post.user_id == currentUser.id;
        const deleteBtn = isAuthor ? `
            <button class="delete-post-btn" data-post-id="${post.id}" title="Delete Post">
                <i class='bx bx-trash'></i>
            </button>
        ` : '';

        const postImage = post.image ? `
            <div class="post-image">
                <img src="${post.image}" alt="Post image" onclick="window.open(this.src, '_blank')">
            </div>
        ` : '';

        postDiv.innerHTML = `
            <div class="post-header">
                <div class="post-author">
                    <div class="avatar">${post.avatar}</div>
                    <div class="author-info">
                        <div class="author-name">${post.author}</div>
                        <div class="post-time">${CommunityModule.formatTime(post.timestamp)}</div>
                    </div>
                </div>
                <div class="post-actions">
                    ${userBadge}
                    ${deleteBtn}
                </div>
            </div>

            <div class="post-content">
                ${post.content}
            </div>

            ${postImage}

            <div class="post-stats">
                <span class="likes-count"><i class='bx bxs-heart'></i> <span class="count">${post.likes}</span></span>
                <span class="comments-count"><i class='bx bxs-comment'></i> ${countAllComments(post.comments)}</span>
            </div>

            <div class="post-interactions">
                <button class="like-btn ${post.is_liked ? 'active' : ''}" data-post-id="${post.id}">
                    <i class='bx ${post.is_liked ? 'bxs-heart' : 'bx-heart'}'></i>
                    ${post.is_liked ? 'Liked' : 'Like'}
                </button>
                <button class="comment-toggle-btn" data-post-id="${post.id}">
                    <i class='bx bx-comment'></i>
                    Comment
                </button>
            </div>

            <div class="comments-section" style="display: none;">
                <div class="comments-list"></div>
                <div class="comment-form-container">
                    <div class="comment-form">
                        <input type="text" class="comment-input" placeholder="Write a comment..." data-post-id="${post.id}">
                        
                        <label class="comment-image-label" title="Attach Image">
                            <i class='bx bx-image-add'></i>
                            <input type="file" class="comment-image-input" accept="image/*" style="display: none;">
                        </label>
                        
                        <button class="submit-comment-btn" data-post-id="${post.id}">Post</button>
                    </div>
                    <div class="comment-image-preview"></div>
                </div>
            </div>
        `;

        attachPostEventListeners(postDiv, post);
        return postDiv;
    }

    function countAllComments(comments) {
        let count = comments.length;
        comments.forEach(c => {
            if (c.replies) count += c.replies.length;
        });
        return count;
    }

    function attachPostEventListeners(postElement, post) {
        const postId = post.id;

        // Like button
        postElement.querySelector('.like-btn')?.addEventListener('click', async (e) => {
            const btn = e.currentTarget;
            try {
                const data = await CommunityModule.toggleLike(postId);
                const likesCount = postElement.querySelector('.likes-count .count');
                if (likesCount) likesCount.textContent = data.likes;
                
                if (data.is_liked) {
                    btn.classList.add('active');
                    btn.innerHTML = `<i class='bx bxs-heart'></i> Liked`;
                } else {
                    btn.classList.remove('active');
                    btn.innerHTML = `<i class='bx bx-heart'></i> Like`;
                }
            } catch (error) {
                console.error('Error liking post:', error);
            }
        });

        // Delete Post
        postElement.querySelector('.delete-post-btn')?.addEventListener('click', async () => {
            if (confirm('Are you sure you want to delete this post?')) {
                try {
                    await CommunityModule.deletePost(postId);
                    postElement.remove();
                } catch (error) {
                    alert('Failed to delete post.');
                }
            }
        });

        // Comment toggle
        postElement.querySelector('.comment-toggle-btn')?.addEventListener('click', (e) => {
            const section = postElement.querySelector('.comments-section');
            const isVisible = section.style.display === 'flex';
            section.style.display = isVisible ? 'none' : 'flex';
            
            if (!isVisible) {
                renderComments(post.comments, postElement.querySelector('.comments-list'), postId);
                postElement.querySelector('.comment-input')?.focus();
            }
        });

        // Comment image handling
        const commentImgInput = postElement.querySelector('.comment-image-input');
        const commentPreview = postElement.querySelector('.comment-image-preview');
        let pendingCommentImage = null;

        commentImgInput?.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                pendingCommentImage = file;
                const reader = new FileReader();
                reader.onload = (re) => {
                    commentPreview.innerHTML = `
                        <div class="preview-item">
                            <img src="${re.target.result}">
                            <div class="remove-preview">&times;</div>
                        </div>
                    `;
                    commentPreview.querySelector('.remove-preview').onclick = () => {
                        pendingCommentImage = null;
                        commentPreview.innerHTML = '';
                        commentImgInput.value = '';
                    };
                };
                reader.readAsDataURL(file);
            }
        });

        // Submit comment
        postElement.querySelector('.submit-comment-btn')?.addEventListener('click', async (e) => {
            const input = postElement.querySelector('.comment-input');
            const content = input.value.trim();
            const parentId = input.dataset.parentId || null;
            
            if (content || pendingCommentImage) {
                try {
                    const newComment = await CommunityModule.addComment(postId, content, parentId, pendingCommentImage);
                    
                    if (parentId) {
                        const parent = post.comments.find(c => c.id === parentId);
                        if (parent) {
                            if (!parent.replies) parent.replies = [];
                            parent.replies.push(newComment);
                        }
                    } else {
                        post.comments.push(newComment);
                    }

                    renderComments(post.comments, postElement.querySelector('.comments-list'), postId);
                    
                    // Reset
                    input.value = '';
                    input.placeholder = "Write a comment...";
                    delete input.dataset.parentId;
                    pendingCommentImage = null;
                    commentPreview.innerHTML = '';
                    
                    const commentCount = postElement.querySelector('.comments-count');
                    if (commentCount) {
                        commentCount.innerHTML = `<i class='bx bxs-comment'></i> ${countAllComments(post.comments)}`;
                    }
                } catch (error) {
                    console.error('Error adding comment:', error);
                }
            }
        });
    }

    function renderComments(comments, container, postId) {
        container.innerHTML = '';

        if (!comments || comments.length === 0) {
            container.innerHTML = '<div class="no-comments"><p>No comments yet.</p></div>';
            return;
        }

        comments.forEach(comment => {
            const commentDiv = createCommentElement(comment, postId);
            container.appendChild(commentDiv);

            // Render replies
            if (comment.replies && comment.replies.length > 0) {
                const repliesList = document.createElement('div');
                repliesList.className = 'replies-list';
                comment.replies.forEach(reply => {
                    repliesList.appendChild(createCommentElement(reply, postId, true));
                });
                container.appendChild(repliesList);
            }
        });
    }

    function createCommentElement(comment, postId, isReply = false) {
        const commentDiv = document.createElement('div');
        commentDiv.className = isReply ? 'comment reply' : 'comment';

        const userBadge = comment.userType === 'donor'
            ? '<span class="comment-badge donor-badge">Donor</span>'
            : '<span class="comment-badge recipient-badge">Recipient</span>';

        const commentImage = comment.image ? `
            <div class="comment-image">
                <img src="${comment.image}" alt="Comment image" onclick="window.open(this.src, '_blank')">
            </div>
        ` : '';

        const isAuthor = comment.user_id == currentUser.id;
        const deleteBtn = isAuthor ? `
            <button class="delete-comment-btn" data-comment-id="${comment.id}" title="Delete Comment">
                <i class='bx bx-trash'></i>
            </button>
        ` : '';

        const replyBtn = !isReply ? `
            <button class="reply-btn" data-comment-id="${comment.id}" data-author="${comment.author}">
                <i class='bx bx-reply'></i> Reply
            </button>
        ` : '';

        commentDiv.innerHTML = `
            <div class="comment-header">
                <div class="comment-author">
                    <span class="comment-avatar">${comment.avatar}</span>
                    <div>
                        <div class="comment-name">${comment.author}</div>
                        <div class="comment-time">${CommunityModule.formatTime(comment.timestamp)}</div>
                    </div>
                </div>
                <div class="comment-menu">
                    ${userBadge}
                    ${deleteBtn}
                </div>
            </div>
            <div class="comment-content">${comment.content}</div>
            ${commentImage}
            <div class="comment-actions">
                ${replyBtn}
            </div>
        `;

        // Delete comment
        commentDiv.querySelector('.delete-comment-btn')?.addEventListener('click', async () => {
            if (confirm('Delete this comment?')) {
                try {
                    await CommunityModule.deleteComment(comment.id);
                    commentDiv.remove();
                } catch (error) {
                    alert('Failed to delete.');
                }
            }
        });

        // Reply button
        commentDiv.querySelector('.reply-btn')?.addEventListener('click', () => {
            const postEl = commentDiv.closest('.community-post');
            const input = postEl.querySelector('.comment-input');
            input.dataset.parentId = comment.id;
            input.placeholder = `Replying to ${comment.author}...`;
            input.focus();
        });

        return commentDiv;
    }

    // Handle post image selection
    const postImageInput = document.getElementById('post-image');
    const imagePreview = document.getElementById('image-preview');

    postImageInput?.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            pendingPostImage = file;
            const reader = new FileReader();
            reader.onload = (re) => {
                imagePreview.innerHTML = `
                    <div class="preview-item">
                        <img src="${re.target.result}">
                        <div class="remove-preview">&times;</div>
                    </div>
                `;
                imagePreview.querySelector('.remove-preview').onclick = () => {
                    pendingPostImage = null;
                    imagePreview.innerHTML = '';
                    postImageInput.value = '';
                };
            };
            reader.readAsDataURL(file);
        }
    });

    // Create post form handler
    const postForm = document.getElementById('create-post-form');
    if (postForm) {
        postForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const textarea = postForm.querySelector('textarea');
            const content = textarea.value.trim();
            const submitBtn = postForm.querySelector('button[type="submit"]');

            if (content || pendingPostImage) {
                if (submitBtn) submitBtn.disabled = true;
                try {
                    await CommunityModule.createPost(content, pendingPostImage);
                    textarea.value = '';
                    pendingPostImage = null;
                    if (imagePreview) imagePreview.innerHTML = '';
                    if (postImageInput) postImageInput.value = '';
                    await renderPosts();
                } catch (error) {
                    console.error('Error creating post:', error);
                    alert('Failed to share post.');
                } finally {
                    if (submitBtn) submitBtn.disabled = false;
                }
            }
        });
    }

    // Initial render
    renderPosts();
});
