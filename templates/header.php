<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuotesValley - Quotes and Sayings</title>
    <style><?php include __DIR__.'/style.css';?> </style>
    <style><?php include __DIR__.'/bg-svg.css';?> </style>
     <link rel="icon" type="image/x-icon" href="https://quotesvalley.com/assets/images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body style="background-color: #92b79b;">
    
    <nav class="navbar navbar-expand-lg navbar-light bg-nav">
    <div class="container-fluid">
    <a class="navbar-brand" href="/" tyle="color: #fafafa; text-decoration: none; font-size: 2.5rem;">QuotesValley.com</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/category">Quotes By Category</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/author">Quotes By Author</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/category/Hindi">Hindi Quotes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#submitModal" onclick="openModal()">Submit a Quote</a>
        </li>
      </ul>
      <span class="navbar-text">
        Welcome to QuotesValley
      </span>
    </div>
  </div>
</nav>