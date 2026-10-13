# Project Improvement Roadmap: RIASEC Career Profiling System

This document provides a prioritized audit of the Talunton Cavite RIASEC web application, outlining areas that need improvement across **Security**, **Database & Architecture**, **Assessment & Matching Algorithms**, **Frontend & UI/UX**, and **Code Hygiene**.

---

## 1. High Priority: Security & Vulnerability Fixes

### 1.1 Protect Sensitive Files (`.env`, `.sql`, archives) via `.htaccess`
* **Issue**: The `.env` file containing database credentials and SMTP email passwords is fully accessible via browser at `http://localhost/riasec/.env`. Similarly, database dumps (`database/riasec_db.sql`) and ZIP files (`colleges.zip`, `temp1.zip`) can be downloaded by anyone.
* **Fix**:
  Update `.htaccess` to deny access to sensitive files and extensions:
  ```apache
  <FilesMatch "^\.env|\.git|\.sql$|\.zip$">
      Order allow,deny
      Deny from all
  </FilesMatch>
  ```
  Or move `.env` completely outside the Apache web root (`htdocs`).

### 1.2 Implement Backend CSRF Token Verification
* **Issue**: The frontend sends an `X-CSRF-Token` header for requests like `api/save_degree` and `api/save_college`, but the controllers (`ProfileController`, `AssessmentController`) never validate this token on the server.
* **Fix**: Implement a global helper in `auth/config.php`:
  ```php
  function verifyCsrfToken(): void {
      $headers = getallheaders();
      $token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? '';
      if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
          http_response_code(403);
          die(json_encode(['success' => false, 'error' => 'Invalid CSRF token']));
      }
  }
  ```
  Call `verifyCsrfToken()` on all state-mutating POST/DELETE API endpoints.

### 1.3 Hide Correct Answers from Quiz API Responses
* **Issue**: `CourseQuizController::getQuestions()` sends `correct_answer` directly in the JSON response to the client browser (`'correct' => $row['correct_answer']`), allowing users to view answers before answering via DevTools.
* **Fix**:
  * Strip `correct_answer` from the `/api/get_course_questions` response.
  * Add a dedicated submit endpoint (`/api/submit_course_quiz`) that validates answers and calculates knowledge levels entirely server-side.

### 1.4 Secure Session Cookies
* **Issue**: Session configuration in `auth/config.php` does not enforce secure cookie attributes.
* **Fix**: Call `session_set_cookie_params()` before `session_start()`:
  ```php
  session_set_cookie_params([
      'lifetime' => 86400 * 7,
      'path'     => '/',
      'httponly' => true,
      'samesite' => 'Lax'
  ]);
  ```

---

## 2. High Priority: Database & Schema Integrity

### 2.1 Update Master Database Migration Dump (`database/riasec_db.sql`)
* **Issue**: The SQL migration file `database/riasec_db.sql` does not include recently added tables:
  * `career_role_models` (required for `/api/get_role_model`)
  * `course_questions` (required for degree-specific quizzes)
  * `user_assessments` (required for pause/resume feature)
* **Fix**: Export the current, complete schema including all tables, indexes, and seed data into `database/riasec_db.sql` so fresh installations work without crashes.

### 2.2 Add Foreign Keys and Database Indexes
* **Issue**: Tables lack foreign key constraints and necessary indexes, risking orphaned records:
  * `user_assessments(user_id)` -> FK to `users(id)` ON DELETE CASCADE
  * `user_saved_degrees(user_id, degree_id)` -> Composite UNIQUE index and FKs
  * `course_questions(degree_id)` -> Index on `degree_id`
  * `career_role_models` -> Index on `degree_program` and `riasec_primary`

---

## 3. Medium Priority: Backend Architecture & Code Consistency

### 3.1 Adopt an MVC Model Layer
* **Issue**: Only `app/Models/User.php` exists. Controllers directly interact with raw `mysqli` queries across `AssessmentController`, `ProfileController`, and `CourseQuizController`.
* **Fix**: Create dedicated Model classes:
  * `app/Models/Degree.php`
  * `app/Models/Assessment.php`
  * `app/Models/RoleModel.php`
  * `app/Models/CourseQuiz.php`
  Keep controllers focused solely on handling HTTP input, delegating to models, and returning responses.

### 3.2 Standardize JSON Responses and Error Handling
* **Issue**: Inconsistent response patterns:
  * Some files use `jsonResponse($success, $msg, $data)`
  * Some use `echo json_encode(['success' => ...]); exit;`
  * Some return HTTP status codes, others always return HTTP 200 even on error.
* **Fix**: Standardize all API controllers to use a single response helper with appropriate HTTP status codes (400, 401, 403, 404, 500).

### 3.3 Normalize URL Routing & Base Path Handling
* **Issue**: Frontend scripts and controllers mix relative and absolute paths (`login` vs `/riasec/login` vs `login.html`), causing navigation breaks if the app is deployed on a different path or root domain.
* **Fix**: Introduce a `BASE_URL` constant in `config.php` and use it across redirects and template navigation links.

---

## 4. Medium Priority: Assessment & Matchmaking Logic

### 4.1 Remove Randomness from Degree Recommendation Scoring
* **Issue**: In `results.html`, `fetchRecommendedDegrees` has a random fallback:
  ```js
  if (percent < 30) percent = 30 + Math.floor(Math.random()*20);
  ```
  This causes user results to change unpredictably each time the page is refreshed.
* **Fix**: Calculate a deterministic fit score based strictly on RIASEC code congruence (e.g., Holland hexagonal distance or weighted code matching) without `Math.random()`.

### 4.2 Sync Guest Assessment Data to User Account Upon Registration/Login
* **Issue**: Guest users taking the assessment have scores stored in `localStorage`. If they subsequently log in or register, their in-progress/completed assessment in `localStorage` is not automatically migrated to the `user_assessments` table.
* **Fix**: On successful login/registration, check if `talunton_assessment_scores` exists in `localStorage`. If present, trigger a background sync to `api/save_assessment` to permanently attach it to the new account.

### 4.3 Seamless Role Model Integration
* **Issue**: The Career Role Model is displayed as a single card at the very bottom of the results page, only matching the first degree.
* **Improvement**: Show relevant role models directly connected to each recommended degree in the recommendations list or within the degree profile page modal.

---

## 5. UI/UX & Frontend Polish

### 5.1 Harmonize Degree Cards Across Pages
* **Issue**: Degree cards in `app/Views/results.html` display:
  * Fit percentage
  * Tuition estimates
  * Scholarship badges
  * "Take a Quiz" quick action
  Meanwhile, cards in `app/Views/degrees.html` only show basic descriptions and bookmark buttons.
* **Improvement**: Unify the card design so users browsing `/degrees` can also see available quizzes, campus badges, and direct intro lesson links.

### 5.2 Clean Up Mixed Frontend Paradigms
* **Issue**: The application mixes Vue 3 CDN instances (`app/Views/results.html`, `app/Views/assessment.html`, `app/Views/degree-profile.html`) with imperative vanilla DOM manipulation (`app/Views/degrees.html`, `app/Views/layout.php`).
* **Improvement**: Standardize on Vue 3 components across all dynamic pages for consistent state management, reactivity, and cleaner code.

### 5.3 Responsive & Accessibility (a11y) Improvements
* Ensure all icon-only buttons (like bookmark/save buttons) have descriptive `aria-label` tags.
* Ensure campus dropdown menus close reliably when clicking outside or pressing Escape.
* Verify mobile navigation toggle and modal scroll behavior on iOS Safari and mobile Chrome.

---

## 6. Project & Workspace Hygiene

### 6.1 Clean Up Root Directory Clutter
* **Issue**: Over 50 one-off maintenance, patching, and testing scripts are currently located in the root directory:
  * `fix_*.php`, `fix_*.js`, `fix_*.py`
  * `update_*.php`, `update_*.py`, `update_*.ps1`
  * `patch_*.php`, `patch_*.ps1`
  * `check*.php`, `test-*.js`, `test_*.php`
  * `temp1.zip`, `temp2.zip`, `colleges.zip`
  * `extracted_prompt.txt`, `hex.txt`, `response.html`
* **Fix**:
  1. Delete redundant temporary files and scratch archives.
  2. Move remaining operational maintenance scripts into a dedicated `scripts/` or `tools/` directory outside the public web route.

### 6.2 Initialize Git Version Control & `.gitignore`
* **Issue**: The project is not initialized with Git, preventing easy rollbacks and change tracking.
* **Fix**:
  1. Create `.gitignore` to exclude `.env`, `node_modules/`, `temp_*/`, and uploaded ZIP archives.
  2. Initialize git (`git init`) and create an initial commit of the clean codebase.

---

## Priority Checklist Summary

| Task | Category | Impact |
|---|---|---|
| [ ] Block `.env`, `.sql`, `.zip` in `.htaccess` | Security | Critical |
| [ ] Add server-side CSRF token validation | Security | High |
| [ ] Hide quiz answers from client JSON response | Security | High |
| [ ] Export complete database schema to `database/riasec_db.sql` | Database | High |
| [ ] Move one-off fix/test scripts out of root directory | Maintenance | High |
| [ ] Remove `Math.random()` from recommendation scoring | Logic | Medium |
| [ ] Sync guest localStorage assessments on account login | Logic | Medium |
| [ ] Unify Degree Card actions across `degrees.html` & `results.html` | UI/UX | Medium |
| [ ] Build dedicated Model classes (`Degree`, `RoleModel`, etc.) | Architecture | Medium |
| [ ] Setup Git repository & `.gitignore` | DevOps | Medium |
