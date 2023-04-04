# Release notes

## Version 2023-03

### Changes
- x

### Small changes
- Updated explanation at contact us and national moderators to point to the new helpdesk email address #42
- Added explanation at add/edit course for the case an institution is not in the list #58
- Changed from and cc email addresses to new stucture #42
- Introduced "reply to" email address #42
- Upgraded dependencies to recent versions

### Bug fixes
- Fix: User edit page does not save data when changing user role #60
- Fix: Confusing UI response on instant new user account approval #64
- Fix: Don't show alternative field in new user account approval mail, when user selected an institution
- Fix: Make institution name available in new user approve mail


## Version 2023-02

### Changes
- Implemented notification mail for moderators when a new course is waiting for approval #54 
- Migrated API v1
    - to the latest version of the framework (4.4)
    - to PHP 8.1
- Migrated API v2
    - to the latest version of the framework (4.4)
    - to PHP 8.1
- Migrated the main application [dhcr-main]
    - to the latest version of the framework (4.4)
    - to PHP 8.1

### Small changes
- Changed date format in user approval mail to ISO format
- Added App Info section (shows version numbers of dependencies) to statistics dashboard
- Added CC (legacy logging) for user approval mail
- Enabled debug mode for dev instance
- Changed column name "active" to "published" in all the course lists in the admin area
- Optimized sorting in Pending Invitations
- Added release dates for all previous versions to release notes


## Version 2022-12
*Release date: 2022-12-29*
 
### Small changes
- Updated date to ISO format in views
- Show newest log entry on top
- Added statistics for amount of outdated courses per country to course statistics
- Added traffic light for moderator participation to users statistics

### Bug fixes
- Fixed subscribing for course alerts and editing preferences
- Added unique for institution name; allow only one institution with the same name


## Version 2022-11/3
*Release date: 2022-12-28*

### Bug fixes
- Fix: Adding moderator to list, without photo upload
- Fix: Move moderator list to separate page, to avoid acordeon problem with a huge amount of content


## Version 2022-11/2
*Release date: 2022-12-06*

### New features
- National Moderators List
  - New public section, at the Info page, which shows information and photo of the moderators
  - New options in the backend (at user view/edit) where admins can upload a photo and enable public display

### Bug fixes / small changes
- Added graph to show how many courses will be archived soon
- Added list of 15 latest added courses to course statistics page
- Hidden filter buttons for Objects and Techniques
- Fix: Show all pending invitations when admin is also mod


## Version 2022-11/1
*Release date: 2022-11-10*

### New features
- FAQ questions and answers are added and shown for public, contributors and moderators

### Bug fixes / small changes
- Updated path for course reminders command to match new environment


## Version 2022-10
*Release date: 2022-10-31*

### New features
- Added list of moderators to the Contributor Network Dashboard (for admins only).

### Bug fixes / small changes
- Fix: Course duration units handling for add course
- Fix: Not approved courses are public visible #21
- Fix: Need to clear the contact form after succesful a sending message


## Version 2022-09
*Release date: 2022-10-27*

### New features
- FAQ Questions (the lists with questions are currently hidden, until content is added)
    - Displays a list of questions & answers pairs, based on login type, for:
      - Public (no login)
      - Contributor
      - Moderator
    - Features in the backend for admins: 
      - Add/edit
      - If necessary, add link title and url
      - Publish/Unpublish
      - Change order in which the items are shown
      - Move items between the lists for different login types
    - Everybody can read the public FAQ, without login
    - Contributors and Moderators can find their FAQs in the Help Dashboard, based on their user role.
      - Moderators can also access the Contributors FAQ
      - Administrators can access all FAQs
- Statistics
  - Summary Statistics, with numbers about:
    - Courses
    - Users
    - Institutions
    - Countries
    - Cities
    - FAQ Questions
    - Translations for the invite mail
  - Statistics about courses
  - Statistics about the number of users, moderators and admins

### Bug fixes / small changes
- Added social media section to menu
- Added link to release notes in UI
- Updated icons and button texts to be consistent


## Version 2022-08
*Release date: 2022-08-22*

### New features
- Transfer Course
    - Transfer a course to another user, in case somebody else will be teaching the course in the future
- Pending Invitations
    - Overview of invitations which has been sent to new users, including expiry time
    - Reinvite: possibility to send the invitation again, f.e. when the link has been expired
- Explanation for Moderators and Administrators
    - Topics:
      - Access and User Roles
      - How to Create an Account
      - Course expiry process
- Course expiry reminders
    - Reimplemented sending reminder mails for expired courses, incl. logging
- Added new user interface item to view log
- Introduced release notes
- Added date picker / input validation for start dates (at Add Course)

### Bug fixes / small changes
- Various text corrections / updates
- Removed duplicated social media links at info#publications
- Added timezone to password reset mail, to avoid confusion about expiry time
- Converted course expiry periods to months, to have the same unit everywhere in the application
- Added default email subject prefix to invite and reinvite emails


## Version 2022-05
*Release date: 2022-05-27*

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
