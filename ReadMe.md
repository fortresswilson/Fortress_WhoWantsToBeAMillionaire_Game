# Who Wants to Be a Millionaire

**Live Game URL:** `https://codd.cs.gsu.edu/~[your_username]/project2_millionaire/login.php` 

## Project Title & Description
Welcome to **Who Wants to Be a Millionaire**, a web-based trivia game built to test your knowledge on Web Programming, Computer Science concepts, and LeetCode-style algorithm logic. The game features a secure authentication system, a 15-level dynamic prize ladder, and an interactive session-based game engine. Every turn, lifeline activation, and score update is handled strictly by the server, ensuring players cannot cheat by inspecting the browser source code. We also integrated an AI advisor powered by the Anthropic API to give players contextual reasoning hints when they get stuck.

## Team Members
* **Ashwin Prabhu**
  * *Primary PHP Contribution:* Handled the Home Page setup and CSS styling, designed the Outcome Handling logic, and built the Leaderboard System.
* **Fortress Ezeuchenne**
  * *Primary PHP Contribution:* Developed the core Game Engine, compiled the questions, implemented the Authentication System, and integrated the AI Advisor API.

## Usage Guide
* **Register & Log In:** Start at `login.php` to securely create an account and log in.
* **Playing the Game:** Answer questions correctly to advance through the 15 levels of the prize ladder.
* **Lifelines:** If you get stuck, activate your server-side lifelines, including the Anthropic-powered AI Advisor hint.
* **Winning & Losing:** Secure your winnings by walking away, or risk it all. Incorrect answers will drop you down to the last guaranteed safe-haven prize tier.
* **The Leaderboard:** Once your game concludes, check the leaderboard to see how your score stacks up against other registered players.

## Setup Instructions (CODD Server Deployment)
This project is set up to run directly on the university CODD server.
* **PHP Version:** Ensure the server is running PHP 7.4 or higher.
* **File Upload:** Upload the entire project folder to your `public_html` directory.
* **File Permissions:** Make sure the JSON flat files (`users.json` and `scores.json`) in the data folder have the correct write permissions so the application can store user accounts and update the leaderboard.
* **Starting Point:** Navigate to `login.php` in your browser to begin.

## AI Disclosure
We integrated the Anthropic API directly into our game engine to serve as an interactive "AI Advisor" lifeline, providing players with conceptual reasoning hints. We also used AI tools to help brainstorm some of the computer science trivia questions and troubleshoot minor syntax issues during development.

## Development Journal & Challenges
Building a secure game engine required us to make some important architectural decisions. Here is how we handled the hurdles:

* **Preventing Cheating:** We initially considered passing the game state (current level, score, and lifelines) through URL parameters (e.g., `game.php?level=5`). However, players could easily edit the URL to skip straight to the million-dollar question. We fixed this by using server-side `$_SESSION` variables, making the game state tamper-proof.
* **Global Leaderboard:** We originally tried storing user accounts and scores inside `$_SESSION`. We quickly realized sessions are browser-scoped, meaning players couldn't see each other's scores. We pivoted to using JSON flat files (`users.json` and `scores.json`) to ensure the leaderboard data persists globally for all users.
* **Global Updates:** Managing changes across multiple files was a headache. We adopted a DRY (Don't Repeat Yourself) architecture by centralizing our application data into a single `config.php` file required at the top of every secured page. We also injected our navigation bar globally so we only have to update links in one place.
* **Teamwork:** We used GitHub to maintain an organized history of our codebase. By prioritizing meaningful commit messages and pushing code in distinct functional chunks, we avoided massive merge conflicts. We also used a shared task tracker to divide the workload and stay on schedule for submission.
