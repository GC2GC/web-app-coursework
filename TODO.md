# Coursework 2 - Frontend Implementation TODO List

## Authentication [5 marks - Target: 3-5 marks]

-   [x] Install and configure Laravel Fortify for authentication (login, register, logout, password reset)
-   [x] Create authentication views (login, register, password reset) using Tailwind CSS
-   [x] Add authentication middleware to protect all routes - users must login before accessing any data
-   [x] Update controllers to use auth()->user() instead of requiring user_id in requests

## User Dashboard [6 marks - Target: 6 marks]

-   [x] Create User Dashboard page showing list of posts with pagination
-   [x] Display posts with author names (not IDs), creation dates, view counts, like counts, comment counts
-   [x] Add navigation/layout template with header, sidebar, and footer using Tailwind CSS

## User Resource [5 marks - Target: 5 marks]

-   [x] Create UserController with index, show, create, store, destroy methods
-   [x] Create user index page listing all users (admin only) with create and delete functionality
-   [x] Create user show page displaying user's name, email, and all their posts and comments
-   [x] Implement authorization: users can only edit their own posts/comments, admins can edit all
-   [x] Set up notification system for when someone interacts with user posts/comments (likes, comments)

## Administrator Access [6 marks - Target: 3-6 marks]

-   [x] Create admin middleware to check is_administrator flag
-   [x] Add admin panel/dashboard with ability to modify any user data
-   [x] Allow administrators to register new user accounts (admin-only registration form)
-   [x] Ensure admins can access all functionality (edit/delete any post, comment, user)

## Working with Data [6 marks - Target: 4-6 marks]

-   [x] Convert PostController to return views instead of JSON responses
-   [x] Create post creation form with title, content, and image upload fields
-   [x] Create post edit form (only for post owner or admin)
-   [x] Implement image upload functionality for posts (store in storage, display in views)
-   [x] Add validation rules for post creation/editing (title, content, image file types/sizes)
-   [x] Create post show page displaying full post with image, analytics, comments, and like button
-   [x] Convert CommentController to return views/redirects instead of JSON
-   [x] Create comment form on post show page with proper validation

## Desired Enhancement [6 marks - Target: 3-6 marks]

-   [x] Create user profile edit page (users can only edit their own profile)
-   [x] Add form to edit first_name, last_name, and email address
-   [x] Add authorization check to ensure users can only edit their own details

## Usability and Look & Feel [8 marks - Target: 6-8 marks]

-   [x] Replace default Laravel welcome page with custom homepage/landing page
-   [x] Ensure all views use user names instead of IDs (e.g., author name, not author ID)
-   [x] Remove all technical artefacts (null strings, raw IDs, debug output)
-   [x] Create consistent navigation menu with links to dashboard, profile, admin panel (if admin)
-   [x] Style all pages with Tailwind CSS for professional, modern look and feel
-   [x] Add flash messages/success notifications for actions (post created, comment added, etc.)

## Code Quality [8 marks - Target: 6-8 marks]

-   [ ] Review all controllers to ensure Route Model Binding is used consistently (remove manual lookups)
-   [x] Create Policy classes for authorization (PostPolicy, CommentPolicy, UserPolicy)
-   [ ] Extract repeated code into reusable methods/helpers (e.g., authorization checks)
-   [ ] Ensure all validation rules are consistent and follow Laravel conventions
-   [ ] Add proper error handling and user-friendly error messages
-   [ ] Update routes to use resource controllers and proper naming conventions

## Database & Migrations

-   [x] Add image_path column to posts table migration (if not exists)
-   [x] Create notifications table migration for user notifications

## Testing

-   [ ] Test all authentication flows (login, register, logout, password reset)
-   [ ] Test authorization (users can only edit own content, admins can edit all)
-   [ ] Test image upload functionality and display

---

**Total Tasks: 42**
