# Video Demonstration Plan (3 Minutes)

## Overview

This video demonstrates all 5 core components of the Laravel coursework:

1. **Migrations** - Database schema creation
2. **Models** - Eloquent relationships and structure
3. **Seeders** - Professional multi-file seeding with factories
4. **Model Factories** - Deterministic and random data generation
5. **Basic Analytics** - Views, likes, comments tracking and aggregation

**Total Duration:** ~3 minutes  
**Resolution:** Record at 1080p if possible  
**Suggested Tools:** OBS Studio, ScreenFlow, or Windows Screen Recorder

---

## DETAILED DEMONSTRATION PLAN

### **SEGMENT 1: PROJECT SETUP & MIGRATIONS (0:00 - 0:35)**

#### Step 1: Show the Laravel project directory

-   **Time:** 0:00 - 0:05
-   **Action:** Open terminal, navigate to project
-   **Command to show:**
    ```bash
    cd "C:\Users\catch\OneDrive\Desktop\AllGawainStuff\php_work\laravel"
    ls -la
    ```
-   **What to highlight:** Show the clean Laravel directory structure

#### Step 2: Run fresh migrations

-   **Time:** 0:05 - 0:15
-   **Action:** Execute migration command
-   **Command:**
    ```bash
    php artisan migrate:fresh
    ```
-   **What to highlight:**
    -   Shows "Creating migration table"
    -   Shows all 7 migrations running:
        -   ✅ create_users_table
        -   ✅ create_cache_table
        -   ✅ create_jobs_table
        -   ✅ create_posts_table
        -   ✅ create_comments_table
        -   ✅ create_post_views_table
        -   ✅ create_post_likes_table

#### Step 3: Show migration files in editor

-   **Time:** 0:15 - 0:30
-   **Action:** Open VS Code and show key migration files
-   **Files to show:**
    1. `database/migrations/0001_01_01_000003_create_posts_table.php`
        - Highlight: Foreign key to users, indexed columns
    2. `database/migrations/0001_01_01_000005_create_post_views_table.php`
        - Highlight: Unique constraint on (post_id, ip_address, viewed_date)
    3. `database/migrations/0001_01_01_000006_create_post_likes_table.php`
        - Highlight: Unique constraint on (post_id, user_id)

#### Step 4: Show database schema

-   **Time:** 0:30 - 0:35
-   **Action:** Show SQLite database or migration output
-   **Alternative:** Take screenshot of schema documentation
-   **Highlight:** All tables created with proper relationships

---

### **SEGMENT 2: MODELS & RELATIONSHIPS (0:35 - 1:15)**

#### Step 5: Show Eloquent Models in code

-   **Time:** 0:35 - 0:55
-   **Action:** Open editor and display model files
-   **Files to show (quick scrollthrough each):**
    1. `app/Models/User.php`
        - Highlight: `posts()`, `comments()`, `likes()` relationships
    2. `app/Models/Post.php`
        - Highlight: `author()`, `comments()`, `views()`, `likes()` relationships
        - Show the analytics methods: `getEngagementMetrics()`, `getUniqueViewsAttribute()`
    3. `app/Models/PostView.php`
        - Highlight: Stores IP + user_id for unique view tracking
    4. `app/Models/PostLike.php`
        - Highlight: Enforces one-like-per-user constraint

#### Step 6: Verify relationships in code

-   **Time:** 0:55 - 1:10
-   **Action:** Show specific relationship definitions
-   **Highlight:**
    -   Foreign key references
    -   Relationship method signatures
    -   Casts and fillable properties

#### Step 7: Summary of model structure

-   **Time:** 1:10 - 1:15
-   **Action:** Brief narration
-   **Say:** "We have 5 models: User, Post, Comment, PostView, and PostLike - all properly related with foreign keys and indexed for performance"

---

### **SEGMENT 3: FACTORIES & SEEDERS (1:15 - 2:00)**

#### Step 8: Show Model Factories

-   **Time:** 1:15 - 1:35
-   **Action:** Display factory files in editor
-   **Files to show:**
    1. `database/factories/UserFactory.php`
        - Highlight: `admin()` and `regular()` state methods
    2. `database/factories/PostFactory.php`
        - Highlight: `popular()` and `unpopular()` state methods
    3. `database/factories/CommentFactory.php` - Quick show
    4. `database/factories/PostViewFactory.php`
        - Highlight: `byUser()` and `anonymous()` methods

#### Step 9: Show Professional Seeder Structure

-   **Time:** 1:35 - 1:50
-   **Action:** Show the 5 seeder files
-   **Files to show:**
    ```
    database/seeders/
    ├── DatabaseSeeder.php       (Orchestrator)
    ├── UserSeeder.php           (10 users)
    ├── PostSeeder.php           (10 posts)
    ├── CommentSeeder.php        (32 comments)
    ├── PostViewSeeder.php       (58 views)
    └── PostLikeSeeder.php       (28 likes)
    ```
-   **Highlight:** Each seeder imports and uses its corresponding factory
-   **Key point:** Show `DatabaseSeeder.php` orchestrating all 5 seeders

#### Step 10: Run seeders with migrations

-   **Time:** 1:50 - 2:00
-   **Action:** Execute the seed command
-   **Command:**
    ```bash
    php artisan migrate:fresh --seed
    ```
-   **What to highlight:**
    -   ✅ All tables dropped and recreated
    -   ✅ All 5 seeders run successfully in order
    -   ✅ Output shows timing for each seeder

---

### **SEGMENT 4: BASIC ANALYTICS & API (2:00 - 3:00)**

#### Step 11: Show seeded data counts

-   **Time:** 2:00 - 2:10
-   **Action:** Run tinker command to show seeded data
-   **Command:**
    ```bash
    php artisan tinker --execute "echo 'Users: ' . App\Models\User::count() . '\n'; echo 'Posts: ' . App\Models\Post::count() . '\n'; echo 'Comments: ' . App\Models\Comment::count() . '\n'; echo 'Views: ' . App\Models\PostView::count() . '\n'; echo 'Likes: ' . App\Models\PostLike::count() . '\n';"
    ```
-   **Output to show:**
    ```
    Users: 10
    Posts: 10
    Comments: 32
    Views: 58
    Likes: 28
    ```

#### Step 12: Start Laravel development server

-   **Time:** 2:10 - 2:15
-   **Action:** Start the server
-   **Command:**
    ```bash
    php artisan serve
    ```
-   **Show:** Server output indicating "Server running on [http://127.0.0.1:8000]"

#### Step 13: Test Analytics API Endpoint

-   **Time:** 2:15 - 2:45
-   **Action:** Open browser and navigate to aggregation endpoint
-   **URL:**
    ```
    http://localhost:8000/api/test/aggregation
    ```
-   **What to highlight in JSON response:**
    1. **all_posts** - Shows all posts with metrics
    2. **most_viewed** - Top 3 posts by views
    3. **most_liked** - Top 3 posts by likes
    4. **most_engaged** - Top 3 posts by total engagement
    5. **Counts** - Various filter results

#### Step 14: Test individual post with auto-tracked views

-   **Time:** 2:45 - 2:55
-   **Action:** Visit a post and show view tracking
-   **URL:**
    ```
    http://localhost:8000/api/posts/1
    ```
-   **Show:** JSON response with post data including:
    -   Post title and content
    -   `views_count`, `likes_count`, `comments_count`
    -   Author information

#### Step 15: Demonstrate like endpoint (bonus)

-   **Time:** 2:55 - 3:00
-   **Action:** Show like endpoint documentation OR show the route in code
-   **Alternative:** Show POST request to `/api/posts/{post}/like` in code/Postman screenshot
-   **Say:** "The like endpoint allows users to toggle likes on posts, enforcing one-like-per-user constraint"

---

## TIMESTAMP SUMMARY CHECKLIST

| Component      | Time Range  | Duration | Evidence                                     |
| -------------- | ----------- | -------- | -------------------------------------------- |
| **Migrations** | 0:00 - 0:35 | 35s      | CLI output + code files                      |
| **Models**     | 0:35 - 1:15 | 40s      | Code files + relationships                   |
| **Factories**  | 1:15 - 1:35 | 20s      | Factory code with state methods              |
| **Seeders**    | 1:35 - 2:00 | 25s      | Seeder files + `migrate:fresh --seed` output |
| **Analytics**  | 2:00 - 3:00 | 60s      | Tinker counts + API responses                |

---

## SCRIPT / NARRATION GUIDE

### Opening (0:00)

_"In this video, I'll demonstrate a complete Laravel application with professional-grade migrations, models, factories, and analytics capabilities."_

### Migrations Section (0:05)

_"First, let's run the migrations to create our database schema. This creates 7 tables with proper foreign keys and indexes."_

### Models Section (0:40)

_"Our model layer includes 5 Eloquent models with full relationships. Each model is properly configured with fillable properties, casts, and relationship methods."_

### Factories & Seeders Section (1:15)

_"We use professional factories to generate realistic test data. Our seeding layer is split into 5 specialized seeders, each with a specific responsibility. Let's run migrate:fresh --seed to see everything work together."_

### Analytics Section (2:00)

_"Now let's see the analytics in action. We have 10 users, 10 posts, and 28 likes across the system. The system automatically tracks views, likes, and comments. Here's our aggregation API that shows posts ordered by various metrics."_

### Closing (3:00)

_"All core requirements are met: professional migrations, models with relationships, factories used throughout seeders, and a complete analytics system tracking views, likes, and comments."_

---

## TECHNICAL REQUIREMENTS

### Pre-Recording Checklist

-   [ ] Fresh `php artisan migrate:fresh --seed` completed
-   [ ] Laravel dev server ready to start
-   [ ] Browser ready for API testing
-   [ ] VS Code with project open
-   [ ] Terminal ready
-   [ ] Screen resolution set to 1080p
-   [ ] Font size increased for readability
-   [ ] Dark theme enabled for better visibility

### Recording Tips

1. **Pacing:** Allow 1-2 seconds pause between sections for clarity
2. **Highlighting:** Point mouse cursor to important lines in code
3. **Minimize scrolling:** Keep visible area clean and focused
4. **Audio:** Speak clearly and concisely
5. **Zoom level:** Make terminal text easily readable
6. **Background:** Minimize distractions

### Post-Recording

-   [ ] Export as MP4 (1080p, 60fps)
-   [ ] Add title card (first 3-5 seconds)
-   [ ] Add YouTube timestamps in description
-   [ ] Submit with this plan as reference document

---

## TIMESTAMPS FOR VIDEO DESCRIPTION

```
0:00 - Project Overview & Database Migrations
0:35 - Eloquent Models & Relationships
1:15 - Model Factories with State Methods
1:35 - Professional Seeder Structure
2:00 - Analytics API & Seeded Data
2:45 - Individual Post View Tracking
3:00 - Summary
```

---

## EXPECTED OUTCOMES

By end of video, markers will see:
✅ 7 migrations creating proper schema  
✅ 5 Eloquent models with relationships  
✅ 5 professional seeder files  
✅ 5 factory classes with state methods  
✅ Automatic analytics tracking  
✅ Working API endpoints  
✅ Complete seeded database (10 users, 10 posts, 28 likes, 32 comments, 58 views)
