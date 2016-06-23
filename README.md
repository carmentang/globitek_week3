# Project 3 - Globitek Forgery, Theft, and Hijacking Prevention

Time spent: 12 hours spent in total

## User Stories

The following **required** functionality is completed:

Configure Sessions
- [x] Only allow session IDs to come from cookies
- [x] Expire after one day
- [x] Use cookies which are marked as HttpOnly

Login Page
- [x] An error message for when the username is not found (security through obscurity)
- [x] An error message for when the username is found but the password does not match
- [x] After a successful login, store the user's ID in the session data (as "user_id").
- [x] After a successful login, store the user's last login time in the session data (as "last_login").
- [x] Regenerate the session ID at the appropriate point to prevent Session Fixation.

Require Login
- [x] Add a login requirement to almost all staff area pages. Determine which two pages do not need to require a login (login.php & logout.php)
- [x] require_login() includes a call to determine if last_login_is_recent() but the function does not have proper code. Write code which will only consider a request as being "recent" if the user's last login was less than 1 day ago.

Logout Page
- [x] Notice that "public/staff/logout.php" and "private/auth_functions.php" already include much of the code needed for allowing a user to login to the staff area. You should complete it by adding code to destroy the user's session file after logging out.

CSRF Protections
- [x] Only process forms data sent by POST requests. (This is already the case unless you change it.)
- [x] Confirm that the referer sent in the requests is from the same domain as the host.
- [x] Create a CSRF token.
- [x] Store the CSRF token in the user's session.
- [x] Add the same CSRF token to the login form as a hidden input.
- [x] When submitted, confirm that session and form tokens match.
- [x] If the tokens do not match, you can should show a simple error message which says "Error: invalid request" and exits.
Make sure that legitimate use of the states/new.php and states/edit.php pages by a logged-in user still works as expected.

Pen-Testing
- [x] Ensure the application is not vulnerable to XSS attacks.
- [x] Ensure the application is not vulnerable to SQL Injection attacks.
- [x] Run all tests from Objective 1 again and confirm that your application is no longer vulnerable to any test.

The following advanced user stories are optional:
- [x] Bonus Objective 1: Objective 4 (requiring login on staff pages) has a major security weakness because it does not follow one of the fundamental security principals. Identify the principal and write a short description of how the code could be modified to be more secure. Include your answer in the README file that accompanies your assignment submission.
==> It violates the "Least Privilege & Never Trust Users" fundamental security principles because a valid user can modify other user's information. We should only give the user privileges that are essential to that user's work. They should be able to modify their own user information, but not other's. They also should not be able to add users because they could create accounts for other malicious individuals. Instead, we should separate out users and administrator accounts, with the administrators having access to everything.
- [x] Bonus Objective 2: Add CSRF tokens and protections to all of the forms in the staff directory (new, edit, delete). Make sure the request is the same domain and that the CSRF token is valid.
- [x] Bonus Objective 3: Add code so that CSRF tokens will only be considered valid for 10 minutes after creation.
- [x] Bonus Objective 4: Only consider a session valid if the user-agent string matches the value used when the user last logged in successfully.
- [x] Advanced Objective: Create two new pages called "public/set_secret_cookie.php" and "public/get_secret_cookie.php". The first page will set a cookie with the name "scrt" and the value "I have a secret to tell.". Before storing the cookie, you need to both encrypt it and sign it. You can use any (two-way) encryption algorithm you prefer. When the second page loads, it should read the cookie with the name "scrt", and then—if it is signed correctly—decrypt it. If it is not signed correctly then it should display an error message and skip decryption altogether.


## Video Walkthrough

Here's a walkthrough of implemented user stories:

<img src='http://imgur.com/yOq4VQG' title='Video Walkthrough' width='' alt='Video Walkthrough' />

GIF created with [LiceCap](http://www.cockos.com/licecap/).

## Notes

- Trying to figure out if it is still vulnerable to XSS, CSRF & SQLI attacks (outside of the tests).
- Referrer check fails if host URL includes port number--fixed it through using explode method in the request_is_same_domain() in functions.php.
- There was a typo in the starter code of show.php of territories:
-> "$state_result = find_territory_by_id($state_id))" and should be "$state_result = find_state_by_id($state_id)";
- Had problem with using Encryption/Decryption methods in PHP using AES because mcrypt was not installed on PHP 7.0. Installed it using apt-get,
restarted Apache, and worked.
- Advanced objective: Generates new key every time we set a new cookie. Get cookie page only displays secret if the signature is validated and then decrypted.

## License

    Copyright [Carmen Tang] [name of copyright owner]

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
