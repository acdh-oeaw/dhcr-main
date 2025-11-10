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
A moderator could check the contents of the courses in their country, and contact contributors if the content is outdated or not correct. A special list is available for this, called "Moderated courses".

#### Expiration times
To help the course maintainers, a traffic-light colour is used in the list of courses to indicate their status: 
- Green - actively maintained
- Orange - needs to be updated
- Red - not shown in the registry

Process:
1. When a new course is entered into the registry, its status is green in the list.
2. After 10 months, the course owner receives emails to update the course metadata. The course status stays green on the list.
3. After 12 months, the moderator will be on the CC of the reminder emails. The course status is orange.
4. After 16 months, the course is not shown in the public registry anymore, but it is still available in the login area. The course status turns red in the list.
5. After 24 months, the course is archived: it is not visible in the public registry or accessible in the login area. The course is still available through the API to keep the history available.


#### Reminders
...

## Data model for course and related entities


## Extra features

### User invitation and translated message

### Public moderator list

### FAQ's

### Review reminders

### Log entries
- Log codes


## Development process

### Instances


Both the test and dev instance are proteced by an additional password (.htaccess) to restric access to non-tested features to a closed user group.
- 3 instances

Production instance:<br>
https://dhcr.clarin-dariah.eu/

Test instance:<br>
https://test-dhcr.clarin-dariah.eu/https://test-dhcr.clarin-dariah.eu/https://test-dhcr.clarin-dariah.eu/

Dev instance:<br>
https://dev-dhcr.clarin-dariah.eu/

### Github Issues

#### Labels
Lower case, easy writable, to be compatible with the github cli tool
https://cli.github.com/

Part of application
frontend - Public accesible part
admin - Everything after using the login

Kind of issue
bug - something isn't working
featurerequest - when is does work it is not u bug and thus a feature request
documentation - improvements or additions to documentation
maintainance - to be used by developer to indicate maintaince tasks
This could be tasks which don't add features, but are needed to provide reliable
operation of the application now and in the future
(Example: PHP or framework version upgrades)
Optional: lowprio

Status of issue
specsmissing
todo
indev
inreview
done
closing the issue
blocked

#### Workflow

TODO: draw flow

### Cron jobs
These can be found in /src/Command
Scheduled times are listed below

#### CourseReminders

#### Generate sitemap

#### Generate searchlist

#### Review reminders

### Jobs executed on deployment

### Used technologies
