# TicketFlow - Twig/PHP Implementation

A comprehensive ticket management application built with PHP and Twig templating engine. This project demonstrates server-side rendering with PHP, Twig templates, and JSON-based data persistence.

## 🚀 Features

- **Landing Page**: Hero section with wavy SVG background and decorative circular elements
- **Authentication System**: Secure login/signup with session management via PHP sessions
- **Dashboard**: Real-time ticket statistics with color-coded status indicators
- **Full CRUD Operations**: Create, Read, Update, Delete tickets with validation
- **Responsive Design**: Mobile-first approach that works seamlessly across all devices
- **Form Validation**: Server-side validation with user-friendly error messages
- **Flash Messages**: Success and error feedback system using PHP sessions
- **Protected Routes**: Server-side route protection with session checks

## 🛠️ Technologies Used

- **PHP 8.0+**: Server-side scripting language
- **Twig 3.x**: Template engine for PHP
- **Composer**: Dependency management
- **JSON Files**: Data persistence for tickets and users
- **Tailwind CSS**: Utility-first CSS framework (via CDN)
- **Vanilla JavaScript**: Client-side interactivity

## 📦 Installation & Setup

### Prerequisites

- PHP 8.0 or higher
- Composer
- Apache/Nginx web server (or PHP built-in server for development)
- mod_rewrite enabled (for Apache)

### Step-by-Step Installation

1. **Clone or create the project directory**

```bash
mkdir ticketflow-twig
cd ticketflow-twig
```

2. **Install Composer dependencies**

```bash
composer install
```

3. **Set up directory structure**
   Create the following directories if they don't exist:

```bash
mkdir -p data public/css public/js src/Controllers src/Models templates/auth templates/tickets
```

4. **Set proper permissions**

```bash
chmod 755 data
chmod 644 data/*.json
```

5. **Configure web server**

**For Apache:**

- Ensure `.htaccess` files are in place
- Verify `mod_rewrite` is enabled
- Set document root to `/path/to/ticketflow-twig/public`

**For PHP Built-in Server (Development):**

```bash
php -S localhost:8000 -t public
```

6. **Open your browser**
   Navigate to `http://localhost:8000` (or your configured domain)

## 📁 Project Structure

```
ticketflow-twig/
├── public/
│   ├── index.php              # Application entry point & router
│   ├── .htaccess              # Apache rewrite rules
│   ├── css/
│   │   └── style.css          # Custom styles & Tailwind imports
│   └── js/
│       └── app.js             # Client-side JavaScript
├── src/
│   ├── Controllers/
│   │   ├── AuthController.php        # Authentication logic
│   │   ├── DashboardController.php   # Dashboard display
│   │   └── TicketController.php      # Ticket CRUD operations
│   ├── Models/
│   │   ├── User.php           # User model & authentication
│   │   └── Ticket.php         # Ticket model & validation
│   └── Session.php            # Session management helper
├── templates/
│   ├── layout.twig            # Base layout template
│   ├── landing.twig           # Landing page
│   ├── dashboard.twig         # Dashboard
│   ├── auth/
│   │   ├── login.twig         # Login page
│   │   └── signup.twig        # Signup page
│   └── tickets/
│       ├── index.twig         # Ticket list
│       └── form.twig          # Create/Edit ticket form
├── data/
│   ├── tickets.json           # Ticket storage
│   └── users.json             # User storage
├── vendor/                    # Composer dependencies
├── composer.json
├── .htaccess                  # Root Apache config
└── README.md
```

## 🔐 Test Credentials

The application uses simulated authentication. You can use any credentials that meet these requirements:

- **Email**: Any valid email format (e.g., `demo@test.com`, `user@example.com`)
- **Password**: Minimum 6 characters (e.g., `password`, `123456`)

Example:

- Email: `demo@test.com`
- Password: `password`

## 📱 Component Overview

### Controllers

#### 1. AuthController

- Handles login and signup pages
- Processes authentication forms
- Manages user sessions
- Handles logout functionality

#### 2. DashboardController

- Displays dashboard with statistics
- Requires authentication
- Shows ticket summaries

#### 3. TicketController

- Lists all tickets
- Creates new tickets
- Edits existing tickets
- Deletes tickets
- Validates ticket data

### Models

#### 1. User Model

- Simulates user authentication
- Validates email format
- Checks password requirements
- Manages user data in JSON file

#### 2. Ticket Model

- CRUD operations for tickets
- Validates ticket data
- Calculates statistics
- Persists data to JSON file

### Templates

All templates extend `layout.twig` for consistent structure.

#### 1. landing.twig

- Hero section with SVG wave
- Three feature cards
- CTA buttons

#### 2. auth/login.twig & auth/signup.twig

- Form with validation
- Flash message display
- Decorative circles

#### 3. dashboard.twig

- Statistics cards
- Quick action buttons
- Navigation bar

#### 4. tickets/index.twig

- Ticket grid display
- Status badges
- Edit/Delete actions
- Empty state

#### 5. tickets/form.twig

- Create/Edit form
- Dropdown selectors
- Form validation

## 🎨 Design System

### Color Palette

- **Primary**: Blue (#2563EB)
- **Secondary**: Purple (#9333EA)
- **Success/Open**: Green (#10B981)
- **Warning/In Progress**: Amber (#F59E0B)
- **Neutral/Closed**: Gray (#6B7280)

### Status Colors

- **Open**: Green background with green text
- **In Progress**: Amber background with amber text
- **Closed**: Gray background with gray text

### Layout Specifications

- **Max Width**: 1440px (centered on large screens)
- **Breakpoints**:
  - Mobile: < 640px
  - Tablet: 640px - 1024px
  - Desktop: > 1024px
- **Spacing**: Consistent Tailwind scale

## ✅ Validation Rules

### Authentication

- **Email**: Must be valid email format
- **Password**: Minimum 6 characters
- **Confirm Password**: Must match password (signup only)

### Ticket Creation/Update

- **Title**: Required, cannot be empty
- **Status**: Must be one of: `open`, `in_progress`, `closed` (mandatory)
- **Description**: Optional
- **Priority**: Optional (low/medium/high), defaults to medium

## 🔒 Security & Authorization

### Session Management

- Sessions managed via PHP's native session handling
- Session key: `ticketapp_session`
- Session data includes: email, user ID, login timestamp

### Protected Routes

- Dashboard and Ticket Management require authentication
- Unauthorized users redirected to login page
- Session checked on every protected route

### Logout Process

- Clears session data
- Redirects to landing page

## 🐛 Error Handling

The application handles:

1. **Invalid Form Inputs**:

   - Server-side validation
   - Flash messages for errors
   - Form data preservation on error

2. **Unauthorized Access**:

   - Automatic redirect to login
   - Session expiration handling

3. **Missing/Corrupted Data**:

   - JSON file validation
   - Automatic file creation
   - Error fallbacks

4. **File Permissions**:
   - Checks for writable data directory
   - Graceful degradation

## ♿ Accessibility Features

- **Semantic HTML**: Proper use of header, nav, main, footer
- **Form Labels**: All inputs have associated labels
- **ARIA Labels**: Added where appropriate
- **Keyboard Navigation**: All interactive elements accessible
- **Focus States**: Visible focus indicators
- **Color Contrast**: WCAG AA compliant

## 📊 Data Storage

### Session Data (PHP Session)

```php
[
  'email' => string,
  'id' => integer (timestamp),
  'loginTime' => ISO string
]
```

### Ticket Data (JSON File)

```json
{
  "id": "timestamp-random",
  "title": "string",
  "description": "string",
  "status": "open|in_progress|closed",
  "priority": "low|medium|high",
  "createdAt": "ISO string",
  "updatedAt": "ISO string"
}
```

### File Locations

- `data/tickets.json`: All tickets
- `data/users.json`: User data (if needed)

## 🔄 Routing

Simple PHP-based routing in `public/index.php`:

- `/` - Landing page
- `/login` - Login page (GET/POST)
- `/signup` - Signup page (GET/POST)
- `/logout` - Logout action
- `/dashboard` - Dashboard (protected)
- `/tickets` - Ticket list (protected)
- `/tickets/create` - Create ticket (protected)
- `/tickets/edit/{id}` - Edit ticket (protected)
- `/tickets/delete/{id}` - Delete ticket (protected)

## 🚧 Known Issues & Limitations

1. **No Database**: Uses JSON files for storage
2. **Single Server**: Not suitable for multi-server deployments
3. **File Locking**: No concurrent write protection
4. **Limited Scalability**: JSON files not ideal for large datasets
5. **No Real Authentication**: Simulated auth for demo purposes

## 🔮 Future Enhancements

- [ ] MySQL/PostgreSQL database integration
- [ ] Password hashing (bcrypt/Argon2)
- [ ] CSRF protection
- [ ] Rate limiting
- [ ] File upload support
- [ ] Email notifications
- [ ] Advanced search and filtering
- [ ] Pagination for large ticket lists
- [ ] User roles and permissions
- [ ] API endpoints
- [ ] Docker containerization

## 🧪 Testing

### Manual Testing

1. Test authentication flow
2. Create tickets with various statuses
3. Edit existing tickets
4. Delete tickets
5. Verify session persistence
6. Test logout functionality

### Server Requirements

- PHP 8.0+
- mod_rewrite (Apache) or equivalent
- Write permissions on `data/` directory

## 📄 License

MIT License - Free to use for personal or commercial projects

## 👨‍💻 Author

Built as part of the Multi-Framework Ticket Management Web App challenge

## 🤝 Contributing

Contributions welcome! Please ensure:

1. Code follows PSR-12 standards
2. Templates are properly escaped
3. Sessions are managed securely
4. Data validation is thorough

## 📞 Support

Common issues:

**500 Internal Server Error:**

- Check `.htaccess` files exist
- Verify mod_rewrite is enabled
- Check file permissions on `data/` directory

**Session not persisting:**

- Verify session.save_path is writable
- Check PHP session configuration

**Tickets not saving:**

- Ensure `data/` directory is writable (755 or 777)
- Check JSON file permissions (644)

## 🔗 Related Implementations

This is part of a multi-framework project:

- **React Implementation**: See `ticketflow-react/`
- **Vue.js Implementation**: See `ticketflow-vue/`
- **Twig/PHP Implementation**: You are here


