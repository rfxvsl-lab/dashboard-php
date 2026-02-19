# 🚀 Vercel Deployment Guide

## Prerequisites
- GitHub account
- Vercel account (free tier available)
- Project pushed to GitHub

---

## Step 1: Prepare Your Repository

### 1.1 Initialize Git (if not already done)
```bash
cd /workspaces/dashboard-php
git init
git add .
git commit -m "Initial commit: RFX Store Admin Dashboard"
```

### 1.2 Files Already Created for Deployment
✅ **vercel.json** - Tells Vercel how to build your PHP project  
✅ **.gitignore** - Protects sensitive files (.env) from being uploaded  
✅ **config/db.php** - Updated to use environment variables  

---

## Step 2: Push to GitHub

1. Create a new repository on GitHub (https://github.com/new)
   - Repository name: `dashboard-php` (or your choice)
   - Make it **Private** (to protect API keys)

2. Push your local code:
```bash
git remote add origin https://github.com/YOUR_USERNAME/dashboard-php.git
git branch -M main
git push -u origin main
```

---

## Step 3: Deploy to Vercel

### 3.1 Import Project
1. Go to https://vercel.com/dashboard
2. Click **"Add New..."** → **"Project"**
3. Select **"Import Git Repository"**
4. Choose your `dashboard-php` repository
5. Click **"Import"**

### 3.2 Configure Environment Variables
Before deployment, set your Supabase credentials:

1. In the import dialog (or Project Settings), go to **Environment Variables**
2. Add these variables:

| Variable | Value | Example |
|----------|-------|---------|
| `SUPABASE_URL` | Your Supabase project URL | `https://xxxxx.supabase.co` |
| `SUPABASE_KEY` | Your Supabase anon/public key | `eyJhbGci...` (long JWT) |

**Where to find these:**
- Login to [Supabase Dashboard](https://supabase.com/dashboard)
- Select your project
- Click **"Settings"** → **"API"**
- Copy **Project URL** and **Anon/Public API Key**

### 3.3 Deploy
1. Click **"Deploy"**
2. Wait for deployment to complete (usually 1-2 minutes)
3. You'll get a live URL: `https://your-project-name.vercel.app`

---

## Step 4: Test Deployment

After deployment:

1. **Visit your homepage:**
   ```
   https://your-project-name.vercel.app
   ```
   You should see the RFX Store product catalog

2. **Test login:**
   ```
   https://your-project-name.vercel.app/login
   ```
   Try with: `admin@rfxvisual.com` / `admin123`

3. **Check dashboard (if admin):**
   ```
   https://your-project-name.vercel.app/dashboard
   ```

---

## 🔒 Security Checklist

| Item | Status | Notes |
|------|--------|-------|
| `.env` in `.gitignore` | ✅ | Your local secrets stay local |
| Environment Variables on Vercel | ⏳ | Must configure before deploy |
| GitHub repo is Private | ⏳ | Recommended (API keys visible in .env) |
| `config/db.php` uses `getenv()` | ✅ | Already configured |
| `vercel.json` present | ✅ | Already created |

---

## Troubleshooting

### ❌ "500 Internal Server Error" or "Environment variables not configured"

**Solution:** Check Vercel environment variables:
1. Go to **Project Settings** → **Environment Variables**
2. Verify `SUPABASE_URL` and `SUPABASE_KEY` are set
3. Redeploy: Click **Deployments** → (latest) → **Redeploy**

### ❌ "Failed to connect to Supabase"

**Solution:** 
1. Verify API keys are correct in Vercel
2. Check Supabase project is still active
3. Ensure no typos in `SUPABASE_URL`

### ❌ "Clean URLs not working" (e.g., /login.php still shows in URL)

**Solution:** 
- `cleanUrls: true` in `vercel.json` handles this
- Clear browser cache and redeploy
- Vercel may take a few minutes to apply changes

### ❌ "Database connection errors"

**Solution:**
- Check `getenv()` calls in `config/db.php`
- Verify Supabase REST API is accessible (test in Postman)
- Check Supabase project is not paused

---

## Optional: Custom Domain (Paid)

If you want a custom domain (e.g., `rfxstore.com`):
1. In Vercel, go to **Domains**
2. Add your domain
3. Update DNS records at your registrar
4. Vercel provides current DNS values

---

## Environment Variables Reference

### Current Configuration
```
SUPABASE_URL = https://czhkrhtbplafrpevaqst.supabase.co
SUPABASE_KEY = eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
```

### How config/db.php Uses Them

```php
// Priority order:
// 1. getenv('SUPABASE_URL') - Vercel env vars (highest priority)
// 2. $_ENV['SUPABASE_URL'] - From .env file (local dev)
// 3. Error if not found

$supabase_url = getenv('SUPABASE_URL') ?: ($_ENV['SUPABASE_URL'] ?? null);
```

---

## File Structure for Vercel

```
dashboard-php/
├── vercel.json              ← Deployment config
├── .gitignore               ← Protects .env
├── .env                     ← Local credentials (NOT pushed)
├── config/
│   └── db.php               ← Uses getenv() for creds
├── includes/
│   ├── header.php
│   ├── sidebar.php
│   └── footer.php
├── index.php                ← Public homepage
├── dashboard.php            ← Admin dashboard
├── login.php
├── logout.php
├── products.php
├── profile.php
└── [other PHP files]
```

---

## Commands Reference

### Setup for Local Development
```bash
# Install dependencies (if needed)
composer install

# Start local server (for testing)
php -S localhost:8000

# Visit: http://localhost:8000
```

### Prepare for Deployment
```bash
# Check that .gitignore exists
ls -la | grep gitignore

# Verify vercel.json is valid JSON
cat vercel.json | jq .

# Ensure .env is NOT in git (should say 'not tracked')
git status
```

---

## Support & Resources

- **Vercel Docs:** https://vercel.com/docs
- **Vercel PHP Guide:** https://vercel.com/docs/functions/serverless-functions/supported-languages
- **Supabase Docs:** https://supabase.com/docs
- **PHP on Vercel:** Uses `vercel-php@0.6.2` (specified in vercel.json)

---

## 🎉 After Successful Deployment

Once live on Vercel, you can:
1. Share public URL with world
2. Scale automatically (Vercel handles traffic)
3. Monitor deployments and rollback if needed
4. Set custom domain
5. Enable analytics in Vercel dashboard

**Your RFX Store admin dashboard is now ready for production!** 🚀
