<?php
session_start();
require_once __DIR__.'/router.php';


// Static GET
// In the URL -> http://localhost
// The output -> Index
get('/', 'index.php');

get('/category', 'pages/category.php');

get('/author', 'pages/author.php');

get('/category/$category', 'pages/quotes.php');
get('/author/$author', 'pages/quotes.php');

get('/contact', '/pages/contact.php');

get('/about', '/pages/about.php');

get('/adminlogin', '/admin/admin_login.php');

post('/adminlogin', '/admin/admin_login.php');

get('/page/$page', 'pages/quotes.php');

get('/category/$category/page/$page', 'pages/quotes.php');

get('/author/$author/page/$page', 'pages/quotes.php');

post('/api', 'ajax_call.php');

post('/submitquotes', 'includes/submit_quote.php');

get('/adminpanel', 'admin/admin_panel.php');

post('/adminpanel', 'admin/admin_panel.php');

get('/adminlogout', 'admin/admin_logout.php');

get('/sitemap', '/sitemap.php');







// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','pages/404.php');
