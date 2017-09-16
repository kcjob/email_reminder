# email_reminder
Version 2 
T

This is a complete version of a email reminder PHP script.
It checks wether the user has opted out. It also combines all the Sessions so that the information is 
sent in one email.

Main parts are:

1. Create a list of users who did not optout
2. Gather all sessions per user 
3. Send list of sessions to user as a reminder a day or two before
4. Allow user to optout
