// Community Module - Manages posts, comments, and community interactions

const CommunityModule = {
    STORAGE_KEY: 'hairlinkCommunityPostsV1',
    
    // Initialize community data with sample posts
    initializeStorage() {
        if (!localStorage.getItem(this.STORAGE_KEY)) {
            const samplePosts = [
                {
                    id: 'post_001',
                    author: 'Maria Santos',
                    userType: 'recipient',
                    avatar: 'MS',
                    content: 'Just received my wig today and I\'m feeling so confident! Thank you to all the donors who made this possible.',
                    timestamp: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000).toISOString(),
                    likes: 12,
                    comments: [
                        {
                            id: 'comment_001',
                            author: 'Sarah Johnson',
                            userType: 'donor',
                            avatar: 'SJ',
                            content: 'This is so inspiring! Wishing you all the best on your journey.',
                            timestamp: new Date(Date.now() - 1 * 24 * 60 * 60 * 1000).toISOString()
                        }
                    ]
                },
                {
                    id: 'post_002',
                    author: 'John Doe',
                    userType: 'donor',
                    avatar: 'JD',
                    content: 'I donated my hair yesterday! It was a wonderful experience knowing it will help someone regain their confidence.',
                    timestamp: new Date(Date.now() - 3 * 24 * 60 * 60 * 1000).toISOString(),
                    likes: 8,
                    comments: []
                }
            ];
            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(samplePosts));
        }
    },

    // Get all posts
    getPosts() {
        const posts = localStorage.getItem(this.STORAGE_KEY);
        return posts ? JSON.parse(posts) : [];
    },

    // Get single post by ID
    getPost(postId) {
        const posts = this.getPosts();
        return posts.find(p => p.id === postId);
    },

    // Create new post
    createPost(content, author, userType) {
        const posts = this.getPosts();
        const newPost = {
            id: `post_${Date.now()}`,
            author: author,
            userType: userType,
            avatar: this.generateAvatar(author),
            content: content,
            timestamp: new Date().toISOString(),
            likes: 0,
            comments: []
        };
        posts.unshift(newPost);
        localStorage.setItem(this.STORAGE_KEY, JSON.stringify(posts));
        return newPost;
    },

    // Add comment to post
    addComment(postId, content, author, userType) {
        const posts = this.getPosts();
        const post = posts.find(p => p.id === postId);
        
        if (post) {
            const newComment = {
                id: `comment_${Date.now()}`,
                author: author,
                userType: userType,
                avatar: this.generateAvatar(author),
                content: content,
                timestamp: new Date().toISOString()
            };
            post.comments.push(newComment);
            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(posts));
            return newComment;
        }
        return null;
    },

    // Like/unlike post
    toggleLike(postId) {
        const posts = this.getPosts();
        const post = posts.find(p => p.id === postId);
        
        if (post) {
            post.likes = post.likes > 0 ? post.likes - 1 : post.likes + 1;
            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(posts));
            return post.likes;
        }
        return 0;
    },

    // Delete post
    deletePost(postId) {
        let posts = this.getPosts();
        posts = posts.filter(p => p.id !== postId);
        localStorage.setItem(this.STORAGE_KEY, JSON.stringify(posts));
    },

    // Delete comment
    deleteComment(postId, commentId) {
        const posts = this.getPosts();
        const post = posts.find(p => p.id === postId);
        
        if (post) {
            post.comments = post.comments.filter(c => c.id !== commentId);
            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(posts));
        }
    },

    // Generate avatar from name
    generateAvatar(name) {
        const parts = name.split(' ');
        if (parts.length >= 2) {
            return parts[0].charAt(0) + parts[1].charAt(0);
        }
        return name.substring(0, 2).toUpperCase();
    },

    // Format timestamp
    formatTime(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diff = now - date;
        
        const minutes = Math.floor(diff / 60000);
        const hours = Math.floor(diff / 3600000);
        const days = Math.floor(diff / 86400000);
        
        if (minutes < 1) return 'Just now';
        if (minutes < 60) return `${minutes}m ago`;
        if (hours < 24) return `${hours}h ago`;
        if (days < 7) return `${days}d ago`;
        
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    }
};

// Initialize on load
document.addEventListener('DOMContentLoaded', () => {
    CommunityModule.initializeStorage();
});
