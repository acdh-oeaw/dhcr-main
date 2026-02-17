# DHCR Technical Documentation

## Introduction
The Digital Humanities Course Registry (DHCR) web application exists since 2014 and provides an up-to-date and curated overview of courses
in the area of Digital Humanities, in Europe and beyond. <br>
It is a responsive web application.

In general, courses can be divided into two categories:
1. *Activities* (events with a start date, end date and a location)
2. *Digital objects* (like training materials available online)

The DHCR is there to register and present the *Activities*.<br>
The *Digital objects* can be registered in DARIAH Campus.

The curation process includes:
- Manual approval of new user accounts
- Manual approval of new courses
- Automated hiding of outdated courses, showing only recent updated courses
- Automated sending of email reminders to course owners with request to update outdated courses


## Relevant resources

### Web application
https://dhcr.clarin-dariah.eu/

### API
https://dhcr.clarin-dariah.eu/api/v2/

### API Documentation
https://app.swaggerhub.com/apis-docs/hashmich/DHCR-API

### Release notes
#### Latest (dev branche)
[RELEASE_NOTES.md - dev](RELEASE_NOTES.md)
#### Production
[RELEASE_NOTES.md - prod](https://github.com/acdh-oeaw/dhcr-main/blob/prod/documentation/RELEASE_NOTES.md)

### Open issues on GitHub
https://github.com/acdh-oeaw/dhcr-main/issues


## User roles, access & processes

### Public - non-login user
Everybody can view all courses as well as the course details, without an account or login.

### Course contibutor
To enter a new course or maintain course data, it's required to create an account first. The default role
of a new user account is course contributor. Before it can be used, the user account has to be manually approved by a national moderator or administrator.

#### Responsibilities
- Entering own courses and keeping this information up-to-date (reminder emails are sent)

#### Available tools
- Enter new courses
- View outdated and all own courses
- Update / edit own existing courses
- Unpublish own courses (f.e. in case they don't take place anymore)
- Change profile settings:
    - Email address
    - Password
    - (Un)subscribe to the mailing list
    - Edit profile: title, first name, last name
    - View dedicated Course Contributors FAQ

#### User Registation Process
The are two different paths available
##### Option 1 - User registers
By using:

https://dhcr.clarin-dariah.eu/users/register
##### Option 2 - Moderator invites
By using:

Dashboard / Contributor Network / Invite User<br>
https://dhcr.clarin-dariah.eu/users/invite

![User registation process](images/user_registration_process.png)

### National Moderator
The user account can be "upgraded" from course contributor to national moderator by changing the user role. This can be done by an Administrator. National moderators are responsible for the curation of a specific country. This country is based on the location of the institution the user is associated with. One National Moderator can moderate only one country.
For most countries a national moderator is available. In case there isn't, an administrator needs to take over the moderator tasks for that specific country.

#### Responsibilities, specific for their country
- Approval of new user accounts
- Approval of new courses
- Contacting course contributors when courses are outdated for a long time (reminder emails are sent)
- Maintaining master data for cities
- Maintaining master data for institutions
- Periodically reviewing the course data (f.e. check for outdated descriptions)

#### Available tools
- The same as course contributors, and also specific in their country:
    - View and approve new user accounts
    - View and approve new courses
    - Invite new users (shorter process & custom language, all countries)
    - View pending invitations
    - View outdated and all courses
    - Update / edit courses
    - View and edit users
    - View, add, edit master data for cities
    - View, add, edit master data for institutions
    - View dedicated National Moderators FAQ
    - View DHCR process explanation: "Users, Access and Workflows" (predecessor of this document)

#### Course Entry Process
![Course Entry Process](images/course_entry_process.png)


### Administrator
Administrator is the "highest" role in the application and has access to everything and for all countries.

#### Responsibilities
- National Moderator tasks in countries where no moderator is available
- Assigning National Moderators to a country
- Maintain the public list of National Moderators https://dhcr.clarin-dariah.eu/national-moderators
- Maintain the FAQs for: public, course contributor, national moderator

#### Available tools
- The same as National Moderators and also:
    - All National Moderator tasks, for all countries
    - View all external resouces added to courses
    - View, edit all moderators (special list)
    - Maintain Master Data for:
        - Countries
        - Languages (of a course)
        - Translations of user invitations
    - Maintain the 3 types of FAQ's, for:
        - Public
        - Course contributor
        - National moderator
    - View application log (includes error messages)
    - View statistics (summary, course and user) and app info (software versions)

#### Admin Main Dashboard
![Admin Main Dashboard](images/admin_main_dashboard.png)

[Large image](images/admin_main_dashboard-large.png)

#### Admin Category Lists
![Admin Main Dashboard](images/admin_category_lists.png)

[Large image](images/admin_category_lists-large.png)


## Courses

### Course curation
The course curation process includes manual approve of user accounts and of the courses upon entry. All changes to a course afterwards, are show public immediately, without any approval.
A moderator could check the contents of the courses in their country, and contact contributors if the content is outdated or not correct. A special list is available for this, called "Moderated courses". This list is only available to moderators.

#### Course expiration times
To help the course maintainers, a traffic-light colour is used in the list of courses to indicate their status: 
- Green - actively maintained
- Orange - needs to be updated
- Red - not shown in the public registry (only in the login area)

Process:
1. When a new course is entered into the registry, its status is green in the list.
2. After 10 months, the course owner receives emails to update the course metadata. The course status stays green on the list.
3. After 12 months, the moderator will be on the CC of the reminder emails. The course status is orange.
4. After 16 months, the course is not shown in the public registry anymore, but it is still available in the login area. The course status turns red in the list.
5. After 24 months, the course is archived: it is not visible in the public registry or accessible in the login area. The course is still available through the API to keep the history available.

#### Course expiration reminder emails
As described above, reminder emails with the request to check and update the course data are sent. After 10 months only to the course owner, after 12 months the national moderator is included on the CC.

The check on outdated courses and the sending of the mails happpens 2 times a month. See the chapter cron jobs for the exact days.

The content of the reminder mail can be found in:
templates/email/text/course_reminders/reminder.php

The exact process can be found in the code:
src/Command/CourseRemindersCommand.php

When this commend is executed, also the old log enties (> 3 months), are cleaned up (removed).

The result of the process is logged and can be viewed in the login area (Log Entries). There is one log line for every mail sent and one final log line with the summary result.
This way, errors or results can be traced easy.


## Data model for course and related entities
The data structure can be found by logging into Phpmyadmin and viewing the tab "Structure". Most of the data fields and table names have self explaining names.

The main entity of the application is a course, this consists of the following entities:
#### 1:1
- country
- city
- institution
- course parent type
- course type
- language
- course duration unit
#### 1:N
- external resouces
#### N:M
- tadirah activities
- tadirah objects
- tadirah techniques
- disciplines

#### Other entities are:
- users, user_roles
- logentries
- invite_translations (translations of the user invite message)
- faq_questions, faq_categories


## Extra features

### User invitation and translated message
When choosing Option 2 in the chapter "User Registation Process", the moderator can select a language for the invitation message.
There is a list of multiple languages available. This consists of static, manually translated invitation messages.
The moderator can only select a language from the list, then the predefined text will be used.

The adminstrators can also add new translations and manage existing ones.

### Public moderator list
The public moderator list is available here:
https://dhcr.clarin-dariah.eu/national-moderators

In can be maintained by the admins, in the login area. There is a special list (Contributor Network -> Moderators). Where they can add photo's and edit the other diplayed fields.

### FAQ's
There are three types of FAQ available, depending on login/user role: public, course contributor and national moderator.

They can be found here:
- https://dhcr.clarin-dariah.eu/faq/public
- https://dhcr.clarin-dariah.eu/faq/contributor
- https://dhcr.clarin-dariah.eu/faq/moderator

The admins can manage the FAQ question and answer pairs. It's possible to add a link and change the order in which the questions are shown. By changing the category, the questions can be moved to a different type of FAQ.

### Review reminders
The review reminders are meant to assist the non-technical collegues on the project, by reminding when issues are pending "in review" and are waiting for their feedback.

The GitHub API is used and checked how many open issues contain the label "inreview". When there are one or more issues with this label, the mails are sent to all the useradmins.

The email contains:
- the amount of open issues in review
- link to the overview of those issues
- a random chosen one-liner to keep up the motivation (static coded array in the code, see below)
- an explanation why it's important to provide feedback quickly

The content of the email:
templates/email/text/review_reminders/review_reminder.php

The exact process:
src/Command/ReviewRemindersCommand.php

The frequency can be found in the chapter "Cron Jobs".

The result, both in case of success or failure is logged and available at "Log Entries".

### Log entries
This is available in the login area at "Category Lists".

The newer parts of the application use this for logging. Legacy parts of the application send an CC to a specific emailaddress instead of logging in the database.

It's possible to view all the log enties or only errors (code >= 50).

The available log codes:
- 10 - Notification
- 20 - Sent email (not implemented yet, should replace legacy logging)
- 30 - Automated problem fixing (course reminders, etc.)
- 50 - Non-fatal error
- 90 - Fatal error

Both the data structure of the table log enties as well as the minimalistic and simple view of the log enties provide possiblities for furthur development and addition of more futures.
There was no time available to implement filters, etc. for showing the log entries.

The older log enties (> 3 months), are cleaned up (removed) when the course reminders command is executed. That happens usually 2 times a month. See chapter "Cron Jons" for specific info.


## Development process

### Instances

There are three instances running.<br>
<br>
Changes or new developments are committet to the dev branche and deployed in the dev instance, the test instance is used for the non techincal collegues to test/review new features or changes. And only after succesfull testing it's deployed to production.

Both the test and dev instance are proteced by an additional password (.htaccess) to restric access to non-tested features to a closed user group.
#### Production instance:<br>
https://dhcr.clarin-dariah.eu/

#### Test instance:<br>
https://test-dhcr.clarin-dariah.eu/

#### Dev instance:<br>
https://dev-dhcr.clarin-dariah.eu/



### Github Issues

#### Labels
Lower case, easy writable, to be compatible with the github cli tool
https://cli.github.com/

##### Part of application
frontend - Public accesible part<br>
admin - Everything after using the login

##### Kind of issue
bug - something isn't working<br>
featurerequest - when is does work it is not u bug and thus a feature request<br>
documentation - improvements or additions to documentation<br>
maintainance - to be used by developer to indicate maintaince tasks
This could be tasks which don't add features, but are needed to provide reliable
operation of the application now and in the future.<br>
(Example: PHP or framework version upgrades)<br>
Optional: lowprio<br>

##### Status of issue
specsmissing - non technical collegues need to specify more clearly what's needed<br>
todo - ready to be developed<br>
indev - current work<br>
inreview - needs to de tested<br>
done - flag added by non techincal collegues when issue is reviewed<br>
closing the issue - only done by developer, after checking that all releated tasks are finished<br>
blocked - another process is blocking the progress of the issue<br>

### Cron jobs
The following cron jobs are running, they can be found in /src/Command under the corresponding filenames:

#### CourseReminders
Sends the emails with the course reminders, see explananion in chapter above.<br>
Scheduled at:<br>
Every 4th and 19th day of a month at 8:30 hours.

#### Generate sitemap
Genarates a sitemap which is also submitted to Google.
<br>
Scheduled at:<br>
Every day at 3:50 hours.

#### Generate searchlist
Genarates the list needed for the autocomplete in the searchbar.<br>
Scheduled at:<br>
Every day, every hour at the 15th and 45th minute.

#### Review reminders
Sends reminder emails when issues are waiting to be reviewd/tested, see explananion in chapter above.<br>
Scheduled at:<br>
Every week at tuesday at 9:30 hours.

All times are in UTC.

### Jobs executed on deployment
They can be found in webroot/entrypoint.sh<br>
- Enable PHP intl module (important!) and set PHP path, see includes.sh
- Generate autocomplete list for searchbar
- Generate sitemap
- Start webserver

### Used technologies
The application uses the framework CakePHP, currently version 4.6.x and uses PHP, currently 8.3.x.<br>
The main page uses mainly JavaScript. Some pages use Jquery. The maps are displayed using Mapbox and Leaflet and the pins on the main page are shown using a plugin for leaflet.
<br>
<br>
Although some items use a CDN, a lot of the libraries are "hard coded" / stored in the repo itself.