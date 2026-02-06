# Quick Start Guide - IdeateHub Business Idea Platform

## 🚀 Get Started in 3 Minutes

### Step 1: Setup Database (1 minute)

1. Open your browser and navigate to:
   ```
   http://localhost/businessidea/setup.php
   ```

2. The setup script will automatically:
   - Create the database
   - Create all tables
   - Insert default admin user
   - Show success message

3. **Important**: Delete `setup.php` after successful installation

### Step 2: Login (30 seconds)

1. Go to: `http://localhost/businessidea/`
2. Click "Get Started" or "Log in"
3. Use default credentials:
   - **Email**: admin@ideatehub.com
   - **Password**: admin123

### Step 3: Create Your First Idea (1.5 minutes)

1. From dashboard, click "New Idea"
2. Choose your mode:
   - **Forward Mode**: Start with problem, end with execution plan
   - **Reverse Mode**: Start with end goal, work backward to problem
3. Complete the 7-step wizard
4. Watch your progress increase!

---

## 📋 What You Can Do

### For Entrepreneurs
- ✅ Create unlimited business ideas (with subscription)
- ✅ Use industry-specific templates
- ✅ Track progress with visual dashboards
- ✅ Earn credibility points
- ✅ Export ideas as reports

### For Mentors
- ✅ Review and comment on ideas
- ✅ Collaborate with entrepreneurs
- ✅ Provide structured feedback
- ✅ Track mentee progress

### For Investors
- ✅ Evaluate business ideas
- ✅ View verification scores
- ✅ Access detailed business plans
- ✅ Connect with entrepreneurs

---

## 🎯 Key Features to Try

### 1. Idea Wizard
Navigate to: Dashboard → New Idea
- Choose Forward or Reverse mode
- Complete 7 guided steps
- See real-time progress

### 2. Collaboration
Navigate to: My Ideas → View Idea → Invite Collaborator
- Add team members
- Assign roles and permissions
- Work together in real-time

### 3. Search
Navigate to: Search (top menu)
- Search your ideas
- Find external resources
- Integrate with Google, YouTube, LinkedIn

### 4. Subscription
Navigate to: Dashboard → Subscription
- View current plan
- Upgrade to unlock features
- Manage billing

---

## 💡 Tips & Tricks

1. **Earn Points Fast**
   - Create ideas: +10 points
   - Update ideas: +5 points
   - Complete milestones: +15 points

2. **Use Reverse Mode**
   - Great for goal-oriented planning
   - Start with your vision
   - Work backward to identify steps

3. **Collaborate Effectively**
   - Invite mentors for guidance
   - Add investors for funding insights
   - Assign specific roles

4. **Track Progress**
   - Dashboard shows completion %
   - Activity log tracks all changes
   - Comments provide feedback

---

## 🔧 Troubleshooting

### Can't Login?
- Check database is running
- Verify credentials: admin@ideatehub.com / admin123
- Clear browser cache

### Database Error?
- Ensure MySQL is running
- Check credentials in `config/database.php`
- Re-run `setup.php`

### Page Not Found?
- Check .htaccess is enabled
- Verify file paths
- Ensure mod_rewrite is enabled

---

## 📱 Navigation Guide

```
Homepage (index.php)
├── Register → Create Account
├── Login → Dashboard
│   ├── My Ideas → View All Ideas
│   │   └── View Idea → Idea Details
│   │       ├── Edit → Wizard
│   │       ├── Comment → Add Feedback
│   │       └── Invite → Add Collaborators
│   ├── New Idea → Wizard (7 steps)
│   ├── Search → Find Ideas
│   └── Subscription → Manage Plan
└── Pricing → View Plans
```

---

## 🎓 Sample Workflow

### Creating a Tech Startup Idea

1. **Login** → Dashboard
2. **Click** "New Idea" → Choose "Forward Mode"
3. **Step 1**: Name it "AI-Powered Study Assistant"
4. **Step 2**: Problem - "Students struggle with personalized learning"
5. **Step 3**: Solution - "AI adapts to learning style"
6. **Step 4**: Market - "College students, 18-25 years"
7. **Step 5**: Revenue - "Freemium subscription model"
8. **Step 6**: Advantage - "Personalized AI algorithms"
9. **Step 7**: Execution - "MVP in 3 months, beta testing"
10. **Complete** → View your idea with 100% progress!

---

## 📊 Understanding Your Dashboard

- **Total Ideas**: Number of ideas you've created
- **Collaborators**: People working with you
- **Credibility Points**: Your reputation score
- **Completion Rate**: Average progress across ideas

---

## 🔐 Security Notes

- Passwords are hashed with bcrypt
- Sessions expire after inactivity
- SQL injection protected
- HTTPS ready for production

---

## 🆘 Need Help?

- Check `README.md` for detailed documentation
- Review `IMPLEMENTATION.md` for technical details
- Contact: support@ideatehub.com

---

## 🎉 You're Ready!

Start building your business ideas now. The platform is fully functional and ready to use.

**Happy Ideating! 💡**
