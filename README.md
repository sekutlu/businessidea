# Business Idea Platform - IdeateHub

A comprehensive SaaS platform for creating, managing, and refining business ideas collaboratively.

## Features Implemented

### Core Features (SRS Compliant)
- ✅ User Registration & Login with role-based access (Entrepreneur, Mentor, Investor)
- ✅ Idea Creation Wizard with step-by-step guided process
- ✅ Industry-specific templates (Technology, Agriculture, Services, Retail, Healthcare, Education)
- ✅ Forward and Reverse-Mode idea development
- ✅ Collaboration system with role-based permissions
- ✅ Dashboard with progress tracking and analytics
- ✅ Gamification system with credibility points
- ✅ Verification scoring system
- ✅ Activity logging and tracking
- ✅ Comments and feedback system
- ✅ Subscription management (Free, Monthly, Annual)
- ✅ Auto-save functionality
- ✅ Progress percentage calculation

### Technical Features
- Secure authentication with password hashing
- PDO database connection with prepared statements
- Session management
- Responsive design with Tailwind CSS
- Clean MVC-inspired architecture

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer (optional)

### Setup Steps

1. **Clone the repository**
   ```bash
   cd /path/to/your/webserver
   git clone <repository-url> businessidea
   ```

2. **Configure Database**
   - Create MySQL database:
     ```sql
     CREATE DATABASE businessidea;
     ```
   
   - Import schema:
     ```bash
     mysql -u root -p businessidea < config/schema.sql
     ```
   
   - Update database credentials in `config/database.php`:
     ```php
     $username = 'root';
     $password = 'password1';
     ```

3. **Set Permissions**
   ```bash
   chmod -R 755 /path/to/businessidea
   chmod -R 777 /path/to/businessidea/uploads  # Create this folder for file uploads
   ```

4. **Configure Web Server**
   
   For Apache, ensure `.htaccess` is enabled or add to your virtual host:
   ```apache
   <Directory /path/to/businessidea>
       AllowOverride All
       Require all granted
   </Directory>
   ```

5. **Access the Application**
   - Navigate to: `http://localhost/businessidea/`
   - Register a new account or use default credentials:
     - Email: admin@ideatehub.com
     - Password: admin123

## Project Structure

```
businessidea/
├── config/
│   ├── database.php       # Database connection
│   └── schema.sql         # Database schema
├── includes/
│   ├── header.php         # Reusable header
│   ├── footer.php         # Reusable footer
│   └── functions.php      # Helper functions
├── pages/
│   ├── dashboard.php      # User dashboard
│   ├── login.php          # Login page
│   ├── register.php       # Registration page
│   ├── idea_wizard.php    # Idea creation wizard
│   ├── idea_view.php      # View idea details
│   ├── my_ideas.php       # List all user ideas
│   ├── subscription.php   # Subscription management
│   └── upcoming_feature.php
├── assets/
│   ├── css/
│   │   └── theme.css      # Custom styles
│   └── js/
├── index.php              # Landing page
└── README.md
```

## Usage Guide

### Creating a Business Idea

1. **Login/Register** - Create an account or login
2. **Choose Mode**:
   - **Forward Mode**: Start with problem → solution → execution
   - **Reverse Mode**: Start with end goal → work backward to problem
3. **Follow Wizard**: Complete 7 steps with guided prompts
4. **Track Progress**: Monitor completion percentage
5. **Collaborate**: Invite team members, mentors, or investors
6. **Get Feedback**: Receive comments and suggestions

### Subscription Plans

- **Free**: 3 ideas, basic templates
- **Monthly (L290)**: Unlimited ideas, collaboration, analytics
- **Annual (L2,490)**: All features + investor matching, mentor access (Save L990)

### Gamification

- Earn credibility points for:
  - Creating ideas: +10 points
  - Updating ideas: +5 points
  - Completing milestones: +15 points
  - Receiving positive feedback: +20 points

## Database Schema

### Main Tables
- `users` - User accounts and profiles
- `ideas` - Business ideas
- `collaborators` - Team members on ideas
- `comments` - Feedback and discussions
- `activity_log` - User activity tracking
- `media` - File uploads
- `milestones` - Idea milestones

## Security Features

- Password hashing with bcrypt
- SQL injection prevention with prepared statements
- Session-based authentication
- Role-based access control (RBAC)
- Input validation and sanitization

## Future Enhancements

- File upload functionality for media
- Export to PDF/Excel
- Search functionality with external API integration
- Real-time collaboration
- Email notifications
- Investor matching algorithm
- Advanced analytics dashboard
- Mobile app

## Support

For issues or questions:
- Email: support@ideatehub.com
- Documentation: /docs

## License

Proprietary - All rights reserved

## Version

1.0.0 - Initial Release (November 2025)
