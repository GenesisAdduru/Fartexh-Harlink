// Hair Care Module - Manages articles, videos, and resources

const HairCareModule = {
    ARTICLES_KEY: 'hairlinkArticlesV1',
    VIDEOS_KEY: 'hairlinkVideosV1',
    
    // Initialize hair care resources
    initializeStorage() {
        if (!localStorage.getItem(this.ARTICLES_KEY)) {
            const sampleArticles = [
                {
                    id: 'article_001',
                    title: 'Complete Wig Care Guide: Washing and Conditioning',
                    category: 'Care',
                    author: 'HairLink Team',
                    date: new Date(Date.now() - 5 * 24 * 60 * 60 * 1000).toISOString(),
                    excerpt: 'Learn the proper techniques for washing and conditioning your wig to maintain its beauty and longevity.',
                    content: `Proper wig care starts with understanding your wig type. Whether you have a synthetic or human hair wig, washing and conditioning are essential for maintenance.

**Washing Steps:**
1. Fill a basin with lukewarm water (not hot)
2. Add specialized wig shampoo to the water
3. Gently submerge your wig and swish it through the water
4. Avoid scrubbing or wringing the hair
5. Rinse with clean water until all soap is gone
6. Use a leave-in conditioner for extra softness

**Drying:**
- Gently squeeze out excess water with a soft towel
- Never wring or twist your wig
- Air dry on a wig stand or flat surface
- Keep away from direct heat and sunlight

Regular care extends your wig's lifespan by months or even years!`,
                    readTime: 5,
                    image: '📚'
                },
                {
                    id: 'article_002',
                    title: 'Styling Your Wig: Tips and Tricks',
                    category: 'Styling',
                    author: 'HairLink Team',
                    date: new Date(Date.now() - 10 * 24 * 60 * 60 * 1000).toISOString(),
                    excerpt: 'Discover creative ways to style your wig and express your personal style with confidence.',
                    content: `Styling a wig opens up endless possibilities for self-expression. Here are some professional tips to get the best results.

**Basic Styling Tips:**
- Use a wig brush or wide-tooth comb, never a regular hairbrush
- Start from the ends and work your way up to avoid tangles
- For synthetic wigs, use only cool water for styling
- Human hair wigs can be styled like natural hair with proper products
- Always style on a wig stand for best control

**Advanced Techniques:**
- Curling: Use low heat settings for human hair wigs only
- Coloring: Consult professionals before coloring synthetic wigs
- Layering: Ask your stylist about adding layers for more movement
- Parting: You can change your part line with careful brushing

Remember, confidence is the best accessory!`,
                    readTime: 4,
                    image: '✨'
                },
                {
                    id: 'article_003',
                    title: 'Storage Solutions for Long-Lasting Wigs',
                    category: 'Storage',
                    author: 'HairLink Team',
                    date: new Date(Date.now() - 15 * 24 * 60 * 60 * 1000).toISOString(),
                    excerpt: 'Proper storage is key to keeping your wig in pristine condition when not in use.',
                    content: `How you store your wig when not wearing it directly impacts its lifespan and appearance.

**Best Storage Practices:**
- Always use a wig stand or mannequin head
- Store in a cool, dry place away from direct sunlight
- Keep in a breathable bag or container
- Avoid tight storage that can cause tangling
- Store away from pets and humid environments

**Storage Locations to Avoid:**
- Bathrooms (humidity can damage your wig)
- Near heating vents or radiators
- Damp or cold storage areas
- Places accessible to pets

**Maintenance Between Wears:**
- Lightly mist with wig spray between washes
- Gently brush to remove any tangles
- Air out your wig to prevent odors
- Inspect regularly for any damage

Proper storage can extend your wig's life by 1-2 years!`,
                    readTime: 4,
                    image: '🏠'
                }
            ];
            localStorage.setItem(this.ARTICLES_KEY, JSON.stringify(sampleArticles));
        }

        if (!localStorage.getItem(this.VIDEOS_KEY)) {
            const sampleVideos = [
                {
                    id: 'video_001',
                    title: 'How to Properly Wash Your Wig - Step by Step',
                    category: 'Tutorial',
                    source: 'youtube',
                    videoId: 'dQw4w9WgXcQ', // Example YouTube ID
                    author: 'HairLink Channel',
                    date: new Date(Date.now() - 7 * 24 * 60 * 60 * 1000).toISOString(),
                    duration: '8:32',
                    views: 1250,
                    description: 'Learn the proper technique for washing your wig to keep it looking fresh and beautiful.'
                },
                {
                    id: 'video_002',
                    title: 'Wig Styling Transformations - Before & After',
                    category: 'Inspiration',
                    source: 'youtube',
                    videoId: 'jNQXAC9IVRw', // Example YouTube ID
                    author: 'Beauty Experts',
                    date: new Date(Date.now() - 14 * 24 * 60 * 60 * 1000).toISOString(),
                    duration: '12:45',
                    views: 3540,
                    description: 'See amazing transformations and get inspired by different styling options.'
                },
                {
                    id: 'video_003',
                    title: 'Wig Maintenance | Extended Care Tips',
                    category: 'Care',
                    source: 'youtube',
                    videoId: 'kffacxfA7G4', // Example YouTube ID
                    author: 'Professional Stylists',
                    date: new Date(Date.now() - 21 * 24 * 60 * 60 * 1000).toISOString(),
                    duration: '15:20',
                    views: 2100,
                    description: 'Advanced tips for maintaining your wig and extending its lifespan.'
                }
            ];
            localStorage.setItem(this.VIDEOS_KEY, JSON.stringify(sampleVideos));
        }
    },

    // Get all articles
    getArticles() {
        const articles = localStorage.getItem(this.ARTICLES_KEY);
        return articles ? JSON.parse(articles) : [];
    },

    // Get single article
    getArticle(articleId) {
        const articles = this.getArticles();
        return articles.find(a => a.id === articleId);
    },

    // Add new article
    addArticle(title, category, excerpt, content, readTime, author = 'HairLink Team') {
        const articles = this.getArticles();
        const newArticle = {
            id: `article_${Date.now()}`,
            title: title,
            category: category,
            author: author,
            date: new Date().toISOString(),
            excerpt: excerpt,
            content: content,
            readTime: readTime,
            image: '📄'
        };
        articles.unshift(newArticle);
        localStorage.setItem(this.ARTICLES_KEY, JSON.stringify(articles));
        return newArticle;
    },

    // Get all videos
    getVideos() {
        const videos = localStorage.getItem(this.VIDEOS_KEY);
        return videos ? JSON.parse(videos) : [];
    },

    // Get single video
    getVideo(videoId) {
        const videos = this.getVideos();
        return videos.find(v => v.id === videoId);
    },

    // Add new video
    addVideo(title, category, source, videoId, author, description, duration = '0:00') {
        const videos = this.getVideos();
        const newVideo = {
            id: `video_${Date.now()}`,
            title: title,
            category: category,
            source: source, // 'youtube', 'vimeo', 'custom'
            videoId: videoId,
            author: author,
            date: new Date().toISOString(),
            duration: duration,
            views: 0,
            description: description
        };
        videos.unshift(newVideo);
        localStorage.setItem(this.VIDEOS_KEY, JSON.stringify(videos));
        return newVideo;
    },

    // Delete article
    deleteArticle(articleId) {
        let articles = this.getArticles();
        articles = articles.filter(a => a.id !== articleId);
        localStorage.setItem(this.ARTICLES_KEY, JSON.stringify(articles));
    },

    // Delete video
    deleteVideo(videoId) {
        let videos = this.getVideos();
        videos = videos.filter(v => v.id !== videoId);
        localStorage.setItem(this.VIDEOS_KEY, JSON.stringify(videos));
    },

    // Get video embed URL
    getEmbedUrl(video) {
        if (video.source === 'youtube') {
            return `https://www.youtube.com/embed/${video.videoId}`;
        } else if (video.source === 'vimeo') {
            return `https://player.vimeo.com/video/${video.videoId}`;
        } else if (video.source === 'custom') {
            return video.videoId; // Assume it's a direct embed URL
        }
        return '';
    },

    // Format date
    formatDate(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric' 
        });
    },

    // Format view count
    formatViews(views) {
        if (views >= 1000000) return (views / 1000000).toFixed(1) + 'M';
        if (views >= 1000) return (views / 1000).toFixed(1) + 'K';
        return views.toString();
    }
};

// Initialize on load
document.addEventListener('DOMContentLoaded', () => {
    HairCareModule.initializeStorage();
});
