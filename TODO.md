# Coursework TODO

This file lists the planned tasks to complete the Laravel coursework. Each item includes a short description and acceptance criteria. Pick an item to start and I'll implement it (marking todos in the managed todo list as we go).

-   [x] Project planning & assumptions

    -   Summary: capture requirements, assumptions and data contracts. Include the high-marks analytics requirement: capture >2 analytics types and at least one requiring user interaction (we'll implement a 'like' API). Create `docs/PLAN.md` if requested.
    -   Acceptance: `docs/PLAN.md` (optional) contains inputs/outputs and assumptions.

-   [x] Create migrations

    -   Create migrations for `users`, `posts`, `comments`, `post_views`, `post_likes` (optional `post_time_spent` for time-on-post analytics). Add indexes and foreign keys.
    -   Acceptance: `php artisan migrate` builds the schema and tables have expected columns.

-   [x] Create models & relationships

    -   Implement Eloquent models: `User`, `Post`, `Comment`, `PostView`, `PostLike` (and optional `PostTimeSpent`). Add `fillable`, casts and relationship methods.
    -   Acceptance: relationships work in tinker/unit tests and return expected counts.

-   [x] Create model factories

    -   Factories for `User`, `Post`, `Comment`, `PostView`, `PostLike`. Include deterministic entries for at least one admin and one regular user.
    -   Acceptance: factories produce valid instances and are usable in seeders/tests.

-   [x] Create seeders

    -   Write seeders using the factories to generate varied data and fixed stable records (admin, regular user, sample posts). Cover edge cases: posts with zero comments, posts with many comments, posts with/without likes and views.
    -   Acceptance: `php artisan db:seed` populates representative data.

-   [x] Implement posts & comments APIs

    -   Controllers and routes for creating, reading and listing posts and comments (API-only is sufficient).
    -   Acceptance: JSON endpoints behave correctly and are covered by feature tests.

-   [x] Implement analytics storage

    -   Record unique views (by IP or user+date), likes (user interaction), and optionally time-on-post. Provide service layer to encapsulate analytics logic.
    -   Acceptance: calls to analytics endpoints create records and are queryable.

-   [x] API endpoint: Like a post (interactive)

    -   POST `/api/posts/{post}/like` endpoint that creates a single like per user per post (idempotent). No front-end required.
    -   Acceptance: endpoint creates `post_likes` record, prevents duplicates; tests verify behavior.

-   [x] Analytics aggregation & queries

    -   Model helpers/scopes to return `unique_views`, `likes_count`, `comments_count`, `average_time_spent` for a post.
    -   Acceptance: aggregation returns correct values in unit tests.

-   [ ] Tests: factories, models, analytics

    -   PHPUnit tests covering factories, model relationships, API endpoints (posts, comments, likes) and analytics correctness.
    -   Acceptance: `vendor/bin/phpunit` passes tests for the new features.

-   [ ] Documentation & usage

    -   Update `README.md` with steps to migrate, seed, run the server and examples for calling analytics endpoints. Optionally add `docs/USAGE.md`.
    -   Acceptance: Instructions allow another developer to reproduce the environment and exercise endpoints.

-   [ ] Quality gate: migrate, seed, test

    -   Run `php artisan migrate:fresh --seed` and `phpunit`. Fix any issues discovered.
    -   Acceptance: migrations/seeds complete and tests pass.

-   [ ] Optional extras / polish
    -   Add indexes, PHPDoc, small authorization policies, API token auth for likes, and more complex analytics if time permits.
    -   Acceptance: extras documented and covered by tests or seed data.

---

Next step: tell me which checklist item you want me to start implementing. I recommend starting with `Create migrations` so we can build the database schema and iterate from there.
