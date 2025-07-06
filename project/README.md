# LexiFind - Advanced Thesaurus & Dictionary

A comprehensive PHP-based thesaurus and dictionary application designed for shared hosting environments.

## Features

- **Multi-API Integration**: Free Dictionary API, Oxford Dictionaries, Merriam-Webster, WordsAPI
- **Comprehensive Word Data**: Definitions, synonyms, antonyms, pronunciation, frequency
- **User Management**: Registration, login, search history
- **Premium Features**: Unlimited searches, advanced synonyms, export functionality
- **SEO Optimized**: Clean URLs, meta tags, structured data
- **Mobile Responsive**: Works perfectly on all devices
- **Admin Dashboard**: User management, analytics, system settings

## Requirements

- **PHP 7.4+**
- **MySQL 5.7+** or **MariaDB 10.2+**
- **Apache** with mod_rewrite enabled
- **cURL** extension enabled
- **PDO** extension enabled

## Installation

1. **Upload Files**: Upload all files to your shared hosting account
2. **Database Setup**: Create a MySQL database and import the schema
3. **Configuration**: Update `config/database.php` with your database credentials
4. **API Keys**: Add your API keys to `includes/ApiService.php`
5. **Permissions**: Set proper file permissions (755 for directories, 644 for files)

## API Configuration

### Free Dictionary API
- **No API key required**
- **Rate limit**: 1000 requests/day
- **Primary source** for definitions

### Oxford Dictionaries API
- **App ID**: `4b6e4c8d`
- **API Key**: `b01dd44afc0ef7542a7e463353a46225`
- **Rate limit**: 3000 requests/month (free tier)

### Merriam-Webster API
- **API Key**: `24c5ae52-c432-4f1d-9707-fb4d671c013f`
- **Rate limit**: 1000 requests/day

### WordsAPI (RapidAPI)
- **API Key**: `045f50bd82msh5e87230bba3a598p16ef30jsn7098afb21c07`
- **Rate limit**: 2500 requests/month (free tier)

## File Structure

```
lexifind/
├── index.php                 # Main application entry point
├── includes/
│   ├── ApiService.php        # API integration service
│   ├── header.php           # Site header
│   ├── footer.php           # Site footer
│   ├── search-interface.php # Search form and interface
│   ├── word-display.php     # Word results display
│   └── welcome-section.php  # Welcome/landing section
├── assets/
│   ├── css/
│   │   └── style.css        # Custom styles
│   └── js/
│       └── app.js           # JavaScript functionality
├── config/
│   └── database.php         # Database configuration
├── admin/
│   ├── dashboard.php        # Admin dashboard
│   ├── users.php           # User management
│   └── analytics.php       # Analytics and reports
├── .htaccess               # Apache configuration
└── README.md               # This file
```

## Monetization Features

### Free Tier
- **20 searches per day**
- **Basic definitions** from Free Dictionary API
- **Limited synonyms**
- **Ads displayed**

### Premium Tier ($9.99/month)
- **Unlimited searches**
- **Advanced synonyms** from all APIs
- **Export functionality** (PDF, CSV)
- **Ad-free experience**
- **Search history sync**
- **Priority support**

## SEO Features

- **Clean URLs**: `/word/happy` instead of `/?word=happy`
- **Meta tags**: Dynamic title, description, keywords
- **Structured data**: JSON-LD for search engines
- **Sitemap**: Auto-generated XML sitemap
- **Fast loading**: Optimized CSS/JS, image compression

## Security Features

- **SQL injection protection**: PDO prepared statements
- **XSS prevention**: Input sanitization and output escaping
- **CSRF protection**: Token-based form validation
- **Rate limiting**: API and search rate limits
- **Secure headers**: X-Frame-Options, CSP, etc.

## Performance Optimization

- **Caching**: File-based caching for API responses
- **Compression**: Gzip compression enabled
- **CDN ready**: Static assets can be served from CDN
- **Database optimization**: Proper indexing and queries

## Deployment

### Shared Hosting (Recommended)
1. Upload files via FTP/cPanel File Manager
2. Create MySQL database through hosting control panel
3. Update configuration files
4. Set up cron jobs for maintenance tasks

### VPS/Dedicated Server
1. Configure Apache virtual host
2. Set up SSL certificate
3. Configure firewall rules
4. Set up automated backups

## Maintenance

### Daily Tasks
- Monitor API usage and limits
- Check error logs
- Review user registrations

### Weekly Tasks
- Database optimization
- Cache cleanup
- Security updates

### Monthly Tasks
- Analytics review
- Performance optimization
- Feature updates

## Support

For technical support or questions:
- **Email**: support@lexifind.com
- **Documentation**: [docs.lexifind.com](https://docs.lexifind.com)
- **GitHub**: [github.com/lexifind/lexifind](https://github.com/lexifind/lexifind)

## License

This project is licensed under the MIT License. See LICENSE file for details.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## Changelog

### Version 1.0.0 (2024-01-01)
- Initial release
- Multi-API integration
- User management system
- Premium features
- Admin dashboard