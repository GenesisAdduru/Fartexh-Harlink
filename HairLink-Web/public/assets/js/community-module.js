// Community Module - Manages posts, comments, and community interactions

const CommunityModule = {
    /**
     * Helper to get CSRF token
     */
    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    },

    /**
     * Generic API call wrapper
     */
    async apiCall(url, method = 'GET', body = null) {
        const options = {
            method,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': this.getCsrfToken()
            }
        };

        if (body) {
            if (body instanceof FormData) {
                options.body = body;
            } else {
                options.headers['Content-Type'] = 'application/json';
                options.body = JSON.stringify(body);
            }
        }

        const response = await fetch(url, options);
        if (!response.ok) {
            throw new Error(`API Error: ${response.status} ${response.statusText}`);
        }
        return await response.json();
    },

    /**
     * Map backend post to frontend expectations
     */
    mapPost(post) {
        return {
            ...post,
            author: this.formatAuthorName(post.user),
            userType: post.user?.role || 'user',
            avatar: this.generateAvatar(this.formatAuthorName(post.user)),
            timestamp: post.created_at,
            image: post.image_url,
            comments: (post.comments || []).map(comment => this.mapComment(comment))
        };
    },

    mapComment(comment) {
        return {
            ...comment,
            author: this.formatAuthorName(comment.user),
            userType: comment.user?.role || 'user',
            avatar: this.generateAvatar(this.formatAuthorName(comment.user)),
            timestamp: comment.created_at,
            image: comment.image_url,
            replies: (comment.replies || []).map(reply => this.mapComment(reply))
        };
    },

    formatAuthorName(user) {
        if (!user) return 'Anonymous';
        if (user.first_name) {
            return `${user.first_name} ${user.last_name || ''}`.trim();
        }
        return user.name || 'Anonymous';
    },

    // Get all posts
    async getPosts() {
        const data = await this.apiCall('/internal-api/community/posts');
        return data.map(post => this.mapPost(post));
    },

    // Get single post
    async getPost(postId) {
        const posts = await this.getPosts();
        return posts.find(p => p.id === postId);
    },

    // Create new post
    async createPost(content, imageFile = null) {
        const formData = new FormData();
        formData.append('content', content);
        if (imageFile) {
            formData.append('image', imageFile);
        }
        const data = await this.apiCall('/internal-api/community/posts', 'POST', formData);
        return this.mapPost(data);
    },

    // Add comment to post
    async addComment(postId, content, parentId = null, imageFile = null) {
        const formData = new FormData();
        formData.append('content', content);
        if (parentId) {
            formData.append('parent_id', parentId);
        }
        if (imageFile) {
            formData.append('image', imageFile);
        }
        const data = await this.apiCall(`/internal-api/community/posts/${postId}/comments`, 'POST', formData);
        return this.mapComment(data);
    },

    // Delete post
    async deletePost(postId) {
        return await this.apiCall(`/internal-api/community/posts/${postId}`, 'DELETE');
    },

    // Delete comment
    async deleteComment(commentId) {
        return await this.apiCall(`/internal-api/community/comments/${commentId}`, 'DELETE');
    },

    // Like post
    async toggleLike(postId) {
        const data = await this.apiCall(`/internal-api/community/posts/${postId}/like`, 'POST');
        return data;
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

// Expose to window
window.CommunityModule = CommunityModule;
