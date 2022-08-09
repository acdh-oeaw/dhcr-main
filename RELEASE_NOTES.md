# Release notes

## Version 2022-test

### New features
- Transfer Course
    - Transfer a course to another user, in case somebody else will be teaching the course in the future
- Pending Invitations
    - Overview of invitations which has been sent to new users, including expiry time
    - Reinvite: possibility to send the invitation again, f.e. when the link has been expired
- Explanation of processes for Moderators and Administrators
    - Topics: User roles, Account creation, Course expiry process, Emails sent by the application
- Course expiry reminders
    - Reimplemented sending reminder mails for expired courses, incl. logging
- Added new user interface item to view log
- Introduced release notes
- Version number display in user interface (at Info)
- Added date picker / input validation for start dates (at Add Course)

### Bug fixes / small changes
- Various text corrections / updates
- Removed duplicated social media links at info#publications
- Added timezone to password reset mail, to avoid confusion about expiry time
- Converted course expiry periods to months, to have the same unit everywhere in the application
- Added default email subject prefix to invite and reinvite emails


## Version 2022-05
This is a major release which contains a lot of big changes. The complete login area is new implemented as well as several backend processes. Also new features were added.

### Key points
- Clear user interface
- Self explaining, no manual or video tutorials needed
- New created menu structure
- Three ways of navigating: 
    1. Dashboards / tiles
    2. Menu
    3. Breadcrumbs
- Depending on the user role, additional options are available in the user interface (contributor -> moderator -> administrator)
- Revised texts and instructions for users


### New features
- A user can be administrator ***and*** moderator with the same account
- Notification area
    - Directly shows the number of items which needs attention
    - Reminder to subscribe mailing list
- Needs attention
    - Expired courses
    - Course approval
    - Account approval
- Administrate courses
    - Moderated courses
        - Overview of courses in the moderated country
    - All courses
- Contributor network
    - Invite user
        - Invitation mail can be sent in local languages
        - Page restructured for easier use
    - Moderated users
        - Overview of users in the moderated country
        - View user
            - Easy account troubleshooting
        - Edit user
            - Assign user to other institution
    - All users
- Category lists
    - Easy add or change related data
        - Cities, Institutions, Languages, Translations

### Reimplemented features from old version
- Administrate courses
    - Add course
    - My courses
- Profile settings
    - Change email
    - Change password
    - Subscribe to mailing list
    - Edit profile