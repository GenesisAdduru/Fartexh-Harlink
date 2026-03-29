// Recipient Community Page Handler

document.addEventListener('DOMContentLoaded', () => {
    const currentUser = JSON.parse(localStorage.getItem('hairlinkUserProfile')) || {
        firstName: 'Recipient',
        lastName: 'User'
    };
    const currentUserType = localStorage.getItem('hairlinkUserType') || 'recipient';

    // Render posts feed
    function renderPosts() {
        const posts = CommunityModule.getPosts();
        const feedContainer = document.getElementById('posts-feed');
        
        if (!feedContainer) return;

        feedContainer.innerHTML = '';

        if (posts.length === 0) {
            feedContainer.innerHTML = '<div class="empty-state"><p>No posts yet. Be the first to share!</p></div>';
            return;
        }

        posts.forEach(post => {
            const postElement = createPostElement(post, currentUser, currentUserType);
            feedContainer.appendChild(postElement);
        });
    }

    // Create post element
    function createPostElement(post, currentUser, currentUserType) {
        const postDiv = document.createElement('div');
        postDiv.className = 'community-post';
        postDiv.dataset.postId = post.id;

        const userBadge = post.userType === 'donor' 
            ? '<span class="user-badge donor-badge">Donor</span>'
            : '<span class="user-badge recipient-badge">Recipient</span>';

        let actionsHTML = '';
        if (currentUser.firstName && currentUser.lastName) {
            const fullName = `${currentUser.firstName} ${currentUser.lastName}`;
            if (post.author === fullName) {
                actionsHTML = `
                    <button class="delete-post-btn" data-post-id="${post.id}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6h16z"></path>
                        </svg>
                    </button>
                `;
            }
        }

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
                    ${actionsHTML}
                </div>
            </div>

            <div class="post-content">
                ${post.content}
            </div>

            <div class="post-stats">
                <span class="likes-count"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg> ${post.likes}</span>
                <span class="comments-count"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg> ${post.comments.length}</span>
            </div>

            <div class="post-interactions">
                <button class="like-btn" data-post-id="${post.id}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    Like
                </button>
                <button class="comment-toggle-btn" data-post-id="${post.id}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    Comment
                </button>
            </div>

            <div class="comments-section" style="display: none;">
                <div class="comments-list"></div>
                <div class="comment-form">
                    <input type="text" class="comment-input" placeholder="Write a comment..." data-post-id="${post.id}">
                    <button class="submit-comment-btn" data-post-id="${post.id}">Post</button>
                </div>
            </div>
        `;

        // Attach event listeners
        attachPostEventListeners(postDiv, post.id, currentUser, currentUserType);

        return postDiv;
    }

    // Attach event listeners to post
    function attachPostEventListeners(postElement, postId, currentUser, currentUserType) {
        // Like button
        postElement.querySelector('.like-btn')?.addEventListener('click', (e) => {
            e.preventDefault();
            CommunityModule.toggleLike(postId);
            renderPosts();
        });

        // Comment toggle
        postElement.querySelector('.comment-toggle-btn')?.addEventListener('click', (e) => {
            e.preventDefault();
            const section = postElement.querySelector('.comments-section');
            section.style.display = section.style.display === 'none' ? 'block' : 'none';
            if (section.style.display === 'block') {
                renderComments(postId, postElement.querySelector('.comments-list'));
                postElement.querySelector('.comment-input')?.focus();
            }
        });

        // Submit comment
        postElement.querySelector('.submit-comment-btn')?.addEventListener('click', (e) => {
            e.preventDefault();
            const input = postElement.querySelector('.comment-input');
            const content = input.value.trim();
            
            if (content && currentUser.firstName && currentUser.lastName) {
                const fullName = `${currentUser.firstName} ${currentUser.lastName}`;
                CommunityModule.addComment(postId, content, fullName, currentUserType);
                input.value = '';
                renderComments(postId, postElement.querySelector('.comments-list'));
            }
        });

        // Delete post
        postElement.querySelector('.delete-post-btn')?.addEventListener('click', (e) => {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this post?')) {
                CommunityModule.deletePost(postId);
                renderPosts();
            }
        });
    }

    // Render comments for a post
    function renderComments(postId, container) {
        const post = CommunityModule.getPost(postId);
        container.innerHTML = '';

        if (!post || post.comments.length === 0) {
            container.innerHTML = '<div class="no-comments"><p>No comments yet.</p></div>';
            return;
        }

        post.comments.forEach(comment => {
            const commentDiv = document.createElement('div');
            commentDiv.className = 'comment';

            const userBadge = comment.userType === 'donor'
                ? '<span class="comment-badge donor-badge">Donor</span>'
                : '<span class="comment-badge recipient-badge">Recipient</span>';

            let deleteHTML = '';
            if (currentUser.firstName && currentUser.lastName) {
                const fullName = `${currentUser.firstName} ${currentUser.lastName}`;
                if (comment.author === fullName) {
                    deleteHTML = `
                        <button class="delete-comment-btn" data-post-id="${postId}" data-comment-id="${comment.id}">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6h16z"></path>
                            </svg>
                        </button>
                    `;
                }
            }

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
                        ${deleteHTML}
                    </div>
                </div>
                <div class="comment-content">${comment.content}</div>
            `;

            // Delete comment listener
            commentDiv.querySelector('.delete-comment-btn')?.addEventListener('click', (e) => {
                e.preventDefault();
                if (confirm('Delete this comment?')) {
                    CommunityModule.deleteComment(postId, comment.id);
                    renderComments(postId, container);
                }
            });

            container.appendChild(commentDiv);
        });
    }

    // Create post form handler
    const postForm = document.getElementById('create-post-form');
    if (postForm) {
        postForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const textarea = postForm.querySelector('textarea');
            const content = textarea.value.trim();

            if (content && currentUser.firstName && currentUser.lastName) {
                const fullName = `${currentUser.firstName} ${currentUser.lastName}`;
                CommunityModule.createPost(content, fullName, currentUserType);
                textarea.value = '';
                renderPosts();
            }
        });
    }

    // Initial render
    renderPosts();
});
