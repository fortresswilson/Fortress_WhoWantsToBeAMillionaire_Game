<?php
// ============================================================
// questions.php
// 45 questions: 15 easy, 15 medium, 15 hard
// Structure: tier, text, options[4], correct_index (0-based)
// ============================================================

function get_question_bank(): array {
    return [

        // ── TIER 1 · EASY — Web Programming Basics (Levels 1–5) ─────────
        [
            'tier'          => 'easy',
            'text'          => 'Which HTML tag defines the largest heading on a page?',
            'options'       => ['<h6>', '<heading>', '<h1>', '<head>'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'What does CSS stand for?',
            'options'       => ['Creative Style Sheets', 'Cascading Style Sheets', 'Computer Style Syntax', 'Coded Style System'],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'Which attribute inside a <link> tag points to an external stylesheet?',
            'options'       => ['src', 'style', 'href', 'type'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'What is the correct HTML syntax for a clickable hyperlink?',
            'options'       => ['<link href="url">text</link>', '<a href="url">text</a>', '<href="url">text</href>', '<url>text</url>'],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'Which CSS property controls the color of text?',
            'options'       => ['font-color', 'text-color', 'foreground', 'color'],
            'correct_index' => 3,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'What does the HTML <br> tag do?',
            'options'       => ['Creates bold text', 'Inserts a line break', 'Draws a horizontal border', 'Adds a background color'],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'Which CSS property sets the space between an element\'s border and its content?',
            'options'       => ['margin', 'spacing', 'padding', 'border-gap'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'What is the default display value of a <div> element?',
            'options'       => ['inline', 'inline-block', 'flex', 'block'],
            'correct_index' => 3,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'Which HTML tag creates an unordered (bulleted) list?',
            'options'       => ['<ol>', '<list>', '<ul>', '<li>'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'Which CSS selector targets an element with id="header"?',
            'options'       => ['.header', '*header', '#header', '!header'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'Which HTML form attribute makes it submit data via POST?',
            'options'       => ['type="post"', 'send="POST"', 'method="POST"', 'action="POST"'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'Which HTML element is used to embed an image on a page?',
            'options'       => ['<picture>', '<img>', '<image>', '<photo>'],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'What does "display: flex" do when applied to a container?',
            'options'       => ['Hides the element', 'Makes the element stretch full-width', 'Enables flexbox layout for its children', 'Centers text inside the element'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'Which HTML tag defines a row inside a table?',
            'options'       => ['<td>', '<th>', '<tr>', '<table-row>'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'easy',
            'text'          => 'What is the correct HTML5 doctype declaration at the top of a page?',
            'options'       => ['<!DOCTYPE HTML5>', '<!DOCTYPE html>', '<html doctype="5">', '<?DOCTYPE html>'],
            'correct_index' => 1,
        ],

        // ── TIER 2 · MEDIUM — Technology & CS Concepts (Levels 6–10) ────
        [
            'tier'          => 'medium',
            'text'          => 'In PHP, which superglobal holds data submitted via an HTML form using POST?',
            'options'       => ['$_GET', '$_REQUEST', '$_POST', '$_FORM'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'What does PHP\'s htmlspecialchars() primarily protect against?',
            'options'       => ['SQL Injection', 'Cross-Site Scripting (XSS)', 'CSRF attacks', 'Brute force login'],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'Which PHP function securely hashes a password before storing it?',
            'options'       => ['md5()', 'sha1()', 'password_hash()', 'encrypt()'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'What problem does the Post-Redirect-Get (PRG) pattern solve?',
            'options'       => [
                'Loading pages faster using server caching',
                'Preventing duplicate form submissions on page refresh',
                'Automatically upgrading HTTP to HTTPS',
                'Keeping front-end and back-end code separated',
            ],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'What does session_start() do in PHP?',
            'options'       => [
                'Creates a new user account',
                'Initializes or resumes the current session so $_SESSION is accessible',
                'Starts a MySQL database transaction',
                'Opens a new browser tab',
            ],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'Which HTTP status code is returned for a server-side redirect?',
            'options'       => ['200 OK', '404 Not Found', '302 Found', '500 Internal Server Error'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'What does the CSS "grid-template-columns" property define?',
            'options'       => [
                'The number of rows in the grid',
                'The column track sizes for a grid container',
                'How items align horizontally within the grid',
                'A fixed width applied to all child elements',
            ],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'Which PHP function verifies a password against a hash made by password_hash()?',
            'options'       => ['hash_verify()', 'check_password()', 'password_verify()', 'md5_check()'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'What does PHP\'s array_filter() return?',
            'options'       => [
                'The array sorted by value',
                'All elements with duplicates removed',
                'Only the elements that pass a given callback test',
                'A merged copy of two input arrays',
            ],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'Which CSS at-rule applies styles only when a screen meets a width condition?',
            'options'       => ['@screen', '@breakpoint', '@media', '@viewport'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'What does header("Location: page.php") followed by exit do in PHP?',
            'options'       => [
                'Embeds the contents of page.php inline',
                'Adds a visible navigation header to the page',
                'Sends an HTTP redirect and stops further execution',
                'Includes and executes page.php as a subroutine',
            ],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'What is the correct PHP idiom to start a session and check if a user is logged in?',
            'options'       => [
                'start_session(); if (logged_in()) { }',
                'session_start(); if (isset($_SESSION["username"])) { }',
                'new Session(); if ($_SESSION->active) { }',
                'Session::start(); if (Session::has("user")) { }',
            ],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'Which CSS Flexbox property controls spacing of items along the main axis?',
            'options'       => ['align-items', 'flex-direction', 'justify-content', 'flex-wrap'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'What does PHP\'s session_destroy() do?',
            'options'       => [
                'Clears all PHP error logs from disk',
                'Destroys all session data and ends the session',
                'Deletes only the browser cookies',
                'Resets $_POST and $_GET to empty arrays',
            ],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'medium',
            'text'          => 'In an HTML form, what does the "name" attribute on an <input> control?',
            'options'       => [
                'The visible label displayed above the input',
                'The CSS class applied to the field',
                'The key used to access the field\'s value in $_POST or $_GET',
                'The placeholder text shown inside the empty field',
            ],
            'correct_index' => 2,
        ],

        // ── TIER 3 · HARD — LeetCode-Style Algorithm Logic (Levels 11–15) ─
        [
            'tier'          => 'hard',
            'text'          => 'What is the time complexity of finding all pairs that sum to a target value using a single-pass hash map?',
            'options'       => ['O(n²) — nested loop comparison', 'O(n log n) — sort then binary search', 'O(n) — single pass with hash map lookups', 'O(log n) — divide and conquer'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'Which data structure guarantees O(1) average-case time for lookup, insertion, and deletion?',
            'options'       => ['Binary Search Tree', 'Sorted Array', 'Hash Table', 'Doubly Linked List'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'What is the space complexity of a naive recursive Fibonacci function without memoization?',
            'options'       => ['O(1) — constant space', 'O(n) — call stack depth equals n', 'O(n²) — branching factor squared', 'O(2^n) — exponential frames'],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'Which algorithm finds the kth largest element in an unsorted array in O(n) average time?',
            'options'       => ['Sort descending then index at k', 'Min-heap maintaining k elements', 'QuickSelect with random pivot', 'Binary search on the value range'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'What is the time complexity of inserting a node at the head of a singly linked list?',
            'options'       => ['O(n) — must traverse to the tail', 'O(log n)', 'O(1) — update head pointer only', 'O(n log n)'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'Which paradigm does dynamic programming primarily exploit?',
            'options'       => [
                'Greedy choice at every step',
                'Overlapping subproblems and optimal substructure',
                'Divide-and-conquer without overlap',
                'Exhaustive depth-first backtracking',
            ],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'Which binary tree traversal visits BST nodes in ascending sorted order?',
            'options'       => ['Pre-order: root → left → right', 'Post-order: left → right → root', 'In-order: left → root → right', 'Level-order BFS'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'What is the worst-case time complexity of QuickSort?',
            'options'       => ['O(n log n)', 'O(n)', 'O(n²) — pivot always smallest or largest', 'O(log n)'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'When all edge weights are non-negative, which algorithm finds the shortest path most efficiently?',
            'options'       => ['Depth-First Search', 'Bellman-Ford', 'Dijkstra\'s algorithm', 'Floyd-Warshall'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'Which of the following is NOT a required property of a valid max-heap?',
            'options'       => [
                'The root node holds the maximum value',
                'Every parent is >= its children',
                'The tree is always a complete binary tree',
                'In-order traversal produces a sorted sequence',
            ],
            'correct_index' => 3,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'A function halves its input recursively and does O(n) work at each level. What is the total time complexity?',
            'options'       => ['O(n)', 'O(n log n)', 'O(log n)', 'O(n²)'],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'What type of problem does the two-pointer technique most efficiently solve?',
            'options'       => [
                'Detecting cycles in directed graphs',
                'Finding pairs in a sorted array satisfying a condition in O(n)',
                'Rebalancing a binary search tree after insertions',
                'Computing all-pairs shortest paths in a weighted graph',
            ],
            'correct_index' => 1,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'What is the time complexity of building a binary heap from n unsorted elements using bottom-up heapify?',
            'options'       => ['O(n log n)', 'O(n²)', 'O(n)', 'O(log n)'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'Which data structure is best for implementing breadth-first search (BFS)?',
            'options'       => ['Stack (LIFO)', 'Max-Priority Queue', 'Queue (FIFO)', 'Double-ended Deque'],
            'correct_index' => 2,
        ],
        [
            'tier'          => 'hard',
            'text'          => 'What is the optimal time complexity for finding the max-sum subarray of size k using a sliding window?',
            'options'       => ['O(n*k) — recompute each window', 'O(n log n) — sort and scan', 'O(n) — slide and update in constant time', 'O(k log n) — priority queue'],
            'correct_index' => 2,
        ],
    ];
}

// ── Build the 15-question game pool ──────────────────────────
// Filters by tier, shuffles within each tier, slices to 5 per tier
// Returns array of 15 question arrays in game order (easy→medium→hard)
function build_game_pool(): array {
    $bank = get_question_bank();

    $easy   = array_values(array_filter($bank, fn($q) => $q['tier'] === 'easy'));
    $medium = array_values(array_filter($bank, fn($q) => $q['tier'] === 'medium'));
    $hard   = array_values(array_filter($bank, fn($q) => $q['tier'] === 'hard'));

    shuffle($easy);
    shuffle($medium);
    shuffle($hard);

    return array_merge(
        array_slice($easy,   0, 5),
        array_slice($medium, 0, 5),
        array_slice($hard,   0, 5)
    );
}

// build_game_pool() defined above — called in game.php on fresh game init
// Pool: 5 random easy + 5 random medium + 5 random hard = 15 questions
// Uses array_filter(), shuffle(), array_slice() as required by rubric
