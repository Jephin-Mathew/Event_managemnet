# Event Management System

This is a simple event management web application built with Laravel and Livewire. It allows users to create events, invite others, manage requisition lists for event resources, and upload/view gallery photos for each event.

## Setup & Installation

1. **Clone the repository**
git clone https://github.com/Jephin-Mathew/Event_managemnet.git
cd Event_managemnet


2. **Install dependencies**
composer install
npm install
npm run build


3. **Configure environment**
cp .env.example .env


Then open the `.env` file and update the database configuration:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_management
DB_USERNAME=root
DB_PASSWORD=


4. **Generate application key**
php artisan key:generate


5. **Run migrations**
php artisan migrate


6. **Start the development server**
php artisan serve


Open `http://127.0.0.1:8000` in your browser to access the app.

## Features

- **Authentication**
- Register, login, and email verification.
- “Remember Me” support and password reset.

- **Event Creation**
- Create events for self or for another user.
- Specify event title, date, time, type, and optional guidelines.

- **Invitations**
- Invite multiple users to an event.
- Users can respond to invitations (Accept/Reject).

- **Requisition List**
- Creators or the event’s target user can add items.
- Visibility options: public (any user can view) or private (only invited users).
- Invited users who accepted can claim unclaimed items.
- Gift and optional items can be claimed even if already claimed.

- **Gallery**
- Users who are invited and accepted can upload photos.
- Everyone involved can view photos even after the event ends.

- **UI**
- Clean and consistent layout with responsive design.
- Simple navigation for all pages with intuitive access to event-related actions.

## Approach

- Built using Laravel 12 with Livewire and Volt for reactive components and form handling.
- Follows MVC structure with Livewire components managing event, invitation, requisition, and gallery logic.
- All routes are protected by authentication middleware.
- Authorization rules and relationships are handled in Eloquent models and policies.
- Database migrations structure all entities, including users, events, invitations, requisition items, and photos.

## Assumptions

- Users must be authenticated to access the application.
- Users can only interact with events they created, are created for, or are invited to.
- Claimed items are locked unless marked as gift or optional.
- Photo uploads are only allowed for users who are invited and accepted the invitation.
- Gallery remains available after the event is over.

## Database

- Database name used: `event_management`
- No seeders are included; test data should be added via the UI.

## License

This project is open-source and available for educational/demo purposes.
